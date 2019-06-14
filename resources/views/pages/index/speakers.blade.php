<section class="speakers">
  <div class="speakers__container container">
    <h2 class="speakers__title">Спикеры</h2>
    <ul class="speakers__wrapper">
      @foreach($event_persons as $flow_name => $persons )
      <li class="flow speakers__flow"><b class="flow__title">{{$flow_name}}</b>
        <ul class="flow__list">
          @foreach($persons as $person)
          <li class="card speakers__card">
            <div class="card__img-wrapper loading">
              <img class="card__img lazyload" data-srcset="{{getThumbnail($person->person->image,290,290,'fit','top')}} 300w, {{getThumbnail($person->person->image,580,580,'fit','top')}} 600w, {{getThumbnail($person->person->image,870,870,'fit','top')}} 900w" data-src="{{getThumbnail($person->person->image,290,290,'fit','top')}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="{{$person->person->name}}"></div>
            <h3 class="card__name">{{$person->person->name}}</h3>
            @if(!empty($person->caption))<p class="card__about">{{$person->caption}}</p>@endif
            @if($person->person->contacts->count()>0)
            <ul class="social card__social">
              @foreach($person->person->contacts as $contact)
              <li class="social__link-wrapper"><a class="social__link" href="{{$contact->value}}" target="_blank" rel="noopener"><span>{{__('person_contacts.'.$contact->type )}}</span></a></li>
              @endforeach
            </ul>
            @endif
          </li>
          @endforeach
        </ul>
      </li>
      @endforeach
    </ul><i class="speakers__more">Список пополняется...</i>
  </div>
</section>
