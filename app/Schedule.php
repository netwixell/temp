<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Schedule extends Model
{

  use Translatable;

  protected $table='schedule';
  protected $translatable = ['title','description'];


  public function event(){
      return $this->belongsTo('App\Event','event_id');
  }
  public function flow(){
      return $this->belongsTo('App\Flow','flow_id');
  }

  public function partners(){
      return $this->belongsToMany('App\Partner', 'schedule_partners', 'schedule_id', 'partner_id');
  }

  public function persons(){
      return $this->belongsToMany('App\Person', 'schedule_persons', 'schedule_id', 'person_id');
  }

  public function badges(){
    return $this->belongsToMany('App\Badge', 'schedule_badges', 'schedule_id', 'badge_id');
  }

}
