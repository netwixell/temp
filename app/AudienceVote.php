<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudienceVote extends Model
{

  protected $table='audience_votes';

  public function poll(){
    return $this->belongsTo('App\Poll','poll_id');
  }
  public function team(){
    return $this->belongsTo('App\Team','team_id');
  }
}
