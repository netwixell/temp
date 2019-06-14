<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class JudgePoll extends Model
{
  protected $table='judge_polls';

  public $timestamps = false;
  protected $dates = ['created_at'];

  protected static function boot()
  {
    parent::boot();

    if ( \Request::route()->getName() == 'voyager.judge-polls.index' && Auth::user()->role->name == 'judge' ) {
      static::addGlobalScope('user', function (Builder $builder) {
        $builder->where('user_id', '=', Auth::user()->id);
      });
    }
  }

  public function poll(){
    return $this->belongsTo('App\Poll','poll_id');
  }
  public function user(){
    return $this->belongsTo('App\User','user_id');
  }
  public function flow(){
    return $this->belongsTo('App\Flow','flow_id');
  }
  public function votes(){
    return $this->hasMany('App\JudgeVote','judge_poll_id');
  }
}
