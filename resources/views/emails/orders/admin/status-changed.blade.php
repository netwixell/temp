@php

$phone = $order->phone;

if(  preg_match( '/^\+?(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})$/', $phone,  $matches ) )
{
  $phone = '+'. $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4]. ' ' . $matches[5];
}
@endphp
@component('mail::message')
# Заказ №{{pretty_order_number($order->number)}} получил статус: {{__('orders.'.$order->status)}}


Имя: {{$order->name}}. Телефон: [{{$phone}}](tel:{{$order->phone}})

@component('mail::button', ['url' => $url])
Перейти к заказу
@endcomponent

@endcomponent
