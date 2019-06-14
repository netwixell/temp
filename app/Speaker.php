<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Speaker extends Model
{
    use Translatable;
    protected $translatable = ['name','summary'];
    protected $table='speakers';

    public function contacts(){
        return $this->hasMany('App\SpeakerContact','speaker_id');
    }
}
