<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
  protected $table = 'order_logs';

  public $timestamps = false;

  public function order(){
     return $this->belongsTo('App\Order','order_id');
  }
  public function createdByUser(){
    return $this->belongsTo('App\User','created_by');
  }
}
