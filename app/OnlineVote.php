<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineVote extends Model
{
  protected $table = 'online_votes';

  public $timestamps = false;
  protected $dates = ['created_at'];

  public function poll(){
    return $this->belongsTo('App\Poll','poll_id');
  }
  public function team(){
    return $this->belongsTo('App\Team','team_id');
  }
}
