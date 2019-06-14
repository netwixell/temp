<?php

namespace App\Observers;

use App\Bill;
use App\Order;
use App\Ticket;
use Illuminate\Support\Facades\Auth;

class BillObserver
{
    public function saved(Bill $bill) {
      $order_id=$bill->order_id;
      $total_price=Bill::where('order_id',$order_id)->sum('price');
      $order=Order::find($order_id);
      $order->total_price=$total_price;
      $order->updated_at = now()->toDateTimeString();
      $order->updated_by = Auth::id();

      if($bill->priceable_type=='ticket'){
        $ticket_id=$bill->priceable_id;
        $order->ticket_id=$ticket_id;
        $ticket_count=Bill::where([
          ['priceable_type','=','ticket'],
          ['priceable_id','=',$ticket_id]
        ])->whereHas('order', function($query){
          $query->reserved();
        })->count();
        $ticket = Ticket::find($ticket_id);
        $is_available = $ticket->is_available;
        $qty = $ticket->qty;
        if($ticket_count >= $qty && $is_available){

          $ticket->is_available=0;
          $ticket->save();
        }
        elseif($ticket_count<$qty && !$is_available){
          $ticket->is_available=1;
          $ticket->save();
        }

      }
      $order->save();
    }
    public function deleted(Bill $bill) {
      $order_id=$bill->order_id;
      $total_price=Bill::where('order_id',$order_id)->sum('price');
      $order=Order::find($order_id);
      $order->total_price=$total_price;

      if($bill->priceable_type=='ticket'){
        $order->ticket_id=$bill->priceable_id;
      }
      $order->save();
    }
}
