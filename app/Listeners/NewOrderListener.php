<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\NewOrderEvent;

use App\Role;
use Notification;
use App\Notifications\NewOrder;

class NewOrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewOrderEvent $event)
    {

      $order = $event->order;

      $role = Role::where('name','manager')->first();

      $users = $role->my_users()->get();

      Notification::send($users, new NewOrder($order));

      $now = now()->toDateTimeString();

      $unread_users = [];

      foreach($users as $user){
        $unread_users[$user->id] = [
          'status' => 'NEW',
          'route' => 'voyager.orders.index',
          'created_at' => $now,
        ];
      }

      if(count($unread_users) > 0){
        $order->unreadUsers()->attach($unread_users);
      }

    }
}
