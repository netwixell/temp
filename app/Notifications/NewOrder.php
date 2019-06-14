<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\BroadcastMessage;

class NewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_number' => $this->order->number,
            'from' => $this->order->name,
            'phone' => $this->order->phone
        ];
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
            'order_id' => $this->order->id,
            'order_number' => $this->order->number,
            'name' => $this->order->name,
            'route' => 'voyager.orders.index',
            'message' => 'Новый заказ на сайте',
            'link' => route('voyager.orders.edit', $this->order->id)
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
        $order= $this->order;
        $subject="Новый заказ №".pretty_order_number($order->number);
        $url = route('voyager.orders.edit', $order->id);
        return (new MailMessage)
                    ->subject($subject)
                    ->markdown('service-email.new-order.new-order', ['order'=>$order,'url' => $url]);
    }
}
