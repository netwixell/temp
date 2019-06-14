@extends('layouts.main')

@section('title', 'Molfar Beauty Forum 2018')

@section('pageModifier', 'page--throwback')

@section('ogImage', url($src_dir.'/img/og-image.jpg'))

@section('description', 'Molfar Beauty Forum — как это было в 2018 году')

@section('keywords', '')

@section('content')

  @include('pages.throwback.hero')
  @include('pages.throwback.blocks')

@endsection
