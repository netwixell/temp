<?php

namespace App\Observers;

use App\OrderLog;
use Illuminate\Support\Facades\Auth;

class OrderLogObserver
{
    public function creating(OrderLog $order){
        $order->created_by=  Auth::id();
        $order->created_at=  $order->freshTimestamp();
    }
}
