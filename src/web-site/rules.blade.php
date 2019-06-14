@extends('web-site.layout-rules.layout-rules')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('description', $page->getTranslatedAttribute('meta_description'))

@section('ogImage', url($src_dir.'/img/og-image--dream-team.jpg'))

@section('pageModifier', 'page--rules')

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.rules.rules')
@endsection

@push('scripts')
   <script defer src="{{$src_dir}}/js/rules.min.js?v={{$cache_version}}"></script>
@endpush
