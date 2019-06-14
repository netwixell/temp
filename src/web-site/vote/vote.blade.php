{{-- .vote--isVoted — Состояние секции, когда пользователь уже проголосовал --}}
<section class="vote">
  <div class="vote__container container">
    <header class="vote__wrapper vote__wrapper--header">
    <h1 class="vote__title">{{$headerBlock->getTranslatedAttribute('title')}}</h1>
      {!!$headerBlock->getTranslatedAttribute('html')!!}
    </header>
    <div class="leaderboard vote__wrapper vote__wrapper--leaderboard">
      <button class="leaderboard__button" id="leaderboardToggle">
        <span>@lang('votes.leaderboard')</span>
      </button>
      <div class="leaderboard__wrapper leaderboard__wrapper--team-list" id="leaderboard" style="display: none;">
        <div class="leaderboard__inner leaderboard__inner--header">
          <span>@lang('votes.team_header')</span><span>@lang('votes.vote_header')</span>
        </div>
        <ol class="team-list leaderboard__team-list" id="leaderboard-list"></ol>
        <div class="leaderboard__inner leaderboard__inner--image">
        <img class="leaderboard__img" src="//:0" alt="" role="presentation"/>
        </div>
      </div>
    </div>

    <div class="vote__wrapper" id="vote-team-list"></div>
  </div>
</section>
