<li class="sponsors__item-wrapper">
  <a class="sponsors__item loading" href="{{$sponsor->link}}" target="_blank" rel="noopener">{{$sponsor->getTranslatedAttribute('name')}}
    <img class="sponsors__img lazyload" data-src="{{getOptimizedImage( get_file_url($sponsor->image) )}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="160" alt="{{$sponsor->getTranslatedAttribute('name')}}">
  @if(!empty($sponsor->caption))<p class="sponsors__text">{{$sponsor->getTranslatedAttribute('caption')}}</p>@endif
  </a>
</li>
