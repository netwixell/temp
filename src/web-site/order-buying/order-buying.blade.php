<section class="buying">
  <div class="container buying__container">
    <h1 class="buying__title visually-hidden">@lang('orders.title_cash')</h1>
    <a class="buying__back" href="/#tickets"><span>@lang('orders.return_back')</span></a>
    <ol class="steps buying__steps">
    <li class="steps__step steps__step--current"><span>{!!__('tickets.step_1')!!}</span></li>
      <li class="steps__step"><span>{!!__('tickets.step_2')!!}</span></li>
      <li class="steps__step"><span>{!!__('tickets.step_3')!!}</span></li>
    </ol>
    <ul class="tabs visually-hidden" data-tabs>
      <li class="tabs__link-wrapper"><a class="tabs__link active" href="#ordering" data-tab></a></li>
      <li class="tabs__link-wrapper"><a class="tabs__link" href="#success" data-tab></a></li>
    </ul>
    <div class="tabs tabs--content" data-tabs-content>
      <div class="buying__wrapper tabs-pane active" id="ordering" data-tabs-pane>
        <table class="ticket buying__ticket">
          <caption class="ticket__title">@lang('orders.ticket_title')</caption>
          <tr class="ticket__offers">
            <th class="ticket__offer">@lang('orders.ticket_flow')</th>
          </tr>
          <tr class="ticket__options">
          <td class="ticket__option">{{$ticket->getTranslatedAttribute('flow')}}</td>
          </tr>
          @foreach($order_options as $option)
          <tr class="ticket__offers">
          <th class="ticket__offer">{{__('options.'.$option->type)}}:</th>
          </tr>
          <tr class="ticket__options">
            <td class="ticket__option">{{$option->getTranslatedAttribute('name')}}</td>
          </tr>
          @endforeach
          <tfoot>
            <tr class="ticket__total">
              <th class="ticket__offer ticket__offer--total">@lang('orders.ticket_total')</th>
            <td class="ticket__price ticket__price--final">{{thin_uah($total_cost)}}</td>
            </tr>
          </tfoot>
        </table>
        <form class="form form--buying" method="POST" name="order" action="/checkout">
          @csrf
          <p class="form__line">
            <label class="form__label">@lang('orders.label_name')
              <input class="form__input" type="text" name="name" placeholder="@lang('orders.placeholder_name')" data-invalid-msg="@lang('orders.error_name')" pattern="^[^\w\u0400-\u04ff,]*(?:[\w\u0400-\u04ff,]+(?:^|\s|$)[^]*){2}$" required>
            </label>
          </p>
          <p class="form__line">
            <label class="form__label">@lang('orders.label_phone')
              <input class="form__input" type="tel" id="tel" name="phone" data-invalid-msg="@lang('orders.error_phone')" placeholder="@lang('orders.placeholder_phone')" pattern="^\+\d{3}\s\(\d{2}\)\s\d{3}\s\d{2}\s\d{2}$" required>
            </label>
          </p>
          <p class="form__line">
            <label class="form__label">@lang('orders.label_email')
              <input class="form__input" type="email" data-invalid-msg="@lang('orders.error_email')" name="email" placeholder="@lang('orders.placeholder_email')" required>
            </label>
          </p>
          <p class="form__line">
            <label class="form__label">@lang('orders.label_city')
              <input class="form__input" type="text" name="city" pattern=".{3,}" data-invalid-msg="@lang('orders.error_city')" placeholder="@lang('orders.placeholder_city')" required>
            </label>
          </p>
          <p class="form__line form__line--promo">
            <label class="form__label form__label--promo-text">@lang('orders.label_promocode')
              <input class="form__input form__input--promo-text" type="text" name="promocode[seller]" placeholder="@lang('orders.placeholder_promocode')">
            </label>
            <label class="form__label form__label--promo-num">
              <input class="form__input form__input--promo-num" oninput="this.value=this.value.slice(0,this.maxLength)" type="number" name="promocode[code]" maxlength="2" placeholder="00">
            </label>
          </p>
            <p class="form__line">
              <label class="form__label">@lang('orders.label_comment')
                <textarea class="form__textarea" id="textarea" rows="5" maxlength="65535" name="comment"></textarea>
              </label>
            </p>
          <button class="form__button button button--unfilled" type="submit"><span>@lang('orders.submit')</span></button>
        </form>
      </div>
      <div class="buying__inner tabs-pane" id="success" data-tabs-pane>
        <div class="buying__success"><b class="buying__message">@lang('orders.completed_message')</b>
          <p class="buying__description">@lang('orders.completed_description')</p>
        </div>
        <div class="buying__wrapper">
          <table class="ticket buying__ticket">
            <caption class="ticket__title">@lang('orders.ticket_title')</caption>
            <tr class="ticket__offers">
              <th class="ticket__offer">@lang('orders.ticket_flow')</th>
            </tr>
            <tr class="ticket__options">
              <td class="ticket__option">{{$ticket->getTranslatedAttribute('flow')}}</td>
            </tr>
            @foreach($order_options as $option)
            <tr class="ticket__offers">
            <th class="ticket__offer">{{__('options.'.$option->type)}}:</th>
            </tr>
            <tr class="ticket__options">
              <td class="ticket__option">{{$option->getTranslatedAttribute('name')}}</td>
            </tr>
            @endforeach
            <tfoot>
              <tr class="ticket__total">
                <th class="ticket__offer ticket__offer--total">@lang('orders.ticket_total')</th>
                <td class="ticket__price ticket__price--final">{{thin_uah($total_cost)}}</td>
              </tr>
            </tfoot>
          </table>
          <div class="payment-details buying__payment-details"><b class="payment-details__title">@lang('orders.payment-details_title-1')</b>
            <p class="payment-details__text">@lang('orders.payment-details_text-1')</p>
            @isset($card)
            <b class="payment-details__title payment-details__title--secondary">@lang('orders.payment-details_title-2')</b>
            <span class="payment-details__text payment-details__text--card-number">{{card_format($card->card_number)}}</span>
            <span class="payment-details__text payment-details__text--card-holder">{{$card->getTranslatedAttribute('name')}}</span>
            @endisset
            <p class="payment-details__text">@lang('orders.payment-details_text-2')</p>
            <b class="payment-details__title payment-details__title--text">@lang('orders.payment-details_text-3')</b>
            @foreach(getPaymentPhones() as $phone)
            <span class="payment-details__text payment-details__text--phone-number">{{$phone}}</span>
            @endforeach
            <span class="payment-details__text payment-details__text--phone-holder">{{getPaymentName()}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
