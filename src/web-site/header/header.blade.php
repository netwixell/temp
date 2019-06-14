<?php

$links = [
  ['name' => __('menu.main'), 'href' => '', 'slug' => 'main'],
  ['name' => __('menu.schedule'), 'href' => 'schedule', 'slug' => 'schedule'],
  ['name' => __('menu.recreation'), 'href' => 'recreation', 'slug' => 'recreation'],
  ['name' => __('menu.dream-team'), 'href' => 'dream-team', 'slug' => 'dream-team'],
  ['name' => __('menu.vote'), 'href' => 'dream-team/vote', 'slug' => 'dream-team.vote'],
  ['name' => __('menu.news'), 'href' => 'news', 'slug' => 'news'],
];

?>
<header class="header">
  <div class="header__container container">
    <nav class="header__nav"><a class="header__link header__link--logo" @if(!Request::is('/'))href="/"@endif>Главная
        <svg class="icon icon-molfar ">
          <use xlink:href="{{$src_dir}}/img/svg/symbol/sprite.svg#molfar"></use>
        </svg></a>
      <ul class="header__list header__list--links">
        @foreach($links as $link)
        @if(!in_array($link['slug'], $inactive_pages))
        <li class="header__link-wrapper"><a class="header__link @if($loop->first){{'header__link--mobile'}}@endif" @if(!Request::is($link['href']))href="/{{$link['href']}}"@endif>{{$link['name']}}</a></li>
        @endif
        @endforeach
      </ul>
    </nav>
  </div>
</header>
