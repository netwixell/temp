<?php $loaded_judges_count = $event_judges->count(); ?>
@if($loaded_judges_count>0)
<section class="judges">
  <div class="judges__container container">
    <div class="judges__title-wrapper">
      <h2 class="judges__title">@lang('dream-team-page.judges__title')</h2>
      <p class="judges__description">@lang('dream-team-page.judges__description')</p>
      <p class="judges__promo">@lang('dream-team-page.judges__promo')</p>
      <a class="judges__button judges__button--title button button--unfilled-blue" href="/dream-team/rules"><span>@lang('dream-team-page.judges__button')</span></a>
    </div>
    <ul class="judges__list">
      @each('web-site.dream-team__judge.dream-team__judge', $event_judges, 'judge')
    </ul>
    @if($event->persons_count > $loaded_judges_count)
    <button class="judges__more js-more" data-container=".judges__list" data-insert-method="append" data-url="{{route('dream-team.judges',['skip'=> $loaded_judges_count])}}">@lang('dream-team-page.judges__more') ({{($event->persons_count - $loaded_judges_count)}})</button>
    @endif
    <a class="judges__button button button--unfilled-blue" href="/dream-team/rules"><span>@lang('dream-team-page.judges__button')</span></a>
  </div>
</section>
@endif
