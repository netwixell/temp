<?php

  function price_uah($number){

    return number_format( $number , 0 , "." ,  " ").' ₴';

  }

  function thin_uah($number){

    return number_format(  $number , 0 , "." ,  " ").' ₴';
  }

  function phone_format($number){

        if(  preg_match( '/^\+?(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})$/', $number,  $matches ) )
        {
          $phone = '+'. $matches[1] . ' (' .$matches[2] . ') ' . $matches[3] . '-' . $matches[4]. '-' . $matches[5];
        }
        else{
            $phone=$number;
        }
        return $phone;
    }

    function card_format($number){

        if(  preg_match( '/^\+?(\d{4})(\d{4})(\d{4})(\d{4})$/', $number,  $matches ) )
        {
          $card = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
        }
        else{
            $card=$number;
        }
        return $card;
    }


  function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){

       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
       if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);

       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);

       switch( $str_interval){
           case "y":
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h":
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i":
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s":
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
               return -1 * $total;
       else    return $total;
   }

   function locale_month($month_n){
     $months = explode(',',__('format.when-months'));
      return $months[$month_n-1];
   }
   function locale_dow($w){
     $dow = explode(',',__('format.days-of-week'));

     return $dow[$w];
   }

   function locale_date($date_str, $format = '%d %s %d'){
      $time=strtotime($date_str);
      $day=date('j',$time);
      $month_n=date("n",$time);
      $year=date("Y",$time);
      $month=locale_month($month_n);

      return sprintf($format, $day, $month, $year);
    }

  function order_number_by_id($id){
    $salt = 'Molfar_with-salt,sugar,Paper.';
    $hashids = new \Hashids\Hashids($salt, 4, 'ABCEIKMOPTXY0123456789');
    $number = $hashids->encode($id);

    return $number;
  }

  function pretty_order_number($number,$chunk=4){

    if(strlen($number) > $chunk ){
      return $number;
    }
    else{
      return substr(chunk_split($number,$chunk,"-"),0,-1);
    }

    // $number=str_pad($id, 9, "0", STR_PAD_LEFT);

    // if(  preg_match( '/^\+?(\d{3})(\d{3})(\d{3})$/', $number,  $matches ) )
    // {
    //   $number = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
    // }

  }

  function time_greetings(){
    /* This sets the $time variable to the current hour in the 24 hour clock format */
    $time = date("H");
    /* Set the $timezone variable to become the current timezone */
    // $timezone = date("e");
    /* If the time is less than 1200 hours, show good morning */
    if ($time < "12") {
        echo __('format.good-morning');
    } else
    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
    if ($time >= "12" && $time < "17") {
        echo __('format.good-day');
    } else
    /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
    if ($time >= "17" && $time < "20") {
        echo __('format.good-evening');
    } else
    /* Finally, show good night if the time is greater than or equal to 2000 hours */
    if ($time >= "20") {
        echo __('format.good-night');
    }
  }

  function payments_count($begin_date,$end_date){

    // $begin_date->diffInMonths($end_date);


    // if( is_string( $begin_date)) $begin_date = date_create( $begin_date);
    //    if( is_string( $end_date)) $end_date = date_create( $end_date);

    //    $diff = date_diff( $begin_date, $end_date, true);

    //    $total= $diff->y * 12 + $diff->m;

    return $begin_date->diffInMonths($end_date);
  }

  function installment_plan($begin_date,$end_date,float $total_price, float $commission, float $first_payment){
    $result=[];
    $payments_count=payments_count($begin_date,$end_date);

    $total_repaid = $total_price*( ($commission/100) + 1 );

    $body = $total_repaid - $first_payment;

    $remain_division = $payments_count - ( $body % $payments_count );

    $body += $remain_division;

    $total_repaid += $remain_division;

    $monthly_payment= $body / $payments_count;

    $result['remain_division'] = (int)$remain_division;

    $result['payments_count'] = (int)$payments_count;
    $result['first_payment'] = (int)$first_payment;
    $result['total_repaid'] = (int)$total_repaid;
    $result['monthly_payment'] = (int)$monthly_payment;

    return $result;
  }

  function get_file_url($file_json){
        $file=json_decode($file_json);
        if(isset($file[0]) && isset($file[0]->download_link)){
          return $file['0']->download_link;
        }
        return '';
  }

  function earlyBirdDetails($early_bird, $ticket_price = 0){
    $result=[];

    $curr_month_n = $early_bird->date_from->diffInMonths( now() );
    $count_increases = $early_bird->date_from->diffInMonths( $early_bird->date_to ) + 1;

    $max_price = $ticket_price;
    $min_price = $early_bird->price;

    $monthly_increase = ($max_price - $min_price) / $count_increases;

    $current_price = $min_price + ( $monthly_increase * $curr_month_n);

    return compact('current_price', 'monthly_increase');
  }

  function declOfNum($number, $titles) {
    if(count($titles) == 2) return $number == 1 ? $titles[0] : $titles[1];
    $cases = [2, 0, 1, 1, 1, 2];
    return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[($number % 10 < 5) ? $number % 10 : 5]];
  }

  function getLocaleString($multiLangString){
    $currLang = app()->getLocale();
    $langs = [
      'ru' => 0,
      'en' => 1,
      'uk' => 2
    ];
    $currLangIndex = $langs[$currLang] ?? 0;
    $multiLangStrings = explode('|', $multiLangString);

    return $multiLangStrings[ $currLangIndex ] ?? '';
  }

  function getPaymentName(){
    return getLocaleString(setting('osnovnoe.payment_name'));
  }

  function getPaymentPhones(){
    return explode(",",  setting('osnovnoe.payment_phone') );
  }
