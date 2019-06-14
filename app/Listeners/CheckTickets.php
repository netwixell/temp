<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\OrderStatusChanged;
use App\Order;


class CheckTickets implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    /*public $queue = 'listeners';*/

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

        $old_status = $event->old_status;

        $order = $event->order;
        $status = $order->status;

        // \Log::info('status_changed', ['new_status' => $status,'old_status'=>$old_status]);

        if(isset($old_status)){

          $reserved_statuses=Order::$reserved_statuses;
          $old_is_reserved = in_array($old_status,$reserved_statuses);
          $new_is_reserved = in_array($status,$reserved_statuses);

           $tickets = $order->bill_tickets;

          if($old_is_reserved && !$new_is_reserved){

            foreach($tickets as $ticket){
              if($ticket->remain>=0 && !$ticket->is_available){
                $ticket->is_available=1;
                $ticket->save();
              }
            }

          }
          elseif($new_is_reserved && !$old_is_reserved){

            foreach($tickets as $ticket){
              if($ticket->remain<=0 && $ticket->is_available){
                $ticket->is_available=0;
                $ticket->save();
              }
            }

          }
        }

    }
}
