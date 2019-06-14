<figure class="commercial">
  <div class="commercial__container container">
    <div class="commercial__wrapper container">
      <div class="commercial__inner commercial__inner--text">
        <p class="commercial__text"><b class="commercial__title">{{$advertisement->getTranslatedAttribute('title')}}</b></p>
        <p class="commercial__text">{{ $advertisement->getTranslatedAttribute('caption') }}</p>
        @if(isset($advertisement->link_url))
        <p class="commercial__text"><a class="commercial__link" href="{{$advertisement->link_url}}" target="_blank" rel="noopener">@if(!empty($advertisement->link_title)){{$advertisement->getTranslatedAttribute('link_title')}}@else{{$advertisement->link_url}}@endif</a></p>
        @endif
      </div>
      <div class="commercial__inner">
      @if($advertisement->image)
      <div class="commercial__img-wrapper loading">
      <img class="commercial__img lazyload" data-srcset="{{$advertisement->srcset}}" data-src="{{$advertisement->src}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="{{$advertisement->getTranslatedAttribute('title')}}">
      </div>
      @endif
      </div>
    </div>
  </div>
  <figcaption class="commercial__caption container"><em>@lang('commercial.caption')</em></figcaption>
</figure>
