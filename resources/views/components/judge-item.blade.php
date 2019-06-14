<li class="card card--judge judges__card">
  <div class="card__img-wrapper loading"><img class="card__img lazyload" data-srcset="{{getThumbnail($judge->person->image,290,290,'fit','top')}} 300w, {{getThumbnail($judge->person->image,580,580,'fit','top')}} 600w, {{getThumbnail($judge->person->image,870,870,'fit','top')}} 900w" data-src="{{getThumbnail($judge->person->image,290,290,'fit','top')}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="{{$judge->person->name}}"></div>
  <h3 class="card__name">{{$judge->person->name}}</h3>
  <p class="card__about">{{$judge->caption}}</p>
</li>
