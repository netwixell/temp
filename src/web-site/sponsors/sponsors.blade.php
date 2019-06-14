<?php $loaded_sponsors_count = $event->partners->count(); ?>
@if($loaded_sponsors_count>0)
<section class="sponsors">
  <div class="sponsors__container container">
    <h2 class="sponsors__title">@lang('dream-team-page.sponsors__title')</h2>
    <ul class="sponsors__list">
      @each('web-site.sponsor.sponsor', $event->partners, 'sponsor')
    </ul>
    @if($event->partners_count > $loaded_sponsors_count)
      <button class="sponsors__more js-more" data-container=".sponsors__list" data-url="{{route('dream-team.sponsors',['skip'=> $loaded_sponsors_count])}}">@lang('dream-team-page.sponsors__more') ({{($event->partners_count - $loaded_sponsors_count)}})</button>
    @endif
  </div>
</section>
@endif
