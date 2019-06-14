<?php
$voteWords = explode("," , __('votes.votes'));
$pointWords = explode("," , __('votes.points'));
?>
<section class="vote-results">
  <div class="vote-results__container container">
    <header class="vote-results__wrapper vote-results__wrapper--header">
      <h1 class="vote-results__title">{{$team->getTranslatedAttribute('name')}}</h1>
    </header>
  @foreach($judgeVotes as $stageName => $flows )
    <table class="vote-results__wrapper vote-results__wrapper--qualifying">
      <thead class="vote-results__thead vote-results__thead--outer">
        <tr class="vote-results__tr vote-results__tr--outer">
          <th>{{$stageName}}:</th>
          <?php $stageScores = array_sum($judgeScores[$stageName]); ?>
          <th class="vote-results__num">{{$stageScores.' '.declOfNum($stageScores, $pointWords)}}</th>
        </tr>
      </thead>
      <tbody class="vote-results__tbody">
        <tr class="vote-results__tr vote-results__tr--inner">
          @foreach($flows as $flowName => $judges)
          <td>
            <table>
              <thead class="vote-results__thead">
                <tr class="vote-results__tr">
                  <th>{{$flowName}}</th>
                  <th class="vote-results__num">{{$judgeScores[$stageName][$loop->index].' '.declOfNum($judgeScores[$stageName][$loop->index], $pointWords)}}</th>
                </tr>
              </thead>
              <tbody class="vote-results__tbody">
                @foreach($judges as $judgeName => $votes)
                  <tr class="vote-results__tr vote-results__tr--judge-name">
                    <th>{{$judgeName}}</th>
                    <th></th>
                  </tr>
                  @foreach($votes as $vote)
                  <tr class="vote-results__tr">
                    <td>{{__('judge_votes.'.$vote->criterion)}}</td>
                    <td class="vote-results__num">{{$vote->score}}</td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </td>
          @endforeach
        </tr>
      </tbody>
      @if($loop->first)
      <tfoot class="vote-results__tfoot">
        <tr class="vote-results__tr vote-results__tr--outer">
          <td>@lang('votes.online_vote')</td>
          <td class="vote-results__num">{{number_format($onlineVotesCount, 0, '', ' ').' '.declOfNum($onlineVotesCount, $voteWords)}}</td>
        </tr>
      </tfoot>
      @elseif($loop->last)
      <tfoot class="vote-results__tfoot">
        <tr class="vote-results__tr vote-results__tr--outer">
          <td>@lang('votes.audience_vote')</td>
          <td class="vote-results__num">{{number_format($audienceVotesCount, 0, '', ' ').' '.declOfNum($audienceVotesCount, $voteWords)}}</td>
        </tr>
      </tfoot>
      @endif
    </table>
  @endforeach
  </div>
</section>
