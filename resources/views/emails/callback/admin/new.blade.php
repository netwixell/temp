@php

$phone = $callback->phone;

if(  preg_match( '/^\+?(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})$/', $phone,  $matches ) )
{
  $phone = '+'. $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4]. ' ' . $matches[5];
}
@endphp
@component('mail::message')
# Вопрос №{{$callback->id}}

Имя: {{$callback->name}}. Телефон: [{{$phone}}](tel:{{$callback->phone}})

  @isset($callback->question)

@component('mail::panel')
    {{$callback->question}}
@endcomponent

  @endisset

@component('mail::button', ['url' => $url])
Перейти
@endcomponent

@endcomponent
