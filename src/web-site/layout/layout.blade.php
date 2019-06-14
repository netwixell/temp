<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="page @yield('pageModifier')">
  <head>
    <script defer src="{{$src_dir}}/js/scripts.min.js?v={{$cache_version}}"></script>
    @stack('scripts')
    <meta charset="utf-8">
    <title>@hasSection('title')@yield('title')@else{{setting('site.title')}}@endif</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('web-site.meta.meta')
    @include('web-site.favicon.favicon')
    @include('web-site.g-tag.g-tag')
    @stack('styles')
    <style body="opacity: 0; overflow-x: hidden;" html="background-color: #000;"></style>
  </head>
  <body>
    @include('web-site.g-tag._noscript.g-tag_noscript')
    @stack('scripts:underBody')
    <div class="page__wrapper">
      @if (session('error'))
        @include('web-site.alert.alert', ['message'=>session('error')])
      @endif
      @include('web-site.button-menu.button-menu')
      @include('web-site.header.header')
      <main class="page__content">
        @yield('content')
      </main>
      @include('web-site.footer.footer')
    </div>
    <link rel="stylesheet" type="text/css" href="{{$src_dir}}/css/style.min.css?v={{$cache_version}}">
  </body>
</html>
