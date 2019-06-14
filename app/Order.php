<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use App\Payment;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    const STATUS_NEW = 'NEW'; // recently received orders
    const STATUS_CONFIRMED = 'CONFIRMED'; // zero payment is paid

    const STATUS_OVERDUE_CONFIRMED = 'OVERDUE_CONFIRMED'; // when stayed confirmed more than 4 days

    const STATUS_OVERDUE_PAYMENT = 'OVERDUE_PAYMENT'; // 5 days left before payment

    const STATUS_MISSED_PAYMENT = 'MISSED_PAYMENT'; // one day left before payment

    const STATUS_PENDING_PAYMENT = 'PENDING_PAYMENT'; // status for installment. when first payment is paid
    const STATUS_RESERVED = 'RESERVED'; // if installment not paid in this year
    const STATUS_PAID = 'PAID'; // fully paid
    const STATUS_CANCELED = 'CANCELED'; // order canceled

    const PAYMENT_CASH = 'CASH';
    const PAYMENT_INSTALLMENTS = 'INSTALLMENTS';
    public static $payment_types = [self::PAYMENT_CASH, self::PAYMENT_INSTALLMENTS];
    public static $statuses = [
      self::STATUS_NEW,
      self::STATUS_CONFIRMED,

      self::STATUS_OVERDUE_CONFIRMED,
      self::STATUS_OVERDUE_PAYMENT,
      self::STATUS_MISSED_PAYMENT,

      self::STATUS_PENDING_PAYMENT,
      self::STATUS_PAID,
      self::STATUS_RESERVED,
      self::STATUS_CANCELED,
    ];
    public static $reserved_statuses = [
      self::STATUS_CONFIRMED,

      self::STATUS_OVERDUE_CONFIRMED,
      self::STATUS_OVERDUE_PAYMENT,
      self::STATUS_MISSED_PAYMENT,

      self::STATUS_PENDING_PAYMENT,
      self::STATUS_PAID
    ];
    public static $zero_statuses = [
      self::STATUS_NEW,
      self::STATUS_CANCELED
    ];
    public static $temporary_statuses = [
      self::STATUS_OVERDUE_CONFIRMED,
      self::STATUS_OVERDUE_PAYMENT,
      self::STATUS_MISSED_PAYMENT
    ];
    public static $status_switches = [
      self::STATUS_NEW => [self::STATUS_CONFIRMED, self::STATUS_CANCELED],
      self::STATUS_CONFIRMED => [self::STATUS_CANCELED], //self::STATUS_PAID, self::STATUS_PENDING_PAYMENT,

      self::STATUS_OVERDUE_CONFIRMED => [self::STATUS_CANCELED],

      self::STATUS_OVERDUE_PAYMENT => [self::STATUS_RESERVED, self::STATUS_CANCELED],

      self::STATUS_MISSED_PAYMENT => [self::STATUS_RESERVED, self::STATUS_CANCELED],

      self::STATUS_PENDING_PAYMENT => [self::STATUS_RESERVED, self::STATUS_CANCELED],

      self::STATUS_RESERVED => [self::STATUS_PENDING_PAYMENT, self::STATUS_CANCELED],
      self::STATUS_PAID => [self::STATUS_CANCELED],
      self::STATUS_CANCELED => [],
    ];

    public $additional_attributes = ['full_name','ticket_cost'];

    protected $dates = ['confirmed_at','deleted_at'];

    public function ticket(){
        return $this->belongsTo('App\Ticket','ticket_id');
    }
    public function seller(){
        return $this->belongsTo('App\Seller','seller_id');
    }
    public function card(){
        return $this->belongsTo('App\Card','card_id');
    }
    public function installment(){
        return $this->belongsTo('App\Installment','installment_id');
    }
    // public function unread_users(){
    //   return $this->belongsToMany('App\User', 'unread_orders', 'order_id', 'user_id');
    // }
    public function bill_options()
    {
        return $this->morphedByMany('App\Option', 'priceable', 'bills');
    }
    public function bill_tickets()
    {
        return $this->morphedByMany('App\Ticket', 'priceable', 'bills');
    }
    public function bill(){
        return $this->hasMany('App\Bill','order_id');
    }
    public function payments(){
      return $this->hasMany('App\Payment','order_id');
    }
    public function log(){
      return $this->hasMany('App\OrderLog','order_id');
    }
    public function getTicketCostAttribute(){
        return $this->bill->where('priceable_type','ticket')->sum('price');
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


    public function getFullNameAttribute(){
      $city=empty($this->city)?'':' ('.$this->city.')';
        return '№'.$this->number.' '.$this->name.$city;
    }
    public function scopeCountByTickets($query){

        $result=$query
        ->selectRaw('tickets.flow,tickets.qty,count(bills.priceable_id) as count')
        ->join('bills','bills.order_id','=','orders.id')
        ->join('tickets','tickets.id','=','bills.priceable_id')
        ->where('bills.priceable_type','ticket')
        ->reserved()
        ->groupBy('bills.priceable_id')
        ->get();

      return $result;
    }
    public function scopeInstallment($query){
      return $query->where('payment_type', static::PAYMENT_INSTALLMENTS);
    }
    public function scopeCalculation($query){
      $result=[];
      $total_paidout = Payment::sum('amount');
      $installment_cost = $query->installment()->sum('total_price');

      $installment_paidout = $query
        ->join('payments','payments.order_id','=','orders.id')
        ->installment()
        ->sum('payments.amount');


      $result['total_paidout'] = $total_paidout;
      $result['installment_cost'] = $installment_cost;
      $result['installment_paidout'] = $installment_paidout;

      return $result;
    }
    public function scopeNew($query){
      return $query->where('status', static::STATUS_NEW);
    }
    public function scopeReserved($query){
      return $query->whereIn('status',self::$reserved_statuses);
    }
    public function scopePaid($query){
      return $query->where('status', static::STATUS_PAID);
    }
    public function scopeCanceled($query){
      return $query->where('status', static::STATUS_CANCELED);
    }
    public function unreadUsers(){
      return $this->morphToMany('App\User', 'userable');
    }
}
