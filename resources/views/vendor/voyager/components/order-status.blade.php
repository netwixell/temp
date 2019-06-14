<?php

$btn_types=[
            'NEW'=>'btn-warning',
            'CONFIRMED'=>'btn-success',

            'OVERDUE_CONFIRMED'=>'btn-danger',
            'OVERDUE_PAYMENT'=>'btn-warning',
            'MISSED_PAYMENT'=>'btn-danger',

            'PAID'=>'btn-success',
            'PENDING_PAYMENT'=>'btn-success',
            'RESERVED'=>'btn-dark',
            'CANCELED'=>'btn-default'
      ];

  $selected_key = (isset($data->status) && !is_null(old('status', $data->status))) ? old('status', $data->status) : old('status');

  if($selected_key === NULL){
      $selected_key='NEW';
  }
  $statuses=$data::$status_switches[$selected_key];
  $status_count=count($statuses);
?>
<div class="btn-group order-status" data-toggle="tooltip">
  <?php $btn_cls=isset($btn_types[$selected_key])?$btn_types[$selected_key]:'btn-secondary'; ?>
  <button type="button" class="btn {{$btn_cls}} dropdown-toggle update-btn" data-url="{{route('voyager.orders.update', $data->getKey()) }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{__('orders.'.$selected_key)}} @if($status_count>0)<span class="caret"></span>@endif
  </button>
  @if($status_count>0)
  <ul class="dropdown-menu @isset($cls_menu){{$cls_menu}}@endisset">
      @foreach($statuses as $status)
        @if( $selected_key != $status)
        <li>
          <?php $btn_cls=isset($btn_types[$status]) ? $btn_types[$status]: 'btn-secondary'; ?>
          <a href="{{ $status }}" data-btn="{{$btn_cls}}">{{__('orders.'.$status)}}</a>
        </li>
        @endif
      @endforeach
  </ul>
  @endif
</div>
