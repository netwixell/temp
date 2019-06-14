<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\NewOnlineVoteEvent;

use Carbon\Carbon;

use Validator;
use Illuminate\Validation\Rule;

use App\Page;
use App\Team;
use App\Poll;
use App\OnlineVote;
use App\JudgeVote;

class VoteController extends Controller
{
  public function pageVote(){

    $locale = \App::getLocale();

    $page = Page::findBySlug('dream-team.vote')
      ->has('blocks')
      ->with(['blocks' =>function($query) use ($locale){
        $query->withTranslation($locale)->where('type', \App\PageBlock::TYPE_LEVEL_1);
      }])
      ->firstOrFail();

    $headerBlock = $page->blocks->first();

    return view('web-site.vote', compact('page', 'headerBlock') );
  }
  public function pageVoteResults(Request $request, $teamSlug){

    $page = Page::findBySlug('dream-team.vote-results')
    ->with(['poll' => function($query){

      $query->with(['children'=>function($query){
        $query->withTranslation();
      }])
      ->withTranslation();

    }])
    ->withTranslation()
    ->firstOrFail();

    $onlinePoll = $page->poll->children->where('type', Poll::TYPE_ONLINE)->first();
    $audiencePoll = $page->poll->children->where('type', Poll::TYPE_AUDIENCE)->first();
    $judgePollIds = $page->poll->children->where('type', Poll::TYPE_JUDGE)->pluck('id')->toArray();

    if(!$onlinePoll->isOver) return redirect('dream-team/vote');

    $teamQuery = Team::findBySlug($teamSlug);

    if(isset($onlinePoll)){

      $teamQuery->withCount(['onlineVotes as onlineVotesCount' => function($query) use ($onlinePoll){

        $query->where('poll_id', $onlinePoll->id);

      }]);

    }

    if(isset($audiencePoll)){

      $teamQuery->with(['audienceVotes' => function($query) use ($audiencePoll){

        $query->where('poll_id', $audiencePoll->id);

      }]);

    }

    if(isset($judgePollIds) && count($judgePollIds) > 0){

      $teamQuery->with(['judgeVotes' => function($query) use ($judgePollIds){

        $query->whereHas('judgePoll', function($query) use ($judgePollIds) {
          $query->whereIn('poll_id', $judgePollIds);
        })
        ->with(['judgePoll' => function($query){
          $query->with(['poll'=>function($query){
            $query->withTranslation();
          },'user:id,name', 'flow'=>function($query){
            $query->withTranslation();
          }]);
        }]);

      }]);

    }

    $team = $teamQuery->withTranslation()->firstOrFail();

    $onlineVotesCount = $team->onlineVotesCount ?: 0;
    $audienceVote = $team->audienceVotes->first();
    $audienceVotesCount = isset( $audienceVote ) ? $audienceVote->score : 0;

    $judgeVotes = $team->judgeVotes->sortBy('judgePoll.poll.begin_at')->groupBy(function($item){
      return $item->judgePoll->poll->getTranslatedAttribute('name');
    });
    $judgeVotes = $judgeVotes->map(function($votes, $key){
      $votes = $votes->sortBy('judgePoll.flow.order')->groupBy(function($item){
        return $item->judgePoll->flow->getTranslatedAttribute('name');
      });

      $votes = $votes->map(function($votes, $key){
        $votes = $votes
          ->sortBy(function($vote){
            return ($vote->judgePoll->user_id == $vote->judgePoll->flow->user_id) ? -1 : $vote->judgePoll->user->name;
          })
          ->groupBy(function($item){
            return getLocaleString($item->judgePoll->user->name);
          });

          $votes = $votes->map(function($votes){
              return $votes->sortBy(function($vote){
                return array_search($vote->criterion, JudgeVote::$criteria);
              });
            });

        return $votes;
      });

      return $votes;
    });

    $judgeScores = $judgeVotes->map(function($flows, $key){
      $scoreByFlows = [];
      foreach($flows as $judges){
        $scoreByFlow = 0;
        foreach($judges as $votes){
          $scoreByFlow += $votes->sum('score');
        }
        $scoreByFlows[] = $scoreByFlow;
      }
      return $scoreByFlows;

    });

    return view('web-site.vote-results', compact('page', 'team', 'onlineVotesCount', 'audienceVotesCount', 'judgeVotes', 'judgeScores') );
  }

  public function giveVote(Request $request){

    $team_id = $request->input('team_id');

    $page = Page::findBySlug('dream-team.vote')
      ->with(['poll' => function($query){

        $query->with(['children' => function($query){
          $query->online()->first();
        }]);

      }])
      ->firstOrFail();

    $val = $this->validateVote($request->all(), $page->event_id);

    if ($val->fails()) {
      return response()->json(['errors' => $val->messages()]);
    }

    $poll = $page->poll->children->first();

    if(!isset($poll)) return response()->json(['errors' => ['Poll not found!'] ]);

    if(!$poll->isOpen || !$this->canVoteToday($request, $poll) || !$this->checkIPandUA($request, $poll)){
      return response()->json(['errors' => ['Poll is not available!'] ]);
    }

    $nowDateTime = Carbon::now()->toDateTimeString();

    $onlineVote = new OnlineVote();
    $onlineVote->poll_id = $poll->id;
    $onlineVote->team_id = $team_id;

    $onlineVote->user_ip = ip2long($request->ip());
    $onlineVote->user_agent = $request->header('user-agent');

    $onlineVote->created_at = $nowDateTime;

    $onlineVote->save();

    $voteDates = $request->session()->get("poll-{$poll->id}", []);

    $voteDates[] = $nowDateTime;

    $request->session()->put("poll-{$poll->id}", $voteDates);

    broadcast(new NewOnlineVoteEvent($onlineVote));

    $responseJSON['isVotedCaption'] = __('votes.is_voted_caption');

    return response()->json(['success'=> true, 'message'=> 'Vote accepted', 'isVotedCaption' => __('votes.is_voted_caption')]);
  }

  public function validateVote($request, $event_id){

    return Validator::make($request, [
        'team_id' => ['required',
            Rule::exists('teams','id')->where(function ($query) use ($event_id) {
             $query->where([
                ['status', '=', Team::STATUS_PAID],
                ['event_id', '=', $event_id]
               ]);
            }),
          ]
      ]);
  }

  public function teams(Request $request){
    // if ($request->ajax()) {}

    $skip = $request->query('skip',0);
    $take = $request->query('take',6);

    $page = Page::findBySlug('dream-team.vote')
      ->with(['poll' => function($query){
        $query->with(['children']);
      }])
      ->withTranslation()
      ->firstOrFail();

    $onlinePoll = $page->poll->children->where('type', Poll::TYPE_ONLINE)->first();
    $judgePoll = $page->poll->children->where('type', Poll::TYPE_JUDGE)->sortBy('begin_at')->first();

    if(!isset($onlinePoll)) return response()->json(['errors' => ['Poll not found!'] ]);

    if($onlinePoll->isOpen){
      $state =  ( $this->canVoteToday($request, $onlinePoll) && $this->checkIPandUA($request, $onlinePoll) ) ? 1 : 2;
    } elseif($page->poll->isOver){
      $state = 0;
    } elseif($onlinePoll->isOver) {
      $state = 3;
    } else return response()->json(['errors' => ['The poll has not started yet'] ]);

    $teamsQuery = Team::where([
        ['status', '=', Team::STATUS_PAID],
        ['event_id', '=', $page->event_id]
      ])
      ->withTranslation()
      ->withCount(['onlineVotes as votesCount' => function($query) use ($onlinePoll){
        $query->where('poll_id', $onlinePoll->id);
      }]);

    if($request->has('board')){

      $teamsQuery->take(100)->orderBy('votesCount', 'desc')->orderBy('name');

    } else {
      $teamsQuery->skip($skip)->take($take);

      if($state > 0 && $state < 3){
        $ip = str_replace('.', '', $request->ip());
        $teamsQuery->orderByRaw("RAND(?)", [$ip + date('Hjn')]);
      } else {

        $teamsQuery->with(['judgeVotes' => function($query) use ($judgePoll){

          $query->whereHas('judgePoll', function($query) use ($judgePoll) {
            $query->where('poll_id', $judgePoll->id);
          });

        }]);

        $teamsQuery->orderByRaw('badge IS NULL, FIELD(badge, "'.implode('","',Team::$badges).'"), votesCount DESC, name ASC');

      }

      if($page->show_adv){
        $commercial = \App\Advertisement::inRandomOrder()->withTranslation()->first();
        $commercial->title = $commercial->getTranslatedAttribute('title');
        $commercial->caption = $commercial->getTranslatedAttribute('caption');
        $commercial->link_title = $commercial->getTranslatedAttribute('link_title');
      }

    }

    $teams = $teamsQuery->get();

    $responseJSON = [
      'success'=>true,
      'locale' => app()->getLocale(),
      'voteState'=> $state,
      'pollId'=> $onlinePoll->id,
      'commercialCaption'=> __('commercial.caption'),
      'commercial' => isset($commercial) ? $commercial->toArray() : null,
    ];

    if($state == 0 || $state == 3){
      $teams = $teams->map(function($team){
        $team->append('online_votes_caption')
          ->append('judge_votes_caption')
          ->append('badge_caption')
          ->append('vote_results_url');
        return $team;
      });
    } else {
      if($state == 2) $responseJSON['isVotedCaption'] = __('votes.is_voted_caption');

      $responseJSON['giveVoteCaption'] = __('votes.give_vote');
      $responseJSON['scoredCaption'] = __('votes.scored');
      $responseJSON['votesCaption'] = __('votes.votes');

    }

    if(isset($teams)){
      $teams = $teams->map(function($team){
        $team->name = $team->getTranslatedAttribute('name');
        return $team;
      });

      $responseJSON['teams'] = $teams->toArray();
    }

    /**
     * States:
     * 0 - competition is over
     * 1 - poll is open
     * 2 - vote accepted
     * 3 - online poll is over
     */

    return response()->json($responseJSON);
  }

  public function checkIPandUA(Request $request, Poll $poll){

    $userIP = ip2long($request->ip());
    $userAgent = $request->header('user-agent');

    $sameVotesCount = OnlineVote::where([
        ['poll_id', '=', $poll->id],
        ['user_ip', '=', $userIP],
        ['user_agent', '=', $userAgent],
      ])
      ->whereDate('created_at', now()->toDateString())
      ->count();

    return ($sameVotesCount < 5);
  }

  public function canVoteToday(Request $request, Poll $poll){

    $voteDates = $request->session()->get("poll-{$poll->id}", []);

    $lastVote = end($voteDates);

    return !( $lastVote && now()->diffInDays( $lastVote ) == 0 );
  }
}
