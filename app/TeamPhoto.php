<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class TeamPhoto extends Model
{
    use Translatable;

    protected $table='team_photos';
    protected $translatable = ['caption'];

     public function team(){
        return $this->belongsTo('App\Team','team_id');
    }
}
