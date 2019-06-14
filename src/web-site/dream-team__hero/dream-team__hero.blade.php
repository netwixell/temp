<?php
$timeDateFrom = strtotime($event->date_from);
$timeDateTo = strtotime($event->date_to);
$dateFrom = date('j', $timeDateFrom).' '.locale_month(date('n',$timeDateFrom)).' ‘'.date('y',$timeDateFrom);
$dateTo = date('j', $timeDateTo).' '.locale_month(date('n',$timeDateTo)).' ‘'.date('y',$timeDateTo);
?>
<section class="hero hero--dream-team lazyload">
  <div class="hero__container container">
    <h1 class="hero__title visually-hidden">Molfar Dream Team 2019</h1>
    <p class="hero__description hero__description--dream-team">
      <time datetime="{{date('Y-m-d', $timeDateFrom)}}">{{$dateFrom.' — '.$dateTo}}</time>
    </p>
    <strong class="hero__title hero__title--dream-team">@lang('dream-team-page.hero__title')</strong>
    <a class="hero__button button button--blue" data-scroll href="#registration">
      <span>@lang('dream-team-page.hero__button')</span>
    </a>
  </div>
</section>
