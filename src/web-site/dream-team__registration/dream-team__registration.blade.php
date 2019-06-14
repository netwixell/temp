<?php $registrationIsOpen = setting('osnovnoe.dt_registration-form'); ?>
<section class="registration @if($registrationIsOpen){{'registration--open'}}@endif" id="registration">
  <div class="registration__container container">
    <div class="registration__title-wrapper">
      <h2 class="registration__title">{{getLocaleString(setting('osnovnoe.dt_registration_title'))??''}}</h2>
      <p class="registration__description">{{getLocaleString(setting('osnovnoe.dt_registration_description'))??''}}</p>
    </div>
    <div class="registration__title-wrapper registration__title-wrapper--secondary">
      <h3 class="registration__title">@lang('dream-team-page.registration__title--2')</h3>
      <p class="registration__description">@lang('dream-team-page.registration__description--2')</p>
    </div>
    <ul class="registration__contacts">
      <li class="registration__contact-wrapper"><a class="registration__contact" href="tel:+380665583107">+38 066 558 31 07</a></li>
      <li class="registration__contact-wrapper"><a class="registration__contact" href="tel:+380983187115">+38 098 318 71 15</a></li>
      <li class="registration__contact-wrapper"><a class="registration__contact" href="mailto:dreamteam@molfarforum.com?subject=Dream Team 2019">dreamteam@molfarforum.com</a></li>
    </ul>
    @if($registrationIsOpen)@include('web-site.form-dt.form-dt')@endif
  </div>
</section>
