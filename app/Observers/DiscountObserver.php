<?php

namespace App\Observers;

use App\Discount;
use Illuminate\Support\Facades\Auth;

class DiscountObserver
{
    public function creating(Discount $discount){
        $discount->created_by=Auth::id();
    }
    public function saving(Discount $discount) {
        $discount->updated_by=Auth::id();
    }
    public function deleting(Discount $discount) {
        $discount->deleted_by=Auth::id();
        $discount->save();
    }
}
