<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Speech extends Model
{
    use Translatable;
    protected $translatable = ['name','preview','content'];
    protected $table='speeches';

    public $additional_attributes = ['full_name'];

    public function speaker(){
        return $this->belongsTo('App\Person','speaker_id', 'id');
    }
    public function events(){
        return $this->belongsToMany('App\Event', 'event_speeches', 'speech_id', 'event_id');
    }
    public function getFullNameAttribute(){
        return $this->speaker->name.'. '.$this->name;
    }
}
