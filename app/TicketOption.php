<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TicketOption extends Pivot
{
    protected $table = 'ticket_options';

    public $timestamps = false;


    protected $primaryKey = 'option_id'; // or null

    public $incrementing = false;



    // protected function setKeysForSaveQuery(Builder $query)
    // {
    //     $query
    //         ->where('ticket_id', '=', $this->getAttribute('ticket_id'))
    //         ->where('option_id', '=', $this->getAttribute('option_id'));

    //     return $query;
    // }
}
