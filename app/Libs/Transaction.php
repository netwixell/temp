<?php

namespace App\Libs;

use Carbon\Carbon;

class Transaction
{
  public $number;
  public $date;
  public $amount;
  public $notice;

  // Transaction statuses:
  // 0 - waiting for payment in the future
  // 1 - need to pay now
  // 2 - overdue payment
  // 3 - missed payment
  // 4 - paid out
  public $status=0;


  public function __construct(int $number, Carbon $date, float $amount)
  {
      $this->number = $number;
      $this->date = $date;
      $this->amount = $amount;
  }
  public function setStatus(int $number){

    $this->status = $number;

  }

  public function paidOut($notice=''){
    $this->status = 4;
    $this->notice = $notice;
  }
  public function overduePayment(){
    $this->status = 2;
  }
  public function missedPayment(){
    $this->status = 3;
  }
  public function payNow(){
    $this->status = 1;
  }

  public function formatAmount() {
      return thin_uah( $this->amount );
  }

}
