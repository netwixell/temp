<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Installment extends Model
{
    use Translatable,
        SoftDeletes;
    protected $translatable = ['name', 'description'];
    public $additional_attributes = ['commission_k'];
    protected $table = 'installments';

    protected $dates = ['expires_at','closed_at','deleted_at'];

    public function tickets(){
        return $this->belongsToMany('App\Ticket', 'ticket_installments', 'installment_id', 'ticket_id');
    }
    public function scopeAvailable($query){
      return $query->whereRaw('closed_at>curdate()');
    }
    public function getCommissionKAttribute(){
      $commission_k= ($this->commission/100)+1;
      return $commission_k;
    }
    public function getIsAvailableAttribute(){
      return $this->closed_at->greaterThan(now());
    }
}
