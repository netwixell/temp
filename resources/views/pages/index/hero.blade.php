<section class="hero hero--index" data-particle-img="..{{$src_dir}}/img/rombus.svg">
  <canvas id="particles1" style="position: absolute; width: 100%; height: 100vh;"></canvas>
  <div class="hero__bg-wrapper">
    <div class="hero__bg"></div>
  </div>
  <canvas id="particles2" style="position: absolute; width: 100%; height: 100%"></canvas>
  <div class="hero__container hero__container--index container">
    <h1 class="hero__title visually-hidden">Molfar Beauty Forum ‘19</h1><strong class="hero__title">Главная <br>бьюти-конференция в Украине</strong>
    <p class="hero__description">
      <time datetime="{{$event->date_from}}">{{date('j',strtotime($event->date_from))}} – {{date('j',strtotime($event->date_to))}} {{locale_month(date('n',strtotime($event->date_to)))}}</time>, {{$event->place}}
    </p><a class="hero__button button button--white" href="/throwback"><span>Смотреть как было круто в 2018 году</span></a><a class="hero__button button button--red" data-scroll href="#tickets"><span>Приобрести билет</span></a>
  </div>
</section>
