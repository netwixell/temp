<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\NewCallbackEvent;

use App\Role;
use Notification;
use App\Notifications\NewCallback;

class NewCallbackListener
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
    public function handle($event)
    {
      $callback = $event->callback;

      $role = Role::where('name','manager')->first();

      $users = $role->my_users()->get();

      Notification::send($users, new NewCallback($callback));

      $now = now()->toDateTimeString();

      $unread_users = [];

      foreach($users as $user){
        $unread_users[$user->id] = [
          'status' => 'NEW',
          'route' => 'voyager.callback.index',
          'created_at' => $now,
        ];
      }

      if(count($unread_users) > 0){
        $callback->unreadUsers()->attach($unread_users);
      }

    }
}
