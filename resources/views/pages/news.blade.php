@extends('layouts.main')

@section('title', $page->seo_title)

@section('pageModifier', 'page--news')

{{-- В ogImage обложка последней новости --}}

@section('ogImage', $ogImage )

{{-- В description заголовок последней новости --}}
@section('description', $metaDescription)

@section('keywords', $page->meta_keywords)

@section('content')
  @include('pages.news.news')
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
  <script defer src="{{$src_dir}}/js/news.min.js?v={{$cache_version}}"></script>
@endpush
