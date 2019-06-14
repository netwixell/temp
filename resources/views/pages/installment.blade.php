@extends('layouts.main')

@section('title', 'Приобретение билета — Molfar Beauty Forum')

@section('pageModifier', 'page--installment')

@section('ogImage', '')

@section('description', 'Приобретение билета на Molfar Beauty Forum ‘19')

@section('keywords', '')

@section('content')

  @include('modules.installment')

@endsection

@push('scripts')
    <script defer src="{{$src_dir}}/js/order.min.js?v={{$cache_version}}"></script>
@endpush
