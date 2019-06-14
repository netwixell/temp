<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table='bills';
    public $timestamps = false;

    public function order(){
        return $this->belongsTo('App\Order','order_id');
    }
    public function priceable()
    {
        return $this->morphTo();
    }
}
