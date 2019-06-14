<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Prize extends Model
{
  use Translatable;

  protected $table = 'prizes';

   protected $translatable = ['title', 'description'];
}
