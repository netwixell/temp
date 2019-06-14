<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Partner extends Model
{
    use Translatable;
    protected $translatable = ['name','caption'];
    protected $table='partners';
    public $timestamps = false;

    public function schedule(){
      return $this->belongsToMany('App\Schedule', 'schedule_partners', 'partner_id', 'schedule_id');
  }
}
