<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use TCG\Voyager\Traits\Translatable;


class User extends \TCG\Voyager\Models\User
{
    use Notifiable,Translatable;

    protected $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function my_settings(){
      return $this->hasMany('App\UserSetting','user_id');
    }
    // public function unread_orders(){
    //   return $this->belongsToMany('App\Order', 'unread_orders', 'user_id', 'order_id');
    // }
    public function unreadOrders(){
      return $this->morphedByMany('App\Order', 'userable')->withPivot('created_at');
      //->withPivot('created_at');
    }
    public function unreadTeams(){
      return $this->morphedByMany('App\Team', 'userable')->withPivot('created_at');
    }
    public function unreadCallback(){
      return $this->morphedByMany('App\Callback', 'userable')->withPivot('created_at');
    }

}
