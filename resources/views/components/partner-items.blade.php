@foreach($partners as $partner)
  <li class="partners__item-wrapper"><a class="partners__item loading" href="{{$partner->link}}" target="_blank" rel="noopener">{{$partner->name}}<img class="partners__img lazyload" data-src="/storage/{{get_file_url($partner->image)}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="160" alt="{{$partner->name}}"></a></li>
@endforeach
