<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Event extends Model
{
    use Translatable;

    protected $translatable = ['name', 'place'];
    protected $table='events';

    public $additional_attributes = ['title'];

    public function tickets(){
        return $this->hasMany('App\Ticket','event_id');
    }
    public function schedule(){
        return $this->hasMany('App\Schedule','event_id');
    }
    public function persons(){
        return $this->hasMany('App\EventPerson','event_id');
    }
    public function teams(){
      return $this->hasMany('App\Team','event_id');
  }
    public function speeches(){
        return $this->belongsToMany('App\Speech', 'event_speeches', 'event_id', 'speech_id');
    }
    public function partners(){
        return $this->belongsToMany('App\Partner', 'event_partners', 'event_id', 'partner_id');
    }

    //TODO: Сделать ввод в админке текущего события
    public static function current(){
      return static::where('slug', 'molfar-forum');
    }
    public static function findBySlug($slug=''){
      return static::where('slug', $slug);
    }
    public function getTitleAttribute(){
      $date=date('d.m.y',strtotime($this->date_from));

      return $date. ' – '.$this->name;
    }
}
