<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;

class UserSetting extends Model
{
    protected $table = 'user_settings';

    public function scopeSelf($query){
      $user_id=Auth::id();
      return $query->where('user_id', $user_id);
    }


    public function scopeEverything($query){

      $user_id=Auth::id();


  // select settings.id,settings.key,settings.display_name,settings.details,settings.type,COALESCE(user_settings.value,settings.value) as value from settings
  // left join user_settings on settings.id=user_settings.setting_id
  // where settings.key like 'notification%' and (user_settings.user_id=1 or user_settings.user_id is null);


  $settings=DB::table('settings')
  ->selectRaw('settings.id,settings.key,settings.display_name,settings.details,settings.type,COALESCE(user_settings.value,settings.value) as value')
  ->leftJoin('user_settings', 'settings.id', '=', 'user_settings.setting_id')
  ->whereRaw('settings.key like "notification%" and (user_settings.user_id="'.$user_id.'" or user_settings.user_id is null)');

      // $settings= Voyager::model('Setting')->where('key', 'like', 'notification%');


      return $settings;


    }
}
