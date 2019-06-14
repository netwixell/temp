<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $table = 'payments';

    protected  $fillable = ['order_id','amount','notice'];

    protected $dates = ['deleted_at'];

    public function order(){
        return $this->belongsTo('App\Order','order_id');
    }

     public function getAmountAttribute($value)
    {
        return (int)$value;
    }
}
