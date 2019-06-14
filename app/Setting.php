<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public function scopeNotification($query){
      //settings.key like "notification%"
      return $query->where('key', 'like','notification%');
    }
    public function user_settings(){
      return $this->hasMany('App\UserSetting','setting_id');
    }
}
