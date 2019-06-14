<?php
$team->load('event');

$event = $team->event;

$card = $ticket->cards[0];
?>
@component('client-emails.template-1.index',['footer_caption'=>'Dream Team', 'footer_link'=>'https://molfarforum.com/dream-team','footer_email'=>'dreamteam@molfarforum.com'])
@slot('header_image')
<img class="logo" src="{{url('/static/img/email/dream-team-logo.png')}}" width="140" height="140" style="-ms-interpolation-mode:bicubic;clear:both;display:block;height:140px;margin:0 auto;max-width:100%;outline:0;padding:35px 0 43px;text-decoration:none;width:140px">
@endslot

<h1 style="Margin:0;Margin-bottom:35px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.333;margin:0;margin-bottom:35px;padding:0;text-align:left;word-wrap:normal">
{{time_greetings()}}, {{$team->contact_name}}!</h1>
<table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
    <tbody>
        <tr style="padding:0;text-align:left;vertical-align:top">
            <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
        </tr>
    </tbody>
</table>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">Вы
    только что зарегистрировали команду {{$team->name}} для участия в конкурсе Dream Team.
    Отборочный этап конкурса пройдёт на сайте <a href="https://molfarforum.com"
        target="_blank" rel="noopener" style="Margin:0;color:inherit;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left;text-decoration:none">molfarforum.com</a>
        c 5 по 14 апреля 2019 года.
    {{-- c {{date('j',strtotime($event->date_from))}} по {{date('j',strtotime($event->date_to))}} {{locale_month(date('n',strtotime($event->date_to)))}} {{date('Y',strtotime($event->date_to))}} года. --}}
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">Как
    только наш менеджер подтвердит ваше участие,
    команда появится в списке зарегистрированных
    команд. Вы можете оплатить оргвзнос денежным
    переводом на карту ПриватБанка:</p>
@if(isset($card))
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
    {{card_format($card->card_number)}}, {{$card->name}}
    (возможна комиссия в зависимости от вашего банка).
    В комментарии к платежу укажите название вашей
    команды.</p>
@endif
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">Зимой
    состоится ряд бесплатных семинаров в рамках
    Dream Team. Семинары проведут судьи конкурса, а
    города будут выбраны на основе регистраций команд.
    Команды, оплатившие оргвзнос до января, смогут
    принять участие.</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">По
    любым вопросам, пишите нам на почту, в соц. сети
    или звоните по телефонам оставленным ниже (трубку
    возьмёт наш менеджер Ирина).</p>
<p class="p-last-child" style="Margin:0;Margin-bottom:10px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:10px;padding:0;text-align:left">
Команда Molfar Forum</p>

@endcomponent
