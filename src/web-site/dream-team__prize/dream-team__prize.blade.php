@if($prizes->count()>0)
<section class="prize">
  <div class="prize__container container">
    <div class="prize__title-wrapper">
      <h2 class="prize__title">@lang('dream-team-page.prize__title')</h2>
      <p class="prize__description">@lang('dream-team-page.prize__description')</p>
    </div>
    <div class="prize__swiper-container swiper-container">
      <ul class="prize__list swiper-wrapper">
        @foreach($prizes as $prize)
        <li class="prize__card swiper-slide">
          @if(isset($prize->image))
          <div class="prize__img-wrapper loading">
            <img class="prize__img lazyload"
              data-srcset="{{srcset($prize->image, 360,720,1080)}}"
              data-src="{{getThumbnail($prize->image, 720)}}"
              src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
              alt="{{$prize->getTranslatedAttribute('title')}}">
          </div>
          @endif
          <div class="prize__text-wrapper">
            <p class="prize__text"><b class="prize__subtitle">{{$prize->getTranslatedAttribute('title')}}</b></p>
            <p class="prize__text"><em class="prize__description prize__description--italic">{{$prize->getTranslatedAttribute('description')}}</em></p>
          </div>
        </li>
        @endforeach
      </ul>
      <button class="prize__button prize__button--prev swiper-button-prev"></button>
      <button class="prize__button prize__button--next swiper-button-next"></button>
    </div>
  </div>
</section>
@endif
