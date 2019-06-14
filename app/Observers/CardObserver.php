<?php

namespace App\Observers;

use App\Card;
use Illuminate\Support\Facades\Auth;

class CardObserver
{
    public function creating(Card $card){
        $card->created_by=Auth::id();
    }
    public function saving(Card $card) {
        $card->updated_by=Auth::id();
    }
    public function deleting(Card $card) {
        $card->deleted_by=Auth::id();
        $card->save();
    }
}
