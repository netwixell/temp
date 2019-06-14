<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\OrderStatusChanged;

use App\Role;
use Notification;
use App\Notifications\OrderStatusChanged as Notify;
use Illuminate\Support\Facades\Mail;

use DB;

class SendNewStatusOrder
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
      // remove users notifications by order
      $event->order->unreadUsers()->detach();

        // \Log::info('status_changed', ['order' => $event->order]);

        // Mail::to( $event->order->email )
        //     ->send(new \App\Mail\OrderStatusChanged($event->order));

        // $role=Role::where('name','manager')->first();
        // $users=$role->my_users()->get();
        // Notification::send($users, new Notify($event->order));
    }
}
