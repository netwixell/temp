<?php

namespace App\Notifications;

use App\Callback;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCallback extends Notification implements ShouldQueue
{
    use Queueable;

    public $callback;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Callback $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      $callback= $this->callback;
        $subject="Вопрос №".$callback->id;
        $url = route('voyager.callback.edit', $callback->id);
        return (new MailMessage)
                    ->subject($subject)
                    ->markdown('service-email.new-question.new-question', ['callback'=>$callback,'url' => $url]);
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
              'callback_id' => $this->callback->id,
              'name' => $this->callback->name,
              'route' => 'voyager.callback.index',
              'message' => 'Новый вопрос на сайте',
              'link' => route('voyager.callback.edit', $this->callback->id)
          ]);
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
