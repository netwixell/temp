<footer class="footer">
  <div class="footer__container container">
    <div class="footer__wrapper">
      <ul class="footer__list footer__list--lang">
        <li class="footer__link-wrapper inactive"><a class="footer__link footer__link--lang" href="" title="Страница в разработке">укр</a></li>
        <li class="footer__link-wrapper inactive"><a class="footer__link footer__link--lang" href="" title="Страница в разработке">eng</a></li>
        <li class="footer__link-wrapper"><a class="footer__link footer__link--lang">рус</a></li>
      </ul>
      <div class="footer__link-wrapper"><a class="footer__link" @if(!Request::is('privacy'))href="/privacy"@endif>Политика конфиденциальности</a></div>
    </div>

    <div class="footer__made-by">
      <a class="footer__link" href="http://kontora.design" target="_blank", rel="noopener" title="Сделано в «Дизайн-Конторе»">Сделано в «Дизайн-Конторе»
        <svg class="icon icon-kontora ">
          <use xlink:href="{{$src_dir}}/img/svg/symbol/sprite.svg#kontora"></use>
        </svg>
      </a>
    </div>
  </div>
</footer>
