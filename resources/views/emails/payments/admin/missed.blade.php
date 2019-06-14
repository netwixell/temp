@component('mail::message')
# Пропущен платеж

По заказу №{{$order->id}} был пропущен платеж в этом месяце!

@component('mail::button', ['url' => $url])
Перейти к заказу
@endcomponent

@endcomponent
