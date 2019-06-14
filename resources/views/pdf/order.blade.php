<html class="page" lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ваш билет — Molfar Beauty Forum</title>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="description" content="Главная бьюти-конференция в Украине"/>
    <style>

      html {
        box-sizing: border-box;
      }
      body {
        /*font-family: "dejavu sans";*/
        font-family: 'Verdana';
        font-size: 14px;
      }
      *,
      *::before,
      *::after {
        box-sizing: inherit;
      }
      .pdf {
        /*font-size: 16px;*/
        color: #4f4f4f;
      }
      .pdf__container {
        /*max-width: 595px;*/
        width: 100%;
        padding-left: 4%;
        padding-right: 4%;
        margin-left: auto;
        margin-right: auto;
      }
      .pdf nav {
        display: inline-block;
      }
      .pdf a {
        display: block;
        color: inherit;
        font-weight: inherit;
        text-decoration: none;
      }
      .pdf header {
        padding-top: 30px;
        margin-bottom: 65px;
      }
      .pdf ul {
        float: right;
        margin: 0;
        padding: 0;
        list-style: none;
      }
      .pdf ul::after {
        content: "";
        clear: both;
      }
      .pdf li {
        margin-bottom: 5px;
      }
      .pdf address {
        font-style: inherit;
      }
      .pdf table {
        color: inherit;
        border-collapse: collapse;
        table-layout: fixed;
        width: 100%;
      }
      .pdf table {
        margin-bottom: 30px;
      }
      .pdf thead td {
        font-size: 24px;
      }
      .pdf th {
        padding-bottom: 5px;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.15;
        text-align: left;
      }
      .pdf td {
        padding-bottom: 30px;
        font-weight: 700;
        line-height: 1.15;
        color: #333;
      }
      .pdf p {
        margin: 0;
      }
      .pdf p:first-of-type {
        margin-bottom: 30px;
      }

      /* @media only screen and (min-width: 1024px) {
        .container {
          padding-left: 40px;
          padding-right: 40px;
        } */

    </style>
  </head>
  <body>
    <?php
    $order->load(['ticket','bill_options'=>function($query){
      $query->accommodation();
    }]);

    $ticket= $order->ticket;
    $accommodation = isset( $order->bill_options[0]) ? $order->bill_options[0]->name : '—';
    ?>
    <main class="page__content">
      <div class="pdf">
        <div class="pdf__container container">
          <header>
            <nav><a href="{{url('/')}}" target="_blank", rel="noopener"><img src="{{public_path('/static/img/pdf/molfar.png')}}" width="160" heigth="51" alt="Molfar Beauty Forum ‘19"/></a></nav>
            <ul>
              <li>Molfar Beauty Forum ‘19</li>
              <li>
                <time datetime="2019-05">12 – 16 мая 2019</time>
              </li>
              <li>
                <address>ГК Буковель, Украина</address>
              </li>
            </ul>
          </header>
          <table>
            <thead>
              <tr>
                <th colspan="2">Номер заказа</th>
              </tr>
              <tr>
                <td colspan="2">{{pretty_order_number($order->number)}}</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th colspan="2">Имя участника</th>
              </tr>
              <tr>
                <td colspan="2">{{$order->name}}</td>
              </tr>
              <tr>
                <th>Поток</th>
                <th>Проживание</th>
              </tr>
              <tr>
                <td>{{$ticket->flow}}</td>
                <td>{{$accommodation}}</td>
              </tr>
            </tbody>
          </table>
          <div>
            @if($ticket->slug=='universal')
            <p>Оплаченный билет даёт вам право проживания на територии ГК «Буковель», влючает завтраки, посещение всех докладов и мастер-классов во всех локациях.</p>
            @else
            <p>Оплаченный билет даёт вам право проживания на територии ГК «Буковель», влючает завтраки, посещение всех докладов и мастер-классов в локации «{{$ticket->flow}}».</p>
            @endif
            <p>В случае утраты билета обратитесь к менеджеру</p><p>+38 066 558 31 07</p><p>+38 098 318 71 15</p>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
