<?php

namespace App\Jobs;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\OrderStatusChanged;

class ChangeOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $new_status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $new_status)
    {
        $this->order = $order;
        $this->new_status = $new_status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Order $order)
    {
        if($this->$order->status === $this->new_status){

          event(new OrderStatusChanged($this->$order));
        }
    }
}
