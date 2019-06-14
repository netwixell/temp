@if(isset($quotes[1]))
<blockquote class="quote">
  <div class="quote__container quote__container--left-image container">
    <div class="quote__content">
      <div class="quote__text-wrapper">
        <p class="quote__text">{{$quotes[1]->getTranslatedAttribute('quote')}}</p>
      </div><strong class="quote__author">{{$quotes[1]->person->getTranslatedAttribute('name')}}</strong>
    </div>
    @if($quotes[1]->image)
    <div class="quote__img-wrapper loading">
    <img class="quote__img lazyload" data-srcset="{{getThumbnail($quotes[1]->image,300)}} 300w, {{getThumbnail($quotes[1]->image,600)}} 600w, {{getThumbnail($quotes[1]->image,900)}} 900w" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/storage/{{$quotes[1]->image}}" alt="{{$quotes[1]->person->getTranslatedAttribute('name')}}">
    </div>
    @endif
  </div>
</blockquote>
@endif
