@component('client-email.index.index',['footer_caption'=>'Dream Team', 'footer_link'=>'https://molfarforum.com/dream-team','footer_email'=>'dreamteam@molfarforum.com'])
@slot('header_image')
<img class="logo" src="{{url('/client-email/img/layout/dream-team-logo.png')}}" width="140" height="140" style="-ms-interpolation-mode:bicubic;clear:both;display:block;height:140px;margin:0 auto;max-width:100%;outline:0;padding:35px 0 43px;text-decoration:none;width:140px">
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
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  {!!__('emails.new-team_body-1', [
      'team'=>$team->name,
      'link'=>'<a href="https://molfarforum.com" target="_blank" rel="noopener" style="Margin:0;color:inherit;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left;text-decoration:none">molfarforum.com</a>',
      'dayFrom'=>$poll->begin_at->day,
      'dayTo'=>$poll->end_at->day,
      'month'=>locale_month($poll->end_at->month),
      'year'=>$poll->end_at->year,
      ])!!}
</p>
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-team_body-2')
</p>
@if(isset($card))
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-team_card-details', ['cardNumber'=>card_format($card->card_number), 'cardName'=>$card->getTranslatedAttribute('name')])
</p>
@endif
<!-- <p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.new-team_body-3')
</p> -->
<p style="Margin:0;Margin-bottom:35px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:35px;padding:0;text-align:left">
  @lang('emails.questions')</p>
<p class="p-last-child" style="Margin:0;Margin-bottom:10px;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;margin-bottom:10px;padding:0;text-align:left">
  @lang('emails.team-molfar')</p>

@endcomponent
