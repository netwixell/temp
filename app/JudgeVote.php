<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JudgeVote extends Model
{
  protected $table='judge_votes';

  public $timestamps = false;

  const CRITERION_COMPLEXITY = 'COMPLEXITY';
  const CRITERION_ORIGINALITY = 'ORIGINALITY';
  const CRITERION_COLOUR = 'COLOUR';
  const CRITERION_IMPRESSION = 'IMPRESSION';

  public static $criteria = [

    self::CRITERION_COMPLEXITY,
    self::CRITERION_ORIGINALITY,
    self::CRITERION_COLOUR,
    self::CRITERION_IMPRESSION,

  ];

  public function judgePoll(){
    return $this->belongsTo('App\JudgePoll','judge_poll_id');
  }
  public function team(){
    return $this->belongsTo('App\Team','team_id');
  }
}
