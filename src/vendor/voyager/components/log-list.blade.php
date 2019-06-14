@foreach($items as $item)
<li class="list-group-item">
  <span><a href="{{route('voyager.users.show',$item->created_by)}}">{{$item->createdByUser->name}}</a>, <small>{{$item->created_at}}</small></span><br>
  {{$item->notes}}
</li>
@endforeach
