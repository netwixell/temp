<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';

    public function seller(){
        return $this->belongsTo('App\Seller','seller_id');
    }
}
