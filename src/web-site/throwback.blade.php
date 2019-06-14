@extends('web-site.layout.layout')

@section('title', $page->getTranslatedAttribute('seo_title'))

@section('pageModifier', 'page--throwback')

@if(!empty($page->image))

  @section('ogImage', url('/storage/'. $page->image) )

@endif

@section('description', $page->getTranslatedAttribute('meta_description'))

@section('keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

  @include('web-site.throwback__hero.throwback__hero')
  @include('web-site.throwback__blocks.throwback__blocks')

@endsection
