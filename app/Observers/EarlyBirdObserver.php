<?php

namespace App\Observers;

use App\EarlyBird;
use Illuminate\Support\Facades\Auth;

class EarlyBirdObserver
{
    public function creating(EarlyBird $early_bird){
        $early_bird->created_by=Auth::id();
    }
    public function saving(EarlyBird $early_bird) {
        $early_bird->updated_by=Auth::id();
    }
    public function deleting(EarlyBird $early_bird) {
        $early_bird->deleted_by=Auth::id();
        $early_bird->save();
    }
}
