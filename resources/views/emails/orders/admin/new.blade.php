@php

$phone = $order->phone;

if(  preg_match( '/^\+?(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})$/', $phone,  $matches ) )
{
  $phone = '+'. $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4]. ' ' . $matches[5];
}
@endphp
@component('mail::message')
# Поступил новый заказ №{{pretty_order_number($order->number)}}

Был заказан новый билет!

Имя: {{$order->name}}. Телефон: [{{$phone}}](tel:{{$order->phone}})

@component('mail::button', ['url' => $url])
Перейти к заказу
@endcomponent

@endcomponent
