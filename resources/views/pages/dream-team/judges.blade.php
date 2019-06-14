<?php $loaded_judges_count = $event_judges->count(); ?>
@if($loaded_judges_count>0)
<section class="judges">
  <div class="judges__container container">
    <div class="judges__title-wrapper">
      <h2 class="judges__title">Судьи</h2>
      <p class="judges__description">Судят на Dream Team профессиональные судьи и чемпионы международных соревнований</p>
      <p class="judges__promo">Судьи проведут бесплатные консультации для первых зарегистрированных команд. Города проведения будут выбраны на основе регистраций</p>
      <a class="judges__button judges__button--title button button--unfilled-blue" href="/dream-team/rules"><span>Правила конкурса</span></a>
    </div>
    <ul class="judges__list">
      @include('components.judge-items',['judges'=>$event_judges])
    </ul>
    @if($event->persons_count > $loaded_judges_count)
    <button class="judges__more js-more" data-container=".judges__list" data-insert-method="append" data-url="{{route('dream-team.judges',['skip'=> $loaded_judges_count])}}">Все судьи ({{($event->persons_count - $loaded_judges_count)}})</button>
    @endif
    <a class="judges__button button button--unfilled-blue" href="/dream-team/rules"><span>Правила конкурса</span></a>
  </div>
</section>
@endif
