@extends('layouts.main')

@section('title', 'Политика конфиденциальности — Molfar Beauty Forum')

@section('description', 'Главная бьюти-конференция в Украине')

@section('ogImage', url($src_dir.'/img/og-image.jpg'))

@section('pageModifier', 'page--privacy')

@section('keywords', '')

@section('content')
  @include('pages.privacy.privacy')
@endsection

@push('scripts')
  {{-- <script defer src="{{$src_dir}}/js/privacy.min.js?v={{$cache_version}}"></script> --}}
@endpush
