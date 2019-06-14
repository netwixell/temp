@php

$phone = $team->phone;

if(  preg_match( '/^\+?(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})$/', $phone,  $matches ) )
{
  $phone = '+'. $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4]. ' ' . $matches[5];
}
@endphp
@component('mail::message')
# Запрос на регистрацию команды

Имя: {{$team->contact_name}}. Телефон: [{{$phone}}](tel:{{$team->phone}})

Название команды: {{$team->name}}


@component('mail::button', ['url' => $url])
Просмотреть запрос
@endcomponent

@endcomponent
