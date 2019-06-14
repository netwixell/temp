@component('mail::message')

@foreach($grouped_orders as $status => $orders )
#### {{__('orders.ATTENTION_'.$status)}}
@foreach($orders as $order)

Заказ [№{{pretty_order_number($order->number)}}]({{route('voyager.orders.edit', $order->id)}}), от {{$order->name}} [{{phone_format($order->phone)}}](tel:{{$order->phone}})

@endforeach

@endforeach

@component('mail::button', ['url' => $url])
Перейти к заказам
@endcomponent


@endcomponent
