<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\OrderStatusChanged;

use App\OrderLog;

class LogNewStatusOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        $orderlog=new OrderLog();

        $orderlog->order_id=$event->order->id;
        $orderlog->notes='Статус заказа изменен на «'.__('orders.'.$event->order->status).'»';

        $orderlog->save();
    }
}
