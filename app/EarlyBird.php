<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EarlyBird extends Model
{
    use SoftDeletes;
    protected $table = 'early_birds';

    protected $dates = ['date_from', 'date_to', 'deleted_at'];

    public function ticket(){
        return $this->belongsTo('App\Ticket','ticket_id');
    }

    public function scopeCurrent($query){
      return $query->whereRaw('date_from<=curdate() and date_to>=curdate()');
    }
    public function scopeByDate($query, $date){

      // return $query->whereRaw('date_from<="{$date}" and date_to>="{$date}"');
      return $query->where('date_from','<=',$date)->where('date_to','>=',$date);
    }
}
