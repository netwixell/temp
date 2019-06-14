@extends('web-site.layout.layout')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('description', $page->getTranslatedAttribute('meta_description'))

@section('ogImage', url($src_dir.'/img/og-image.jpg'))

@section('pageModifier', 'page--privacy')

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.privacy.privacy')
@endsection

@push('scripts')
  {{-- <script defer src="{{$src_dir}}/js/privacy.min.js?v={{$cache_version}}"></script> --}}
@endpush
