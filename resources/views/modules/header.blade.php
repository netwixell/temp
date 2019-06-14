<header class="header">
  <div class="header__container container">
    <nav class="header__nav"><a class="header__link header__link--logo" @if(!Request::is('/'))href="/"@endif>Главная
        <svg class="icon icon-molfar ">
          <use xlink:href="{{$src_dir}}/img/svg/symbol/sprite.svg#molfar"></use>
        </svg></a>
      <ul class="header__list header__list--links">
        <li class="header__link-wrapper"><a class="header__link header__link--mobile" @if(!Request::is('/'))href="/"@endif>Главная</a></li>
        <li class="header__link-wrapper"><a class="header__link" @if(!Request::is('schedule'))href="/schedule"@endif>Программа</a></li>
        <!-- <li class="header__link-wrapper"><a class="header__link" @if(!Request::is('throwback'))href="/throwback"@endif>Как было</a></li> -->
        <li class="header__link-wrapper"><a class="header__link" @if(!Request::is('dream-team'))href="/dream-team"@endif>Dream Team</a></li>
        <!-- <li class="header__link-wrapper"><a class="header__link" @if(!Request::is('dream-team/rules'))href="/dream-team/rules"@endif>Правила</a></li> -->
        <li class="header__link-wrapper"><a class="header__link" @if(!Request::is('news'))href="/news"@endif>Новости</a></li>
      </ul>
    </nav>
  </div>
</header>
