<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;


class OrderStatusChanged
{
    use SerializesModels;

    public $order;
    public $old_status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, $old_status)
    {
        $this->order = $order;
        $this->old_status = $old_status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
