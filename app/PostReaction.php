<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
  protected $table = 'post_reactions';

  public $timestamps = false;

  const TYPE_LOVE = 'LOVE';
  const TYPE_FUNNY = 'FUNNY';
  const TYPE_WOW = 'WOW';
  const TYPE_ANGRY = 'ANGRY';

   public static $types = [

    self::TYPE_LOVE,
    self::TYPE_FUNNY,
    self::TYPE_WOW,
    self::TYPE_ANGRY,

  ];

  public function save(array $options = [])
  {
      if (!$this->created_at) {
          $this->created_at = now()->toDateTimeString();
      }

      parent::save();
  }

  public function scopeActive($query){
    return $query->where('is_active', '1');
  }

  public function post(){
    return $this->belongsTo('App\Post','post_id');
  }
}
