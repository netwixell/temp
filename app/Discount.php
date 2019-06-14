<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Discount extends Model
{
    use Translatable,
        SoftDeletes;
    protected $table = 'discounts';
    protected $translatable = ['bill_title', 'name', 'description'];
    public $additional_attributes = ['bill_title'];
    const TYPE_PERCENT = 'PERCENT';
    const TYPE_FLAT = 'FLAT';
    const TYPE_FIXED = 'FIXED';

    const CHECK_CASH = 'CASH';
    const CHECK_INSTALLMENTS = 'INSTALLMENTS';
    const CHECK_BOTH = 'BOTH';

    public static $discount_types = [self::TYPE_PERCENT, self::TYPE_FLAT, self::TYPE_FIXED];
    public static $check_types = [self::CHECK_CASH, self::CHECK_INSTALLMENTS, self::CHECK_BOTH];

    protected $dates = ['deleted_at'];

    public function tickets(){
        return $this->belongsToMany('App\Ticket', 'ticket_discounts', 'discount_id', 'ticket_id');
    }
    public function bill(){
        return $this->morphMany('App\Bill', 'priceable');
    }
    public function getBillTitleAttribute(){
        return $this->name;
    }

    public function bill_price($target_price){
      $type=$this->type;
      if($type==static::TYPE_PERCENT){
        $discount=$target_price*($this->value/100);
        return -$discount;
      }
      elseif($type==static::TYPE_FLAT){
        return -$this->value;
      }
      elseif($type==static::TYPE_FIXED){
        $val=$this->value;
        $discount = ($target_price < $val) ? ($val-$target_price) : -($target_price-$val);
        return $discount;
      }
      else{
        return 0;
      }

    }
}
