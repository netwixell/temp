<section class="expectations">
  <div class="expectations__title-wrapper container">
    <h2 class="expectations__title">@lang('expectations.title')</h2>
    <p class="expectations__description">@lang('expectations.description')</p>
  </div>
  <div class="expectations__container container">
    <ul class="expectations__list">
      <li class="card card--expectation expectations__card expectations__card--lectures lazyload" data-aos="fade-up">
        <h3 class="card__name">@lang('expectations.lectures_name')</h3>
        <p class="card__about">@lang('expectations.lectures_about')</p>
      </li>
      <li class="card card--expectation expectations__card expectations__card--networking lazyload" data-aos="fade-up">
        <h3 class="card__name">@lang('expectations.networking_name')</h3>
        <p class="card__about">@lang('expectations.networking_about')</p>
      </li>
      <li class="card card--expectation expectations__card expectations__card--exhibition lazyload" data-aos="fade-up">
        <h3 class="card__name">@lang('expectations.exhibition_name')</h3>
        <p class="card__about">@lang('expectations.exhibition_about')</p>
      </li>
      <li class="card card--expectation expectations__card expectations__card--party lazyload" data-aos="fade-up">
        <h3 class="card__name">@lang('expectations.party_name')</h3>
        <p class="card__about">@lang('expectations.party_about')</p>
      </li>
    </ul>
    @if($ticket_selling)<a class="expectations__button button button--red" data-scroll href="#tickets"><span>@lang('events.buy_ticket')</span></a>@endif
  </div>
</section>
