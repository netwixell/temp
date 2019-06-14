<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\NewTeamEvent;

use App\Role;
use Notification;
use App\Notifications\NewTeam;

class NewTeamListener
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
      $team = $event->team;

      $role = Role::where('name','manager')->first();

      $users = $role->my_users()->get();

      Notification::send($users, new NewTeam($team));

      $now = now()->toDateTimeString();

      $unread_users = [];

      foreach($users as $user){
        $unread_users[$user->id] = [
          'status' => 'NEW',
          'route' => 'voyager.teams.index',
          'created_at' => $now,
        ];
      }

      if(count($unread_users) > 0){
        $team->unreadUsers()->attach($unread_users);
      }
    }
}
