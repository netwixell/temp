<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

use Illuminate\Support\Facades\DB;

use App\Order;

use Carbon\Carbon;

class Ticket extends Model
{
    use SoftDeletes,
        Translatable;

    protected $translatable = ['flow'];
    protected $table = 'tickets';

    protected $dates = ['deleted_at'];

    public $additional_attributes = ['title','bill_title','bill_price','price','next_price','remain','total_paid_out','installment_debt'];


    public function event(){
        return $this->belongsTo('App\Event','event_id');
    }
    public function options(){
        return $this->belongsToMany('App\Option', 'ticket_options', 'ticket_id', 'option_id');
    }
    public function discounts(){
        return $this->belongsToMany('App\Discount', 'ticket_discounts', 'ticket_id', 'discount_id');
    }
    public function installments(){
        return $this->belongsToMany('App\Installment', 'ticket_installments', 'ticket_id', 'installment_id');
    }
    public function cards(){
        return $this->belongsToMany('App\Card', 'ticket_cards', 'ticket_id', 'card_id');
    }
    public function orders(){
      return $this->hasMany('App\Order','ticket_id');
    }
    public function early_birds(){
      return $this->hasMany('App\EarlyBird','ticket_id');
    }
    public function ordersReserved(){
      return $this->orders()->reserved();
    }
    public function ordersPaid(){
      return $this->orders()->paid();
    }
    public function payments()
    {
        return $this->hasManyThrough(
            'App\Payment',
            'App\Order',
            'ticket_id', // Foreign key on orders table...
            'order_id', // Foreign key on payments table...
            'id', // Local key on tickets table...
            'id' // Local key on orders table...
        );
    }
    public function bill(){
        return $this->morphMany('App\Bill', 'priceable');
    }


    public function createdByUser(){
        return $this->belongsTo('App\User','created_by');
    }
    public function updatedByUser(){
        return $this->belongsTo('App\User','updated_by');
    }
     public function deletedByUser(){
        return $this->belongsTo('App\User','deleted_by');
    }

    public function scopeAvailable($query){

      // select t.flow from tickets t
      // where
      // t.qty >
      // (select count(b.id) from bills as b
      // join orders as o on b.order_id=o.id
      // where o.status in ("reserved","paid")
      // and b.priceable_id=t.id
      // and b.priceable_type="ticket");
      return $query->where('qty','>',function($q){
        $q->from('bills')->selectRaw('count(bills.id)')
        ->join('orders','bills.order_id','=','orders.id')
        ->whereIn('status',Order::$reserved_statuses)
        ->where('bills.priceable_type','ticket')
        ->whereRaw('bills.priceable_id = tickets.id');
      });

      // ->groupBy('priceable_id')
      //   ->havingRaw('count(bills.id) < tickets.qty');

      // return $query->whereRaw('tickets.qty > (select count(bills.id) from bills
      //   join orders on bills.order_id=orders.id
      //   where orders.status in ("reserved","paid")
      //   and bills.priceable_id=tickets.id
      //   and bills.priceable_type="ticket")');


    }

    public function scopeSale($query){
      return $query->where('is_available', '1');
    }


    public function getTotalPaidOutAttribute(){
      // $total=$this->bill()->whereHas('order',function($query){
      //   $query->where('status',Order::STATUS_PAID);
      // })->sum('price');
      $total=$this->payments()->sum('amount');
      return $total;
    }
    public function getInstallmentDebtAttribute(){

      $total_cost = $this->orders()->installment()->sum('total_price');

      $total_payment = $this->payments()->whereHas('order', function($query){
          $query->installment();
        })->sum('amount');


      return ( $total_cost - $total_payment );
    }
    public function getRemainAttribute(){
        $qty = $this->qty;

        $orders_count = $this->bill()
          ->whereHas('order',function($query){
            $query->reserved();
          })->count();

        $remain = $qty - $orders_count;

        return $remain;
    }
    public function getBillTitleAttribute(){

      $event_title = $this->event->title;

        return $event_title.'. Билет: '.$this->flow;
    }
    public function getTitleAttribute(){

        return $this->event->name.': '.$this->flow;
    }
    public function getPriceAttribute($value){
      $early_bird = $this->early_birds()->current()->first();

        if(isset($early_bird)){

          if($early_bird->monthly_increase){

            $early_bird_details = earlyBirdDetails($early_bird, $value);

            return $early_bird_details['current_price'];
          }

          return $early_bird->price;
        }
        return $value;
    }
    public function getNextPriceAttribute(){
       $result=[];

       $early_birds=$this->early_birds();
       $current=$early_birds->current()->first();

       if(is_null($current)){

         $next=$early_birds->orderBy('date_from','asc')->first();
          if(is_null($next)){
              $result['price']=$this->getOriginal('price');
          }
          else{
            $result['date_from']=$next->date_from;
            $result['price']=$next->price;
          }
       }
       else{

          $now = now();

          $date_to = Carbon::parse($current->date_to);
          $date_from = Carbon::parse($current->date_from);

          $count_increases = $date_from->diffInMonths( $date_to ) + 1;
          $next_month_n = $now->diffInMonths( $date_from ) + 1;

          if($current->monthly_increase && $next_month_n < $count_increases){

            $next_date = $date_from->addMonths($next_month_n);

            $max_price = $this->getOriginal('price');
            $min_price = $current->price;

            $price = $min_price + ( ( ($max_price - $min_price) / $count_increases ) * $next_month_n);

            $result['date_from']=$next_date;
            $result['price']=$price;

          }
          else{
              $next_date = date( 'Y-m-d', strtotime($current->date_to.' + 1 day') );

              $next=$this->early_birds()->byDate( $next_date )->first();

              if(is_null($next)){
                $result['date_from']=$next_date;
                $result['price']=$this->getOriginal('price');
              }
              else{
                $result['date_from']=$next->date_from;
                $result['price']=$next->price;
              }
          }
       }

        return $result;
    }
    public static function findBySlug($slug=''){
      return static::where('slug', $slug);
    }
    public function getBillPriceAttribute(){
        return $this->price;
    }
}
