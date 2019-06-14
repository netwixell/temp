<?php $locale = app()->getLocale(); ?>
<footer class="footer">
  <div class="footer__container container">
    <div class="footer__wrapper">
      <ul class="footer__list footer__list--lang">
        {{-- class inactive если ссылка заблокирована --}}
        <li class="footer__link-wrapper"><a class="footer__link footer__link--lang" @if($locale != 'uk')href="?lang=uk"@endif>укр</a></li>
        <li class="footer__link-wrapper"><a class="footer__link footer__link--lang" @if($locale != 'en')href="?lang=en"@endif>eng</a></li>
        <li class="footer__link-wrapper"><a class="footer__link footer__link--lang" @if($locale != 'ru')href="?lang=ru"@endif>рус</a></li>
      </ul>
      <div class="footer__link-wrapper"><a class="footer__link" @if(!Request::is('privacy'))href="/privacy"@endif>@lang('menu.privacy')</a></div>
    </div>

  <div class="footer__made-by" style="background-image: url({{url($src_dir.'/img/made-in_'.$locale.'.svg')}})">
      <a class="footer__link" href="http://kontora.design" target="_blank" rel="noopener" title="@lang('menu.kontora-design')">@lang('menu.kontora-design')
        <svg class="icon icon-kontora ">
          <use xlink:href="{{$src_dir}}/img/svg/symbol/sprite.svg#kontora"></use>
        </svg>
      </a>
    </div>
  </div>
</footer>
