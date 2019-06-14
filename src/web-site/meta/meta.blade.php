<!-- facebook open graph tags -->
<meta property="og:type" content="website">
<meta property="og:title" content="@hasSection('title')@yield('title')@else{{setting('site.title')}}@endif">
<meta name="description" content="@hasSection('description')@yield('description')@else{{setting('site.description')}}@endif">
<meta property="og:image" content="@hasSection('ogImage')@yield('ogImage')@else{{url($src_dir.'/img/og-image.jpg')}}@endif">
<meta property="og:image:secure_url" content="@hasSection('ogImage')@yield('ogImage')@else{{url($src_dir.'/img/og-image.jpg')}}@endif">
<!-- twitter card tags additive with the og: tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:domain" value="molfarforum.com">
<meta name="twitter:title">
<meta name="twitter:description">
<meta name="twitter:image">
<meta name="twitter:url" value="https://molfarforum.com/">
@if(isset($page->event))
<?php $event = $page->event; ?>
<meta name="twitter:label1" value="@lang('format.date')">
<meta name="twitter:data1" value="{{date('j',strtotime($event->date_from))}} – {{date('j',strtotime($event->date_to))}} {{locale_month(date('n',strtotime($event->date_to)))}}">
<meta name="twitter:label2" value="@lang('format.location')">
<meta name="twitter:data2" value="{{$event->getTranslatedAttribute('place')}}">
@endif
<!-- facebook app id -->
<meta property="fb:app_id" content="2024332000993808" />
{{-- X-CSRF-TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Laravel echo server address --}}
<meta name="laravel-echo-server-url" content="{{env('LARAVEL_ECHO_SERVER_URL', 'https://molfarforum.com/socket.io')}}">
