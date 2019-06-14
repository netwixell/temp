<?php

namespace App\Observers;

use App\Option;
use Illuminate\Support\Facades\Auth;

class OptionObserver
{
    public function creating(Option $option){
        $option->created_by=Auth::id();
    }
    public function saving(Option $option) {
        $option->updated_by=Auth::id();
    }
    public function deleting(Option $option) {
        $option->deleted_by=Auth::id();
        $option->save();
    }
}
