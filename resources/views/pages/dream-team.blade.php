@extends('layouts.main')

@section('title', 'Dream Team — Molfar Beauty Forum')

@section('description', 'Профессиональный командный конкурс бьюти-индустрии. Командные состязания с главным призом 100 000 гривен')

@section('ogImage', url($src_dir.'/img/og-image--dream-team.jpg'))

@section('pageModifier', 'page--dream-team')

@section('keywords', '')

@section('content')
  @include('pages.dream-team.hero')
  @include('pages.dream-team.about')
  @include('pages.dream-team.theme')
  @include('pages.dream-team.last-year-winner')
  @include('pages.dream-team.prize')
  @if(isset($advertisements) && count($advertisements) > 0)@include('modules.commercial', ['advertisement'=>$advertisements->random()])@endif
  @include('pages.dream-team.how-it-works')
  @include('pages.dream-team.judges')
  @if(isset($advertisements) && count($advertisements) > 0)@include('modules.commercial', ['advertisement'=>$advertisements->random()])@endif
  @include('pages.dream-team.sponsors')
  @include('pages.dream-team.registration')
  @include('pages.dream-team.registred')
@endsection

@push('scripts')
  <script defer src="{{$src_dir}}/js/dream-team.min.js?v={{$cache_version}}"></script>
@endpush
