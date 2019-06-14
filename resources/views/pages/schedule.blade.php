@extends('layouts.main')

@section('title', 'Программа Форума — Molfar Beauty Forum')

@section('description', 'Программа Molfar Beauty Forum')

@section('ogImage', url($src_dir.'/img/og-image.jpg'))

@section('pageModifier', 'page--schedule')

@section('keywords', '')

@section('content')
  @include('pages.schedule.schedule')
  @include('pages.schedule.questions')
@endsection

@push('scripts')
  <script defer src="{{$src_dir}}/js/schedule.min.js?v={{$cache_version}}"></script>
@endpush
