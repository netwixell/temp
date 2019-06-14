@extends('web-site.layout.layout')

{{-- В title заголовок поста --}}
@section('title', !empty($item->seo_title) ? $item->getTranslatedAttribute('seo_title') : $item->getTranslatedAttribute('title'))

@section('pageModifier', 'page--article')

{{-- - В ogImage обложка поста --}}
@section('ogImage', !empty($item->image) ? url('/storage/'.$item->image) : url($src_dir.'/img/og-image.jpg'))

{{-- //- В description первые 300 символов поста --}}
@section('description', !empty($item->meta_description) ? $item->getTranslatedAttribute('meta_description') : str_limit($item->getTranslatedAttribute('excerpt'), 300))

@section('keywords', $item->getTranslatedAttribute('meta_keywords'))

@section('content')

  @include('web-site.article.article')

@endsection
@push('scripts:underBody')
<?php
  $localeCodes = [
    'ru'=>'ru_RU',
    'en'=>'en_US',
    'uk'=>'uk_UA',
  ];

  $localeCode = $localeCodes[ app()->getLocale() ] ?? 'ru_RU';
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/{{$localeCode}}/sdk.js#xfbml=1&version=v3.2&appId=2024332000993808&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@endpush
@push('scripts')
  <script defer src="{{$src_dir}}/js/article.min.js?v={{$cache_version}}"></script>
@endpush
