@foreach($sponsors as $sponsor)
  <li class="sponsors__item-wrapper">
    <a class="sponsors__item loading" href="{{$sponsor->link}}" target="_blank" rel="noopener">{{$sponsor->name}}<img class="sponsors__img lazyload" data-src="/storage/{{get_file_url($sponsor->image)}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="160" alt="{{$sponsor->name}}">
    @if(!empty($sponsor->caption))<p class="sponsors__text">{{$sponsor->caption}}</p>@endif
    </a>
  </li>
@endforeach
