@extends('dashboard.layouts.main')
@section('content')

@include('dashboard.patients.partials.datatable')

@push('js')

@endpush
@endsection