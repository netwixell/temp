@if(isset($quotes[0]))
<blockquote class="quote">
  <div class="quote__container container">
    <div class="quote__content">
      <div class="quote__text-wrapper">
        <p class="quote__text">{{$quotes[0]->quote}}</p>
      </div><strong class="quote__author">{{$quotes[0]->person->name}}</strong>
    </div>
    @if($quotes[0]->image)
    <div class="quote__img-wrapper loading">
    <img class="quote__img lazyload" data-srcset="{{getThumbnail($quotes[0]->image,300)}} 300w, {{getThumbnail($quotes[0]->image,600)}} 600w, {{getThumbnail($quotes[0]->image,900)}} 900w" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/storage/{{$quotes[0]->image}}" alt="{{$quotes[0]->person->name}}">
    </div>
    @endif
    </div>
</blockquote>
@endif
