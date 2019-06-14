<?php
  $order->load(['ticket', 'card', 'bill_options'=>function($query){
    $query->accommodation();
  }]);

  $ticket=$order->ticket;

  $ticket->load('event');

  $event = $ticket->event;

  $card=$order->card;

  $accommodation = isset( $order->bill_options[0]) ? $order->bill_options[0]->name : '—';

?>

@component('client-emails.template-1.index',['footer_caption'=>'Molfar Beauty Forum', 'footer_link'=>'https://molfarforum.com/','footer_email'=>'inbox@molfarforum.com'])
@slot('header_image')
<img src="{{url('/static/img/email/molfar-cover.png')}}" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
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
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">Вы
    оформили бронь на билет «Molfar Beauty Forum ‘19,
    поток „{{$ticket->flow}}”». Форум пройдёт с {{date('j',strtotime($event->date_from))}} по {{date('j',strtotime($event->date_to))}} {{locale_month(date('n',strtotime($event->date_to)))}} в ГК «Буковель».</p>
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
                                        Имя<br><strong>{{$order->name}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        Телефон<br><strong>{{phone_format($order->phone)}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        Поток<br><strong>{{$ticket->flow}}</strong></p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last"
                            style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:16px;padding-left:0!important;padding-right:0!important;text-align:left;width:50%">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        Е-почта<br><strong>{{$order->email}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        Город<br><strong>{{$order->city}}</strong></p>
                                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                                        Проживание<br><strong>{{$accommodation}}</strong></p>
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
                        <p style="Margin:0;Margin-bottom:17px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:2.125;margin:0;margin-bottom:17px;padding:0;text-align:left">
                        К оплате: <strong class="price" style="Margin-left:28px;margin-left:28px">{{number_format($order->total_price,0,'.',' ')}} гривен</strong></p>
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
Вы можете оплатить билет денежным переводом на карту ПриватБанка:
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
    {{card_format($card->card_number)}}, {{$card->name}}
    (возможна комиссия в зависимости от вашего банка).
    В комментарии к платежу укажите номер заказа,
    который есть в вашем PDF-файле.</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">Успейте
    оплатить до {{locale_date($order->created_at.' + 5 days')}}, иначе ваша бронь будет снята.</p>
@if($ticket->slug=='universal')
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
    Оплаченный билет даёт вам право проживания на територии ГК «Буковель», влючает завтраки, посещение всех докладов и мастер-классов во всех локациях.
</p>
@else
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
    Оплаченный билет даёт вам право проживания на територии
    ГК «Буковель», влючает завтраки, посещения всех докладов и мастер-классов в локации «{{$ticket->flow}}».
</p>
@endif
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">После
    оплаты менеджер сообщит вам точку обмена в вашем
    городе, где вы сможете обменять свой оплаченный
    номер заказа на билет.</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">Сохраните
    PDF-файл. Он может пригодиться в случае утраты
    билета.</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">По
    любым вопросам, пишите нам на почту, в соц. сети
    или звоните по телефонам оставленным ниже (трубку
    возьмёт наш менеджер Ирина).</p>
<p class="p-last-child" style="Margin:0;Margin-bottom:10px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:10px;padding:0;text-align:left">Команда
    Molfar Forum</p>

{{-- .message --}}
@endcomponent
