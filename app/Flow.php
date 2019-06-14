<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Flow extends Model
{
  use SoftDeletes, Translatable;

  protected $table="flows";
  protected $translatable = ['name'];

  protected $dates = ['deleted_at'];

  public function role(){
    return $this->belongsTo('App\Role','role_id');
  }
  public function user(){
    return $this->belongsTo('App\User','user_id');
  }

}
