<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use TCG\Voyager\Traits\Translatable;

class Card extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'cards';
    protected $translatable = ['name'];

    protected $dates = ['deleted_at'];

    public $additional_attributes = ['full_name'];

    public function tickets(){
        return $this->belongsToMany('App\Ticket', 'ticket_cards', 'card_id', 'ticket_id');
    }
    public function getFullNameAttribute(){
        $name=$this->name;
        $num=substr($this->card_number, -4);
        return $name.' (...'.$num.')';
    }
}
