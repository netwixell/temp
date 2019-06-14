@extends('web-site.layout.layout')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('pageModifier','page--dream-team')

@section('description', $page->getTranslatedAttribute('meta_description'))

@section('ogImage',!empty($page->image) ? url('/storage/'. $page->image) : url($src_dir.'/img/og-image--dream-team.jpg') )

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.dream-team__hero.dream-team__hero')
  @include('web-site.dream-team__about.dream-team__about')
  @include('web-site.dream-team__theme.dream-team__theme')
  @include('web-site.dream-team__last-year-winner.dream-team__last-year-winner')
  @include('web-site.dream-team__prize.dream-team__prize')
  @if(isset($advertisements) && count($advertisements) > 0)@include('web-site.commercial.commercial', ['advertisement'=>$advertisements->random()])@endif
  @include('web-site.dream-team__how-it-works.dream-team__how-it-works')
  @include('web-site.dream-team__judges.dream-team__judges')
  @if(isset($advertisements) && count($advertisements) > 0)@include('web-site.commercial.commercial', ['advertisement'=>$advertisements->random()])@endif
  @include('web-site.sponsors.sponsors')
  @include('web-site.dream-team__registration.dream-team__registration')
  @include('web-site.photoswipe.photoswipe')
  @include('web-site.dream-team__registred.dream-team__registred')
@endsection

@push('scripts')
  <script defer src="{{$src_dir}}/js/dream-team.min.js?v={{$cache_version}}"></script>
@endpush
