<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class EventPerson extends Model
{
  use Translatable;

    protected $translatable = ['caption'];
    protected $table="event_persons";

    const POSITION_SPEAKER = 'SPEAKER';
    const POSITION_JUDGE = 'JUDGE';
    const POSITION_MAIN_JUDGE = 'MAIN_JUDGE';
    public static $positions = [self::POSITION_SPEAKER, self::POSITION_JUDGE, self::POSITION_MAIN_JUDGE];
    public static $judge_positions = [self::POSITION_JUDGE, self::POSITION_MAIN_JUDGE];

    public $additional_attributes = ['full_name'];

  public function scopeSpeakers($query){
      return $query->where('position', static::POSITION_SPEAKER);
  }
  public function scopeJudges($query){
      return $query->whereIn('position',self::$judge_positions);
  }
  public function scopeMainJudges($query){
      return $query->where('position', static::POSITION_MAIN_JUDGE);
  }
  public function scopeCommonJudges($query){
      return $query->where('position', static::POSITION_JUDGE);
  }


  public function event(){
      return $this->belongsTo('App\Event','event_id');
  }
  public function person(){
      return $this->belongsTo('App\Person','person_id');
  }
  public function flow(){
      return $this->belongsTo('App\Flow','flow_id');
  }

  public function getFullNameAttribute(){

      return $this->person->name.': '.$this->caption;
  }
}
