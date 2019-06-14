@extends('web-site.layout.layout')

@section('title', $page->getTranslatedAttribute('seo_title') )

@section('pageModifier', 'page--index')

{{-- @section('ogImage', url($src_dir.'/img/og-image.jpg')) --}}

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif


@section('description', $page->getTranslatedAttribute('meta_description') )

@section('keywords', $page->getTranslatedAttribute('meta_keywords') )

@section('content')
  @include('web-site.index__hero.index__hero')
  @include('web-site.quote-1.quote-1')
  @include('web-site.speakers.speakers')

  @if(isset($advertisements) && count($advertisements) > 0)@include('web-site.commercial.commercial', ['advertisement'=>$advertisements->random()])@endif

  @include('web-site.index__guests.index__guests')
  @include('web-site.quote-2.quote-2')
  @include('web-site.index__expectations.index__expectations')
  @include('web-site.index__dt-promo.index__dt-promo')

  @if(isset($advertisements) && count($advertisements) > 0)@include('web-site.commercial.commercial', ['advertisement'=>$advertisements->random()])@endif

  @if($ticket_selling)@include('web-site.tickets.tickets')@endif
  @include('web-site.partners.partners')
  @include('web-site.questions.questions')
@endsection
@push('scripts')
  <script defer src="{{$src_dir}}/js/index.min.js?v={{$cache_version}}"></script>
@endpush
