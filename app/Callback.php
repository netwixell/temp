<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    public $table = 'callback';
	  protected  $fillable = ['name','email','phone','question'];

    const STATUS_NEW = 'NEW';
    const STATUS_PROCESSED = 'PROCESSED';
    public static $statuses = [self::STATUS_NEW, self::STATUS_PROCESSED];

    public static function boot(){
      parent::boot();

      self::updating(function($model){

        $original_status = $model->getOriginal('status');

        if($model->status != $original_status){
          $model->unreadUsers()->detach();
        }

      });

      self::deleting(function($model){
          $model->unreadUsers()->detach();
      });
    }

    public function unreadUsers(){
      return $this->morphToMany('App\User', 'userable');
    }
}
