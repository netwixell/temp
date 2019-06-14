<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageBlock;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Mail;

use App\Role;
use Notification;
use App\Notifications\NewTeam;
use App\Notifications\NewCallback;

use Validator;


class PageController extends Controller
{
    public function show($slug){

      $template='page.main';
      if($page = Page::findBySlug($slug)){

	      if(isset($page->slug)){
	      	$page_template='page.'. $page->slug;

	      	  if (view()->exists($page_template)) {
                     $template=$page_template;
			    }
	      }
	      return view($template, ['page' => $page]);
	   }
	   return abort(404);
    }
    public function main(){

      $page = Page::findBySlug('main')
        ->has('event')
        ->with(['event'=>function($query){

          $query->with(['tickets'=>function($query){

            $query->sale()->with(['early_birds'=>function($query){
                  $query->current();
                },'options'=>function($query){
                  $query->withPivot('group')->withTranslation()->orderBy('type','desc')->orderBy('option_id','asc');
                },'installments' =>function($query){
                  $query->available();
                }])
                ->withTranslation()
                ->orderBy('order','asc');

            }, 'partners'=>function($query){

              $query->orderBy('name','asc')->take(3);

            }, 'persons'=>function($query){

              $query->speakers()->has('flow')->with(['flow'=>function($query){
                $query->withTranslation();
              },'person'=>function($query){
                $query->with('contacts')->withTranslation();
              }])->withTranslation();

            }])
            ->withCount(['partners'])
            ->withTranslation();

        }])
        ->withTranslation()
        ->firstOrFail();

      $event = $page->event;

      $event_persons = $event->persons->sortBy('flow.order')->groupBy(function($person){
        return $person->flow->getTranslatedAttribute('name');
      });

      $advertisements = [];

      if($page->show_adv){
        $advertisements = \App\Advertisement::take(10)->withTranslation()->inRandomOrder()->get();
      }

      $quotes = [];

      if($page->show_quotes){
        $quotes = \App\Quote::with([
          'person'=> function($query){ $query->withTranslation();}
          ])
          ->withTranslation()
          ->take(2)->inRandomOrder()->get();
      }

      $ticket_selling = setting('osnovnoe.ticket_selling');

      return view('web-site.index',compact('page', 'event','event_persons', 'quotes', 'advertisements', 'ticket_selling'));
    }
    public function throwback(){
      $page = Page::findBySlug('throwback')
        ->has('event')
        ->with('event')
        ->withTranslation()
        ->firstOrFail();

      return view('web-site.throwback', ['page'=>$page]);
    }
    public function dreamTeam(){

      $page = Page::findBySlug('dream-team')
        ->has('event')
        ->with(['event'=>function($query){

          $query->with(['partners'=>function($query){

            $query->withTranslation()->orderBy('name','asc')->take(3);

          }, 'persons'=>function($query){

            $query->mainJudges()->has('flow')->with(['flow','person'=>function($query){
              $query->withTranslation();
            }])
            ->withTranslation()
            ->orderBy('order','asc');

          }])
          ->withCount(['partners','persons'=>function($query){

            $query->judges()->has('flow');

          }])->withTranslation();

        },'poll'=>function($query){

          $query->with(['children'=>function($query){
            $query->online();
          }]);

        }])
        ->withTranslation()
        ->firstOrFail();

      $event = $page->event;

      $event_judges = $event->persons->sortBy('flow.order');

      if(isset($page->poll)){
        $childPoll = $page->poll->children->first();
        if(isset($childPoll)){
          $onlinePoll = $childPoll;
        } else {
          $onlinePoll = $page->poll;
        }
      }

      $teamsQuery = Team::registered()->where('event_id', $page->event_id)
        ->withCount(['onlineVotes as votesCount' => function($query) use ($onlinePoll){
          $query->where('poll_id', $onlinePoll->id);
        }]);

      if(isset($onlinePoll)){
        if($onlinePoll->isOpen){
          $teamsQuery->orderByRaw('FIELD(status,"PAID","ACCEPTED","EXPELLED"), votesCount DESC, name ASC');
        } elseif($onlinePoll->isOver){
          $teamsQuery->orderByRaw('FIELD(status,"PAID","ACCEPTED","EXPELLED"), badge IS NULL, FIELD(badge, "'.implode('","',\App\Team::$badges).'"), votesCount DESC, name ASC');
        } else {
          $teamsQuery->orderByRaw('FIELD(status,"PAID","ACCEPTED","EXPELLED"), created_at ASC');
        }
      } else {
        $teamsQuery->orderByRaw('FIELD(status,"PAID","ACCEPTED","EXPELLED"), created_at ASC');
      }

      $teams = $teamsQuery->get();

      $prizes = \App\Prize::take(20)->withTranslation()->orderBy('order')->get();

      $advertisements = [];

      if($page->show_adv){
        $advertisements = \App\Advertisement::take(10)->withTranslation()->inRandomOrder()->get();
      }

      return view('web-site.dream-team', compact('page', 'event','event_judges','advertisements', 'onlinePoll', 'teams', 'prizes'));
    }
    public function dtRules(){

      $page = Page::findBySlug('dream-team.rules')
        ->has('blocks')
        ->with(['blocks'=>function($query){

          $query->where('type',PageBlock::TYPE_LEVEL_2)->with(['children'=>function($query){

            $query->with(['children'=>function($query){

              $query
                ->withTranslation()
                ->orderBy('order', 'asc')
                ->whereIn('type', [PageBlock::TYPE_LEFT_COLUMN, PageBlock::TYPE_RIGHT_COLUMN]);

            }])
            ->withTranslation()
            ->withCount(['children'])
            ->whereIn('type', [PageBlock::TYPE_LEVEL_3, PageBlock::TYPE_CAPTION])
            ->orderBy('order','asc');

          }])
          ->withTranslation()
          ->where('type', PageBlock::TYPE_LEVEL_2)
          ->orderBy('order','asc');

        }])
        ->withTranslation()
        ->firstOrFail();

        $blocks = $page->blocks;

        return view('web-site.rules', compact('page', 'blocks'));
    }
    public function recreation(){
      $page = Page::findBySlug('recreation')->withTranslation()->firstOrFail();

      return view('web-site.recreation', ['page'=>$page]);
    }
    public function privacy(){
      $page = Page::findBySlug('privacy')->withTranslation()->firstOrFail();
      return view('web-site.privacy',['page'=>$page]);
    }
    public function schedule(){

      $page = Page::findBySlug('schedule')
        ->has('event')
        ->with(['event' => function($query){

          $query->with(['schedule' => function($query){

            $query
                ->with(['flow'=>function($query){
                  $query->withTranslation();
                },'persons'=>function($query){
                  $query->withTranslation();
                },'partners'=>function($query){
                  $query->withTranslation();
                },'badges'=>function($query){
                  $query->withTranslation();
                }])
                ->withTranslation()
                ->orderBy('start_date', 'asc')
                ->orderBy('start_time', 'asc');

          }]);
        }])
        ->withTranslation()
        ->firstOrFail();

      $event = $page->event;

      $schedule = $event->schedule->groupBy('start_date');

      $schedule = $schedule->map(function($dateGroup){
        return $dateGroup->groupBy(function($item){
            return isset($item->flow) ? $item->flow->getTranslatedAttribute('name') : null;
          });
      });

      return view('web-site.schedule',['page'=>$page, 'schedule'=>$schedule]);
    }

    public function dtRegistration(Request $request){

      $slug = str_slug($request->name, '-');

      $request->merge(['slug' => $slug]);

      $val = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'slug' => 'required|unique:teams,slug',
        'contact_name' => 'required|max:255',
        'phone' => 'required|min:9|max:13|phone:AUTO,UA',
        'email'=> 'required|email',
        'city' => 'required|max:255'
      ],[
        'slug.unique' => __('teams.team_already_registered'),
      ]);

      if ($val->fails()) {
        return response()->json(['errors' => $val->messages()],422);
      }

        $page = \App\Page::where('slug', 'dream-team')->firstOrFail();

        $team = new \App\Team();

        $team->event_id = $page->event_id;

        $team->slug = $slug;
        $team->name = $request->name;
        $team->contact_name = $request->contact_name;
        $team->phone = $request->phone;
        $team->email = $request->email;
        $team->city = $request->city;

        $team->save();

        event(new \App\Events\NewTeamEvent($team));

        Mail::to( $team->email )->send(new \App\Mail\NewTeam($team, app()->getLocale()));

    	if ($request->ajax()) {
          return response()->json([
              'message'    =>  trans('messages.success'),
              'alert-type' => 'success',
              'type' => 'ajax'
          ]);
        }
       return back()->with('success', trans('messages.success'));
    }

    public function callback(Request $request){

    	 $this->validate($request, [
            'name' => 'required|max:255',
            'email'=> 'required|email',
        		'phone' => 'required|min:9|max:13|phone:AUTO,UA',
        		'question' => 'nullable|not_regex:@((https?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@|max:65535'
       ],[
         'not_regex' => __('errors.question_contains_link')
         ]);
        $callback = \App\Callback::create($request->all());

        event(new \App\Events\NewCallbackEvent($callback));

    	if ($request->ajax()) {
          return response()->json([
              'message'    =>  trans('messages.success'),
              'alert-type' => 'success',
              'type' => 'ajax'
          ]);
        }
       return back()->with('success', trans('messages.success'));
    }

    public function partners(Request $request){

      if ($request->ajax()) {

        $skip = $request->query('skip',0);

        $event=\App\Event::where('slug','molfar-forum')
          ->with(['partners' => function($query) use ($skip){
            $query->orderBy('name','asc')->withTranslation()->skip($skip)->take(1000);
          }])
          ->firstOrFail();

        $partners = $event->partners;

        $partner_items = [];


        foreach($partners as $partner){
          $partner_items[] = view('web-site.partner.partner',['partner'=>$partner])->render();
        }

        return response()->json([
                      'message'    =>  trans('messages.success'),
                      'alert-type' => 'success',
                      'type' => 'ajax',
                      'html' => $partner_items
                  ]);
      }

    }

    public function dtSponsors(Request $request){

      if ($request->ajax()) {

        $skip = $request->query('skip',0);

        $event=\App\Event::where('slug','dream-team')
          ->with(['partners' => function($query) use ($skip){
            $query->orderBy('name','asc')->withTranslation()->skip($skip)->take(1000);
          }])
          ->firstOrFail();

        $partners = $event->partners;

        $partner_items = [];

        foreach($partners as $partner){
          $partner_items[] = view('web-site.sponsor.sponsor',['sponsor'=>$partner])->render();
        }

        return response()->json([
                      'message'    =>  trans('messages.success'),
                      'alert-type' => 'success',
                      'type' => 'ajax',
                      'html' => $partner_items
                  ]);
      }

    }

    public function dtJudges(Request $request){

      if ($request->ajax()) {

        $event=\App\Event::where('slug','dream-team')
          ->with(['persons' => function($query){

            $query->commonJudges()->has('flow')->with(['flow','person'=>function($query){
              $query->withTranslation();
            }])
            ->withTranslation()
            ->orderBy('order','asc');

          }])
          ->firstOrFail();

        $judges = $event->persons->sortBy('flow.order');

        $judge_items = [];

        foreach($judges as $judge){
          $judge_items[] = view('web-site.dream-team__judge.dream-team__judge',['judge'=>$judge])->render();
        }

        return response()->json([
                      'message'    =>  trans('messages.success'),
                      'alert-type' => 'success',
                      'type' => 'ajax',
                      'html' => $judge_items
                  ]);
      }

    }


    public function language($lang){
        /**
       * whenever you change locale
       * by passing language ISO code (like en, pl, pt-BR etc.)
       * add/update passed language to a session value with key 'locale'
       */
       Session::put('locale', $lang);

      /**
       * and now return back to a page
       * on which you changed language
       */
       return back()->with('lang', $lang);
    }
}
