<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Person extends Model
{
    use Translatable;
    protected $translatable = ['name','summary'];
    protected $table='persons';

    public function contacts(){
        return $this->hasMany('App\PersonContact','person_id');
    }
    public function quotes(){
      return $this->hasMany('App\Quote','quote_id');
    }
    public function schedule(){
      return $this->belongsToMany('App\Schedule', 'schedule_persons', 'person_id', 'schedule_id');
    }
}
