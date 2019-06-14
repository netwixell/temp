@extends('layouts.main-rules')

@section('title', 'Правила конкурса Dream Team — Molfar Beauty Forum')

@section('description', 'Регламент и правила конкурса Dream Team')

@section('ogImage', url($src_dir.'/img/og-image--dream-team.jpg'))

@section('pageModifier', 'page--rules')

@section('keywords', '')

@section('content')
  @include('pages.rules.rules')
@endsection

@push('scripts')
   <script defer src="{{$src_dir}}/js/rules.min.js"></script>
@endpush
