<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AttentionOrders extends Notification
{
    use Queueable;

    public $grouped_orders;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($grouped_orders)
    {
        $this->grouped_orders = $grouped_orders;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      $grouped_orders= $this->grouped_orders;
      $subject="Заказы требующие внимания";
      $url = route('voyager.orders.index');
        return (new MailMessage)
                  ->subject($subject)
                  ->markdown('service-email.order-attention.order-attention', ['grouped_orders'=>$grouped_orders,'url' => $url]);
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
