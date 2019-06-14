
<section class="buying">
  <div class="container buying__container">
    <h1 class="buying__title visually-hidden">Приобретение билета</h1><a class="buying__back" href="/#tickets"><span>К выбору билетов</span></a>
    <ol class="steps buying__steps">
      <li class="steps__step steps__step--current"><span>Выберите <br>билет</span></li>
      <li class="steps__step"><span>Заполните <br>форму</span></li>
      <li class="steps__step"><span>Ожидайте <br>звонка</span></li>
    </ol>
    <ul class="tabs visually-hidden" data-tabs>
      <li class="tabs__link-wrapper"><a class="tabs__link active" href="#ordering" data-tab></a></li>
      <li class="tabs__link-wrapper"><a class="tabs__link" href="#success" data-tab></a></li>
    </ul>
    <div class="tabs tabs--content" data-tabs-content>
      <div class="buying__wrapper tabs-pane active" id="ordering" data-tabs-pane>
        <table class="ticket buying__ticket">
          <caption class="ticket__title">Ваш билет</caption>
          <tr class="ticket__offers">
            <th class="ticket__offer">Поток:</th>
          </tr>
          <tr class="ticket__options">
          <td class="ticket__option">{{$ticket->flow}}</td>
          </tr>
          @foreach($order_options as $option)
          <tr class="ticket__offers">
          <th class="ticket__offer">{{__('options.'.$option->type)}}:</th>
          </tr>
          <tr class="ticket__options">
            <td class="ticket__option">{{$option->name}}</td>
          </tr>
          @endforeach
          <tfoot>
            <tr class="ticket__total">
              <th class="ticket__offer ticket__offer--total">К оплате:</th>
            <td class="ticket__price ticket__price--final">{{thin_uah($total_cost)}}</td>
            </tr>
          </tfoot>
        </table>
        <form class="form form--buying" method="POST" name="order" action="/checkout">
          @csrf
          <p class="form__line">
            <label class="form__label">Имя и фамилия
              <input class="form__input" type="text" name="name" placeholder="Анастасия Ресничкина" data-invalid-msg="Введите имя и фамилию через пробел" pattern="^[^\w\u0400-\u04ff,]*(?:[\w\u0400-\u04ff,]+(?:^|\s|$)[^]*){2}$" required>
            </label>
          </p>
          <p class="form__line">
            <label class="form__label">Телефон
              <input class="form__input" type="tel" id="tel" name="phone" data-invalid-msg="Введите телефон" placeholder="+380 (00) 000 00 00" pattern="^\+\d{3}\s\(\d{2}\)\s\d{3}\s\d{2}\s\d{2}$" required>
            </label>
          </p>
          <p class="form__line">
            <label class="form__label">Е-почта
              <input class="form__input" type="email" data-invalid-msg="Введите E-почту" name="email" placeholder="anastasia@mail.com" required>
            </label>
          </p>
          <p class="form__line">
            <label class="form__label">Город
              <input class="form__input" type="text" name="city" pattern=".{3,}" data-invalid-msg="Введите город" placeholder="Харьков" required>
            </label>
          </p>
          <p class="form__line form__line--promo">
            <label class="form__label form__label--promo-text">Промокод продавца (необязятельно)
              <input class="form__input form__input--promo-text" type="text" name="promocode[seller]" placeholder="Продавец">
            </label>
            <label class="form__label form__label--promo-num">
              <input class="form__input form__input--promo-num" oninput="this.value=this.value.slice(0,this.maxLength)" type="number" name="promocode[code]" maxlength="2" placeholder="00">
            </label>
          </p>
            <p class="form__line">
              <label class="form__label">Комментарий (необязательно)
                <textarea class="form__textarea" id="textarea" rows="5" maxlength="65535" name="comment"></textarea>
              </label>
            </p>
          <button class="form__button button button--unfilled" type="submit"><span>Оформить</span></button>
        </form>
      </div>
      <div class="buying__inner tabs-pane" id="success" data-tabs-pane>
        <div class="buying__success"><b class="buying__message">Спасибо за заказ</b>
          <p class="buying__description">В течение 15 минут PDF-файл с номером заказа придёт к вам на почту. Остаётся только его оплатить и можно готовить чемоданы!</p>
        </div>
        <div class="buying__wrapper">
          <table class="ticket buying__ticket">
            <caption class="ticket__title">Ваш билет</caption>
            <tr class="ticket__offers">
              <th class="ticket__offer">Поток:</th>
            </tr>
            <tr class="ticket__options">
              <td class="ticket__option">{{$ticket->flow}}</td>
            </tr>
            @foreach($order_options as $option)
            <tr class="ticket__offers">
            <th class="ticket__offer">{{__('options.'.$option->type)}}:</th>
            </tr>
            <tr class="ticket__options">
              <td class="ticket__option">{{$option->name}}</td>
            </tr>
            @endforeach
            <tfoot>
              <tr class="ticket__total">
                <th class="ticket__offer ticket__offer--total">К оплате:</th>
                <td class="ticket__price ticket__price--final">{{thin_uah($total_cost)}}</td>
              </tr>
            </tfoot>
          </table>
          <div class="payment-details buying__payment-details"><b class="payment-details__title">Способы оплаты</b>
            <p class="payment-details__text">Вы можете оплатить билет денежным переводом на карту ПриватБанка. В комментарии к платежу укажите номер заказа, который указан в вашем PDF-файле</p>
            @isset($card)
            <b class="payment-details__title payment-details__title--secondary">Реквизиты:</b>
            <span class="payment-details__text payment-details__text--card-number">{{card_format($card->card_number)}}</span>
            <span class="payment-details__text payment-details__text--card-holder">{{$card->name}}</span>
            @endisset
            <p class="payment-details__text">Либо вы можете оплатить билет наличными у представителя в вашем городе</p>
            <b class="payment-details__title payment-details__title--text">Вам позвонит менеджер, чтобы уточнить данные и способ оплаты</b>
            <?php $phones = explode(",",  setting('osnovnoe.payment_phone') );  ?>
            @foreach($phones as $phone)
            <span class="payment-details__text payment-details__text--phone-number">{{$phone}}</span>
            @endforeach
            <span class="payment-details__text payment-details__text--phone-holder">{{setting('osnovnoe.payment_name')}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
