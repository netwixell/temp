@extends('web-site.layout.layout')

@section('title', strtr($page->getTranslatedAttribute('seo_title'), ['{$teamName}'=>$team->name]) )

@section('description',  strtr($page->getTranslatedAttribute('meta_description'), ['{$teamName}'=>$team->name]))

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif

@section('pageModifier', 'page--vote-results')

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')
  @include('web-site.vote-results.vote-results')
@endsection

@push('scripts')
   {{-- <script defer src="{{$src_dir}}/js/vote-results.min.js?v={{$cache_version}}"></script> --}}
@endpush
