<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;


class Page extends Model
{
    use Translatable;
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    public static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $translatable = ['meta_description', 'meta_keywords', 'seo_title'];

    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', static::STATUS_INACTIVE);
    }
    public static function findBySlug($slug=''){
      return static::where('slug', $slug)->active();
    }

    public function event(){
        return $this->belongsTo('App\Event','event_id');
    }
    public function poll(){
      return $this->belongsTo('App\Poll','poll_id');
    }
    public function advertisement(){
        return $this->belongsToMany('App\Advertisement', 'page_advertisement', 'page_id', 'advertisement_id');
    }
    public function blocks(){
      return $this->hasMany('App\PageBlock','page_id');
    }
}
