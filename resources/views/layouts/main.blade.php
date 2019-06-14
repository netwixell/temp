<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="page @yield('pageModifier')">
  <head>
    <script defer src="{{$src_dir}}/js/scripts.min.js?v={{$cache_version}}"></script>
    @stack('scripts')
    <meta charset="utf-8">
    <title>@hasSection('title')@yield('title')@else{{setting('site.title')}}@endif</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('modules.meta')
    @include('modules.favicon')
    @stack('styles')
    <style body="opacity: 0; overflow-x: hidden;" html="background-color: #000;"></style>
    @include('modules.google-tag')
  </head>
  <body>
    @include('modules.google-tag-noscript')
    @stack('scripts:underBody')
    <div class="page__wrapper">
      @if (session('error'))
        <div class="alert alert--warning aos-animate aos-init" data-aos="fade-left">
          <p class="alert__text">{{ session('error') }}</p>
        </div>
      @endif
      @include('modules.menu')
      @include('modules.header')
      <main class="page__content">
        @yield('content')
      </main>
      @include('modules.footer')
    </div>
    <link rel="stylesheet" type="text/css" href="{{$src_dir}}/css/style.min.css?v={{$cache_version}}">
  </body>
</html>
