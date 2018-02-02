@extends('dashboard.layouts.main')
@section('content')

@include('dashboard.home.partials.orderstable')

@include('dashboard.home.partials.patientstable')

@include('dashboard.home.partials.formulastable')

@push('js')

@endpush
@endsection