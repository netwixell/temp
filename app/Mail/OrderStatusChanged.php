<?php

namespace App\Mail;


use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $order=$this->order;

      $subject='Ваш заказ №'.pretty_order_number($order->number).' '.__('orders.'.$order->status);

      return $this->subject($subject)
        ->replyTo('inbox@molfarforum.com', 'Molfar')
        ->view('client-email.order-status-changed.order-status-changed',['order' => $order]);
    }
}
