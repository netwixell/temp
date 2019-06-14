<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#f3f3f3!important">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title></title>
    <style>
        @media only screen {
            html {
                min-height: 100%;
                background: #f3f3f3
            }
        }

        @media only screen and (max-width:596px) {
            table.body img {
                width: auto;
                height: auto
            }

            table.body center {
                min-width: 0 !important
            }

            table.body .container {
                width: 95% !important
            }

            table.body .columns {
                height: auto !important;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                padding-left: 16px !important;
                padding-right: 16px !important
            }

            table.body .columns .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }

            table.body .collapse .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }

            th.small-6 {
                display: inline-block !important;
                width: 50% !important
            }

            th.small-12 {
                display: inline-block !important;
                width: 100% !important
            }

            .columns th.small-12 {
                display: block !important;
                width: 100% !important
            }
        }

        @media only screen and (max-width:480px) {
            .secondary .price {
                display: block;
                margin-left: 0;
                Margin-left: 0
            }
        }

        @media screen and (max-width:596px) {

            .footer p,
            .footer th {
                text-align: center
            }
        }
    </style>
</head>
<?php
$team->load('event');

$event = $team->event;

$card = $ticket->cards[0];
?>
<body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#f3f3f3!important;box-sizing:border-box;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><span
        class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span>
    <table class="body" style="Margin:0;background:#f3f3f3!important;border-collapse:collapse;border-spacing:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;width:100%">
        <tr style="padding:0;text-align:left;vertical-align:top">
            <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                <center data-parsed="" style="min-width:580px;width:100%">
                    <table align="center" class="wrapper header float-center" style="Margin:0 auto;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%">
                        <tr style="padding:0;text-align:left;vertical-align:top">
                            <td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                <table align="center" class="container" style="Margin:0 auto;background:0 0;border-collapse:collapse;border-spacing:0;margin:0 auto;padding:0;text-align:inherit;vertical-align:top;width:580px">
                                    <tbody>
                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                            <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                <table class="row collapse" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:588px">
                                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                                                        <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left"><img
                                                                                class="logo" src="{{url('/static/img/email/dream-team-logo.png')}}"
                                                                                width="140" height="140" style="-ms-interpolation-mode:bicubic;clear:both;display:block;height:140px;margin:0 auto;max-width:100%;outline:0;padding:35px 0 43px;text-decoration:none;width:140px"></th>
                                                                        <th class="expander" style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
                        <tbody>
                            <tr style="padding:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                            <tr style="padding:0;text-align:left;vertical-align:top">
                                                <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                            <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
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
                                                                <p class="p-last-child" style="Margin:0;Margin-bottom:10px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:10px;padding:0;text-align:left">Команда
                                                                    Molfar Forum</p>
                                                            </th>
                                                            <th class="expander" style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" class="wrapper header footer float-center" style="Margin:0 auto;Margin-top:45px!important;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;margin-top:45px!important;padding:0;text-align:center;vertical-align:top;width:100%">
                        <tr style="padding:0;text-align:left;vertical-align:top">
                            <td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                <table align="center" class="container" style="Margin:0 auto;background:0 0;border-collapse:collapse;border-spacing:0;margin:0 auto;padding:0;text-align:inherit;vertical-align:top;width:580px">
                                    <tbody>
                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                            <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th class="small-12 large-3 columns first" style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:0;padding-left:16px;padding-right:8px;text-align:left;width:129px">
                                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                                                        <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                                                            <p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left"><a
                                                                                    href="https://molfarforum.com/dream-team"
                                                                                    target="_blank" rel="noopener"
                                                                                    style="Margin:0;color:inherit;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left;text-decoration:none">Dream Team</a><br><a
                                                                                    href="mailto:dreamteam@molfarforum.com"
                                                                                    style="Margin:0;color:inherit;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left;text-decoration:none">dreamteam@molfarforum.com</a></p>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th class="small-12 large-3 columns" style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:0;padding-left:8px;padding-right:8px;text-align:left;width:129px">
                                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                                                        <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                                                            <p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left"><a
                                                                                    href="tel:+380665583107" style="Margin:0;color:inherit;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left;text-decoration:none">+38
                                                                                    066 558 31 07</a><br><a href="tel:+380983187115"
                                                                                    style="Margin:0;color:inherit;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left;text-decoration:none">+38
                                                                                    098 318 71 15</a></p>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th class="small-12 large-3 columns last" style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:0;padding-left:8px;padding-right:16px;text-align:left;width:129px">
                                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                                                        <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left"><a
                                                                                class="social-link" href="https://www.facebook.com/molfarforum"
                                                                                target="_blank" rel="noopener" style="Margin:0;Margin-left:25px;color:inherit;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;margin-left:0;padding:0;padding-top:7px;text-align:left;text-decoration:none"><img
                                                                                    src="{{url('/static/img/email/facebook.png')}}" width="11" height="20" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
                                                                            </a><a class="social-link" href="https://www.instagram.com/molfarforum/"
                                                                                target="_blank" rel="noopener" style="Margin:0;Margin-left:25px;color:inherit;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;margin-left:25px;padding:0;padding-top:7px;text-align:left;text-decoration:none"><img
                                                                                    src="{{url('/static/img/email/instagram.png')}}" width="20" height="20"
                                                                                    style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
                                                                            </a><a class="social-link" href="https://www.youtube.com/channel/UCE1izHjz_yg10tuxaMdKysw"
                                                                                target="_blank" rel="noopener" style="Margin:0;Margin-left:25px;color:inherit;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;margin-left:25px;padding:0;padding-top:7px;text-align:left;text-decoration:none"><img
                                                                                    src="{{url('/static/img/email/youtube.png')}}" width="28" height="20" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"></a></th>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </center>
            </td>
        </tr>
    </table><!-- prevent Gmail on iOS font size manipulation -->
    <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
</body>

</html>
