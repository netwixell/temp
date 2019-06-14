<?php
  // installment options

  $start_date = $order->created_at;
  if('NEW' === $order->status){
    $start_date = $order->created_at;
  }
  elseif('CONFIRMED' === $order->status){
    $start_date = $order->confirmed_at;
  }
  else{
    $order->load(['payments'=>function($query){

      $query->orderBy('created_at','asc')->take(1);

    }]);

    if( isset($order->payments[0]) ){
      $start_date = $order->payments[0]->created_at;
    }
    elseif( isset($order->confirmed_at) ){
      $start_date = $order->confirmed_at;
    }
    else{
      $start_date = $order->created_at;
    }
  }

  $installment=$order->installment;

  $installment_plan=installment_plan(
    $start_date,
    $installment->expires_at,
    $order->total_price,
    $installment->commission,
    $installment->first_payment);

  $first_payment = number_format($installment_plan['first_payment'],0,'.',' ').' '.declOfNum($installment_plan['first_payment'], explode(',',__('format.hryvnia')));
  $monthly_payment = number_format($installment_plan['monthly_payment'],0,'.',' ').' '.declOfNum($installment_plan['monthly_payment'], explode(',',__('format.hryvnia')));

  $payment_date = locale_date($order->created_at.' + 5 days');

?>

@component('client-email.index.index',['footer_caption'=>'Molfar Beauty Forum', 'footer_link'=>'https://molfarforum.com/','footer_email'=>'inbox@molfarforum.com'])
@slot('header_image')
<img src="{{url('/client-email/img/layout/molfar-cover.png')}}" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
@endslot
{{-- message --}}
<h1 style="Margin:0;Margin-bottom:35px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.333;margin:0;margin-bottom:35px;padding:0;text-align:left;word-wrap:normal">
{{time_greetings()}}, {{$order->name}}!</h1>
<table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
    <tbody>
        <tr style="padding:0;text-align:left;vertical-align:top">
            <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
        </tr>
    </tbody>
</table>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order_first-row', ['flow'=>$ticket->getTranslatedAttribute('flow'), 'dayFrom'=>date('j',strtotime($event->date_from)), 'dayTo'=>date('j',strtotime($event->date_to)), 'month'=>locale_month(date('n',strtotime($event->date_to)))])</p>
<table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%">
    <tr style="padding:0;text-align:left;vertical-align:top">
        <th class="callout-inner secondary" style="Margin:0;background:#f2f2f2;border:none;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:25px 16px 9px;text-align:left;width:100%">
            <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                <tbody>
                    <tr style="padding:0;text-align:left;vertical-align:top">
                        <th class="small-12 large-6 columns first"
                            style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:16px;padding-left:0!important;padding-right:0!important;text-align:left;width:50%">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        @lang('emails.caption_name')<br><strong>{{$order->name}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        @lang('emails.caption_phone')<br><strong>{{phone_format($order->phone)}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">@lang('emails.caption_flow')<br><strong>{{$ticket->getTranslatedAttribute('flow')}}</strong></p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last"
                            style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:16px;padding-left:0!important;padding-right:0!important;text-align:left;width:50%">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">@lang('emails.caption_email')<br><strong>{{$order->email}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">@lang('emails.caption_city')<br><strong>{{$order->city}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">@lang('emails.caption_accommodation')<br><strong>{{$accommodation}}</strong></p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </tbody>
            </table>
            <hr style="Margin-bottom:24px;Margin-top:-23px;border-color:#f2f2f22b;margin-bottom:24px;margin-top:-23px">
            <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                <tbody>
                    <tr style="padding:0;text-align:left;vertical-align:top">
                        <th class="price-column small-6 large-6 columns first"
                            style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:0;padding-left:0!important;padding-right:0!important;text-align:left;width:50%">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                          @lang('emails.caption_zero-payment')</p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                          @lang('emails.caption_monthly-payment')</p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                          @lang('emails.caption_payments-count')</p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                        <th class="price-column small-6 large-6 columns last"
                            style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:0;padding-left:0!important;padding-right:0!important;text-align:left;width:50%">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                        {{-- first payment --}}
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        <strong>{{$first_payment}}</strong>
                                        </p>
                                        {{-- monthly payment --}}
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        <strong>{{$monthly_payment}} / @lang('format.month')</strong></p>
                                        {{-- payments count --}}
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        <strong>{{$installment_plan['payments_count']}}</strong>
                                        </p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </tbody>
            </table>
        </th>
        <th class="expander" style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
    </tr>
</table>
<table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
    <tbody>
        <tr style="padding:0;text-align:left;vertical-align:top">
            <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
        </tr>
    </tbody>
</table>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order-installments_body-1', ['date'=>$payment_date, 'payment'=> $first_payment])
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order-installments_body-2',['payment'=>$monthly_payment])
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order-installments_body-3')
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order-installments_body-4')
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order_card-details', ['cardNumber'=>card_format($card->card_number), 'cardName'=>$card->getTranslatedAttribute('name')])
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order-installments_body-5')
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-order_save-pdf')</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.questions')</p>
<p class="p-last-child" style="Margin:0;Margin-bottom:10px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:10px;padding:0;text-align:left">
  @lang('emails.team-molfar')</p>
{{-- .message --}}
@endcomponent
