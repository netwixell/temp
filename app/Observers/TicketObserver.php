<?php

namespace App\Observers;

use App\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    public function creating(Ticket $ticket){
        $ticket->created_by=Auth::id();
    }
    public function saving(Ticket $ticket) {
        $ticket->updated_by=Auth::id();
    }
    public function deleting(Ticket $ticket) {
        $ticket->deleted_by=Auth::id();
        $ticket->save();
    }
}
