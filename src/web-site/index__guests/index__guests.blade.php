<section class="guests">
  <div class="guests__container container">
    <div class="guests__title-wrapper">
      <div class="guests__layer" data-rellax-speed="2" style="background-image: url({{$src_dir}}/img/guests/rombus_layer-1.png);"></div>
      <div class="guests__layer" data-rellax-speed="1" style="background-image: url({{$src_dir}}/img/guests/rombus_layer-2.png);"></div>
      <div class="guests__layer" data-rellax-speed="1" style="background-image: url({{$src_dir}}/img/guests/rombus_layer-3.png);"></div>
        <h2 class="guests__title">@lang('guests.title')</h2>
        <p class="guests__description">@lang('guests.description')</p>
    </div>
    <ul class="guests__list">
      <li class="card card--guest guests__card guests__card--hair lazyload">
        <h3 class="card__name">@lang('guests.hairdresser-colorist_name')</h3>
        <p class="card__about">@lang('guests.hairdresser-colorist_about')</p>
      </li>
      <li class="card card--guest guests__card guests__card--nails lazyload">
        <h3 class="card__name">@lang('guests.manicurist_name')</h3>
        <p class="card__about">@lang('guests.manicurist_about')</p>
      </li>
      <li class="card card--guest guests__card guests__card--visage lazyload">
        <h3 class="card__name">@lang('guests.visagiste_name')</h3>
        <p class="card__about">@lang('guests.visagiste_about')</p>
      </li>
      <li class="card card--guest guests__card guests__card--marketing lazyload">
        <h3 class="card__name">@lang('guests.marketer_name')</h3>
        <p class="card__about">@lang('guests.marketer_about')</p>
      </li>
      <li class="card card--guest guests__card guests__card--manager lazyload">
        <h3 class="card__name">@lang('guests.manager_name')</h3>
        <p class="card__about">@lang('guests.manager_about')</p>
      </li>
      <li class="card card--guest guests__card guests__card--vendor lazyload">
        <h3 class="card__name">@lang('guests.vendor_name')</h3>
        <p class="card__about">@lang('guests.vendor_about')</p>
      </li>
    </ul>
    @if($ticket_selling)<a class="guests__button button button--red" data-scroll href="#tickets"><span>@lang('events.buy_ticket')</span></a>@endif
  </div>
</section>
