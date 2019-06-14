<section class="dt-promo">
  <div class="dt-promo__container container">
    <div class="dt-promo__title-wrapper">
      <h2 class="dt-promo__title-inner">
        <span class="dt-promo__description">@lang('dream-team.promo_description')</span>
        <span class="dt-promo__title">@lang('dream-team.promo_title')</span>
      </h2>
      <p class="dt-promo__text">@lang('dream-team.promo_text')</p>
    </div><a class="dt-promo__button button button--blue" href="/dream-team"><span>@lang('dream-team.promo_read-more')</span></a>
    <picture class="dt-promo__img-wrapper loading">
      <source type="image/webp" media="(min-width: 480px)" data-srcset="{{$src_dir}}/img/dt-promo/dt-about_768.webp 768w, {{$src_dir}}/img/dt-promo/dt-about_960.webp 960w, {{$src_dir}}/img/dt-promo/dt-about_1440.webp 1440w, {{$src_dir}}/img/dt-promo/dt-about_2880.webp 2880w">
      <source type="image/webp" data-srcset="{{$src_dir}}/img/dt-promo/dt-about_m_480.webp 320w, {{$src_dir}}/img/dt-promo/dt-about_m_768.webp 768w, {{$src_dir}}/img/dt-promo/dt-about_m_960.webp 960w">
      <source type="image/jpeg" media="(min-width: 480px)" data-srcset="{{$src_dir}}/img/dt-promo/dt-about_768.jpg 768w, {{$src_dir}}/img/dt-promo/dt-about_960.jpg 960w, {{$src_dir}}/img/dt-promo/dt-about_1440.jpg 1440w, {{$src_dir}}/img/dt-promo/dt-about_2880.jpg 2880w">
      <source type="image/jpeg" data-srcset="{{$src_dir}}/img/dt-promo/dt-about_m_480.jpg 320w, {{$src_dir}}/img/dt-promo/dt-about_m_768.jpg 768w, {{$src_dir}}/img/dt-promo/dt-about_m_960.jpg 960w"><img class="dt-promo__img lazyload" data-src="{{$src_dir}}/img/dt-promo/dt-about_480.jpg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="@lang('dream-team.promo_image-alt')">
    </picture>
  </div>
</section>
