<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Quote extends Model
{
  use Translatable;

  protected $translatable = ['quote'];

  protected $table = 'quotes';

  public function person(){
    return $this->belongsTo('App\Person','person_id');
  }
}
