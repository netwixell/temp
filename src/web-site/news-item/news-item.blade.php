<article class="card card--news news__card" data-aos="fade-up" data-aos-once="true">
  <a class="card__link" href="/news/{{$item->slug}}">
    @if(isset($item->image))
    {{--
    шаги srcset:
     600
     900
     1200
     1500
     1800
     --}}
    <div class="card__img-wrapper loading">
      <img class="card__img lazyload"
           data-srcset="{{getThumbnail($item->image,600)}} 600w, {{getThumbnail($item->image,900)}} 900w, {{getThumbnail($item->image,1200)}} 1200w, {{getThumbnail($item->image,1500)}} 1500w, {{getThumbnail($item->image,1800)}} 1800w"
           data-src="{{getThumbnail($item->image,600)}}"
           src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
            alt="{{$item->getTranslatedAttribute('title')}}">
    </div>
    @endif
    <h2 class="card__name">{{$item->getTranslatedAttribute('title')}}</h2>
  </a>
<time class="card__published" datetime="{{$item->created_at}}">{{locale_date($item->created_at, '%d %s, %d')}}</time>
  @if(!empty($item->excerpt))
  <p class="card__about">{!!$item->getTranslatedAttribute('excerpt')!!}</p>
  @endif
  <div class="comments card__comments">
      <a class="comments__item-wrapper comments__item-wrapper--comments" href="{{url("/news/{$item->slug}")}}#comments">
        @lang('posts.comments') <span class="comments__item fb-comments-count" data-href="{{url("/news/{$item->slug}")}}"></span>
        {{-- <span class="fb-comments-count" data-href="https://example.com/"></span> --}}
     </a>
    <div class="comments__item-wrapper comments__item-wrapper--views">
      <span class="comments__item">@lang('posts.views') {{$item->views}}</span>
    </div>
  </div>
</article>
