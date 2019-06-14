<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

use App\Order;

class Option extends Model
{
    use Translatable,
        SoftDeletes;
    protected $table = 'options';
    protected $translatable = ['name'];
    const TYPE_ACCOMMODATION = 'ACCOMMODATION';
    const TYPE_FOOD = 'FOOD';
    const TYPE_INCLUSIVE = 'INCLUSIVE';
    public static $types = [self::TYPE_ACCOMMODATION, self::TYPE_FOOD, self::TYPE_INCLUSIVE];

    protected $dates = ['deleted_at'];

    public $additional_attributes = ['bill_title','bill_price','remain','title'];

    public function tickets(){
        return $this->belongsToMany('App\Ticket', 'ticket_options', 'option_id', 'ticket_id');
    }
    public function bill(){
        return $this->morphMany('App\Bill', 'priceable');
    }
    public function getRemainAttribute(){

      $bill_qty=$this->bill()->whereHas('order',function($query){
        $query->reserved();
      })->count();

      return  ($this->qty - $bill_qty);
    }
    public function getTitleAttribute(){
      $remain= ($this->type != static::TYPE_INCLUSIVE) ? ' x'.$this->remain : '';

      return  __('options.'.$this->type). ': '. $this->name . $remain;
    }
    public function getBillTitleAttribute(){

        return __('options.'.$this->type). ': '. $this->name;
    }
    public function getBillPriceAttribute(){

        return $this->price;
    }
    public function scopeAvailable($query){
      return $query->where('type','<>',static::TYPE_INCLUSIVE);
    }
    public function scopeAccommodation($query){
      return $query->where('type','=',static::TYPE_ACCOMMODATION);
    }
}
