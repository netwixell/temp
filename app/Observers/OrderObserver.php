<?php

namespace App\Observers;

use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderStatusChanged;

class OrderObserver
{
    public function creating(Order $order){
        $auth_id=Auth::id();
        $order->created_by= isset($auth_id)? $auth_id : 3;
    }
    public function saving(Order $order) {
        $order->updated_by=Auth::id();
    }
    public function updating(Order $order){
      $original_status = $order->getOriginal('status');
      if($order->status != $original_status && !in_array($order->status,Order::$temporary_statuses)){

        if($order->status == Order::STATUS_CONFIRMED){

            $confirmed_at =  $order->freshTimestamp();
            $order->confirmed_at = $confirmed_at;

        }

        event(new OrderStatusChanged($order,$original_status));
      }
    }
    public function deleting(Order $order) {
        $order->unreadUsers()->detach();
        $order->deleted_by=Auth::id();
        $order->save();
    }
}
