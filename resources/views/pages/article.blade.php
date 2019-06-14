@extends('layouts.main')

{{-- В title заголовок поста --}}
@section('title', !empty($item->seo_title) ? $item->seo_title : $item->title)

@section('pageModifier', 'page--article')

{{-- - В ogImage обложка поста --}}
@section('ogImage', !empty($item->image) ? url('/storage/'.$item->image) : url($src_dir.'/img/og-image.jpg'))

{{-- //- В description первые 300 символов поста --}}
@section('description', !empty($item->meta_description) ? $item->meta_description : $item->excerpt)

@section('keywords', $item->meta_keywords)

@section('content')

  @include('pages.article.article')

@endsection
@push('scripts:underBody')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.2&appId=2024332000993808&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@endpush
@push('scripts')
  <script defer src="{{$src_dir}}/js/article.min.js?v={{$cache_version}}"></script>
@endpush
