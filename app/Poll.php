<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Poll extends Model
{
  use Translatable;

  protected $translatable = ['name'];

  protected $table='polls';

  protected $dates = ['begin_at', 'end_at'];

  const TYPE_COMPETITION = 'COMPETITION';
  const TYPE_JUDGE = 'JUDGE';
  const TYPE_ONLINE = 'ONLINE';
  const TYPE_AUDIENCE = 'AUDIENCE';

  public static $types = [

    self::TYPE_COMPETITION,
    self::TYPE_JUDGE,
    self::TYPE_ONLINE,
    self::TYPE_AUDIENCE,

  ];

  public function getIsOverAttribute(){
    return now()->gt($this->end_at);
  }
  public function getIsOpenAttribute(){
    $now = now();
    return ( $now->gte($this->begin_at) && $now->lte($this->end_at) );
  }

  public function children(){
    return $this->hasMany('App\Poll','parent_id');
  }
  public function parent(){
    return $this->belongsTo('App\Poll', 'parent_id')->whereNotIn('type', [$this::TYPE_ONLINE, $this::TYPE_FINAL]);
  }
  public function onlineVotes(){
    return $this->hasMany('App\OnlineVote','poll_id');
  }
  public function judgeVotes(){
    return $this->hasMany('App\JudgeVote','poll_id');
  }

  public function scopeOnline($query){
    return $query->where('type', static::TYPE_ONLINE);
  }
  public function scopeJudge($query){
    return $query->where('type', static::TYPE_JUDGE);
  }
  public function scopeCurrent($query){
    return $query->whereRaw('begin_at<=curdate() and end_at>=curdate()');
  }
}
