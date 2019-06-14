@extends('layouts.main')

@section('title', $page->seo_title)

@section('pageModifier', 'page--index')

{{-- @section('ogImage', url($src_dir.'/img/og-image.jpg')) --}}

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif


@section('description', $page->meta_description)

@section('keywords', $page->meta_keywords)

@section('content')
  @include('pages.index.hero')
  @include('pages.index.quote-1')
  @include('pages.index.speakers')
  @include('modules.commercial')
  @include('pages.index.guests')
  @include('pages.index.quote-2')
  @include('pages.index.expectations')
  @include('pages.index.dt-promo')
  @include('modules.commercial')
  @include('pages.index.tickets')
  @include('pages.index.partners')
  @include('pages.index.questions')
@endsection
@push('scripts')
  <script defer src="{{$src_dir}}/js/index.min.js?v={{$cache_version}}"></script>
@endpush
