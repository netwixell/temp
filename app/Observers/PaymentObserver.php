<?php

namespace App\Observers;

use App\Payment;
use App\Order;
use Illuminate\Support\Facades\Auth;

class PaymentObserver
{
    public function creating(Payment $payment){
        $payment->created_by=Auth::id();
    }
    public function saving(Payment $payment) {
        $payment->updated_by=Auth::id();
    }
    public function saved(Payment $payment) {
      $order_id=$payment->order_id;
      $order=Order::find($order_id);
      $order->updated_at = now()->toDateTimeString();
      $order->updated_by = Auth::id();
      $order->save();
    }
    public function deleting(Payment $payment) {
        $payment->deleted_by=Auth::id();
        $payment->save();
    }
}
