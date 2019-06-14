<section class="tickets" id="tickets">
  <div class="tickets__container container">
    <h2 class="tickets__title">Билеты</h2>
    <ol class="steps tickets__steps">
      <li class="steps__step"><span>Выберите <br>билет</span></li>
      <li class="steps__step"><span>Заполните <br>форму</span></li>
      <li class="steps__step"><span>Ожидайте <br>звонка</span></li>
    </ol>
    <div class="tickets__swiper-container swiper-container">
      <ul class="tickets__list swiper-wrapper">
        <?php $curdate=now(); ?>
        @foreach($event->tickets as $ticket)
        <?php
          $price=$ticket->price;

          $next_price=$ticket->next_price;
          $options=[];
          $options_group = [];
          foreach($ticket->options as $option){
            $group=$option->pivot->group;
            if(isset($group)){
                $options_group[$group][]=$option;
            }
            else{
              $options[]=$option;
            }
          }
        ?>
        <li class="ticket ticket--center tickets__ticket swiper-slide js-ticket">
        <form method="POST" action="/buying">
          @csrf
          <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
          <div class="ticket__title-wrapper">
            <h3 class="ticket__title">{{$ticket->flow}}</h3>
          <b class="ticket__price js-ticket__price" data-price="{{$price}}">{{thin_uah($price)}}</b>
          @if($price!=$next_price['price'] && !is_null($next_price['date_from']))
          <p class="ticket__price ticket__price--up">с {{locale_date($next_price['date_from'])}} — {{thin_uah($next_price['price'])}}</p>
          @endif
          </div>
            <ul class="ticket__offers">
            @foreach($options as $option)
                @if($option->type=='INCLUSIVE')
                <li class="ticket__offer">{{$option->name}}</li>
                @endif
            @endforeach
            @foreach($options_group as $group => $options)
                @if(count($options)==2)
                <?php
                $first_option=$options[0];
                $second_option=$options[1];
                ?>
                  <li class="ticket__offer">
                    <label class="toggler ticket__toggler">
                      <input class="js-ticket__price" name="options_group[{{$group}}]" type="checkbox" value="{{$second_option->id}}" data-price="{{$first_option->price}}" data-price-on="{{$second_option->price}}" data-price-off="{{$first_option->price}}">
                      <p class="toggler__toggle toggler__toggle--yes">{{$first_option->name}}</p>
                      <div class="toggler__slider"></div>
                      <p class="toggler__toggle toggler__toggle--no">{{$second_option->name}}</p>
                    </label>
                  </li>
                @endif
            @endforeach
          </ul>
          <button class="ticket__button js-ticket__button js-ticket__button--buying button button--red" type="submit">
            <span>Приобрести сейчас</span><b class="ticket__price ticket__price--white"></b>
          </button>
          <?php
          $installment=$ticket->installments->first();
          ?>
          @isset($installment)
          <input name="installment_id" type="hidden" value="{{$installment->id}}">
          <input name="first_payment" type="hidden" disabled value="{{$installment->first_payment}}">
          <input name="commission_k" type="hidden" disabled value="{{$installment->commission_k}}">
          <input name="payments_count" type="hidden" disabled value="{{payments_count($curdate,$installment->expires_at)}}">
          <button class="ticket__button js-ticket__button js-ticket__button--installment button button--unfilled" type="submit" formaction="/installment">
            <span>Приобрести в рассрочку</span><b class="ticket__price ticket__price--solid"></b>
          </button>
          @endisset
        </form>
        </li>
        @endforeach
      </ul>
      <button class="tickets__button tickets__button--prev swiper-button-prev"></button>
      <button class="tickets__button tickets__button--next swiper-button-next"></button>
    </div>
  </div>
</section>
