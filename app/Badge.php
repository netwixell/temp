<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Badge extends Model
{
  use Translatable;

  protected $table="badges";
  protected $translatable = ['name'];

  public function schedule(){
    return $this->belongsToMany('App\Schedule', 'schedule_badges', 'badge_id', 'schedule_id');
  }

}
