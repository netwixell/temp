<section class="hero hero--index" data-particle-img="..{{$src_dir}}/img/rombus.svg">
  <canvas id="particles1" style="position: absolute; width: 100%; height: 100vh;"></canvas>
  <div class="hero__bg-wrapper">
    <div class="hero__bg"></div>
  </div>
  <canvas id="particles2" style="position: absolute; width: 100%; height: 100%"></canvas>
  <div class="hero__container hero__container--index container">
  <h1 class="hero__title visually-hidden">@lang('events.hero_title_hidden')</h1><strong class="hero__title">{!!__('events.hero_title')!!}</strong>
    <p class="hero__description">
      <?php
        $place = $event->getTranslatedAttribute('place');
        $eventPlace = substr($place, 0, strpos($place, ",")?:strlen($place) ) ?>
      <time datetime="{{$event->date_from}}">{{date('j',strtotime($event->date_from))}} – {{date('j',strtotime($event->date_to))}} {{locale_month(date('n',strtotime($event->date_to)))}}</time>, {{$eventPlace}}
    </p><a class="hero__button button button--white" href="/throwback"><span>@lang('events.throwback_caption')</span></a>
     @if($ticket_selling)<a class="hero__button button button--red" data-scroll href="#tickets"><span>@lang('events.buy_ticket')</span></a>@endif
  </div>
</section>
