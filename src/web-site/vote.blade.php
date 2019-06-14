@extends('web-site.layout-vote.layout-vote')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('description', $page->getTranslatedAttribute('meta_description'))

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif

@section('pageModifier', 'page--vote')

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.photoswipe.photoswipe')
  @include('web-site.vote.vote')
@endsection

@push('scripts')
   <script defer src="{{$src_dir}}/js/vote.min.js?v={{$cache_version}}"></script>
@endpush
