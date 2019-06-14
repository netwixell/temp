<?php

namespace App\Notifications;

use App\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\BroadcastMessage;

class NewTeam extends Notification implements ShouldQueue
{
    use Queueable;

    public $team;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast','mail'];
    }

     /**
       * Get the broadcastable representation of the notification.
       *
       * @param  mixed  $notifiable
       * @return BroadcastMessage
      */
      public function toBroadcast($notifiable)
      {
          return new BroadcastMessage([
              'team_id' => $this->team->id,
              'name' => $this->team->name,
              'route' => 'voyager.teams.index',
              'message' => 'Новая регистрация команды',
              'link' => route('voyager.teams.edit', $this->team->id)
          ]);
      }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $team = $this->team;
        $subject="Запрос на регистрацию команды";
        $url = route('voyager.teams.edit', $team->id);
        return (new MailMessage)
                    ->subject($subject)
                    ->markdown('service-email.new-team.new-team', ['team'=>$team,'url' => $url]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
