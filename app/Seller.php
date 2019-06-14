<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Seller extends Model
{
    use Translatable;
    protected $translatable = ['name'];
    protected $table='sellers';

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
