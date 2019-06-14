@if($status=='NEW')
  <span class="badge badge-info">{{__('orders.'.$status)}}</span>
@elseif($status=='PAID')
  <span class="badge badge-success">{{__('orders.'.$status)}}</span>
@elseif($status=='RESERVED')
  <span class="badge badge-dark">{{__('orders.'.$status)}}</span>
@else
  <span class="badge badge-secondary">{{__('orders.'.$status)}}</span>
@endif
