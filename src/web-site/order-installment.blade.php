@extends('web-site.layout.layout')

@section('title', 'Приобретение билета — Molfar Beauty Forum')

@section('pageModifier', 'page--installment')

@section('ogImage', '')

@section('description', 'Приобретение билета на Molfar Beauty Forum ‘19')

@section('keywords', '')

@section('content')

  @include('web-site.order-installment.order-installment')

@endsection

@push('scripts')
    <script defer src="{{$src_dir}}/js/order.min.js?v={{$cache_version}}"></script>
@endpush
