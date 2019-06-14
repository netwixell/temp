@extends('web-site.layout.layout')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('description', $page->getTranslatedAttribute('meta_description'))

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif

@section('pageModifier', 'page--schedule')

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.schedule.schedule')
  @include('web-site.questions.questions')
@endsection

@push('scripts')
  <script defer src="{{$src_dir}}/js/schedule.min.js?v={{$cache_version}}"></script>
@endpush
