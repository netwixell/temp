<?php $loaded_partners_count = $event->partners->count(); ?>
@if($loaded_partners_count > 0)
<section class="partners">
  <div class="partners__container container">
    <h2 class="partners__title">@lang('commercial.partners_title')</h2>
    <ul class="partners__list">
        @each('web-site.partner.partner', $event->partners, 'partner')
    </ul>
    @if($event->partners_count > $loaded_partners_count)
    <button class="partners__more js-more" data-container=".partners__list" data-url="{{route('partners',['skip'=> $loaded_partners_count])}}">Все партнёры ({{($event->partners_count - $loaded_partners_count)}})</button>
    @endif
  </div>
</section>
@endif
