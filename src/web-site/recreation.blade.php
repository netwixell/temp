@extends('web-site.layout.layout')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('description', $page->getTranslatedAttribute('meta_description'))

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif

@section('pageModifier', 'page--recreation')

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.recreation.recreation__hero')
  @include('web-site.recreation.recreation__extreme')
  @include('web-site.recreation.recreation__relax')
  @include('web-site.recreation.recreation__kitchen')
  @include('web-site.recreation.recreation__mountains')
  @include('web-site.recreation.recreation__party')
@endsection

@push('scripts')
   <script defer src="{{$src_dir}}/js/recreation.min.js?v={{$cache_version}}"></script>
@endpush
