@extends('dashboard.layouts.main')
@section('content')

<div class="row mb-4" style="min-height: 400px; max-height: 600px; height: inherit !important">
    
    <div class="col-12 h-150 no-gutters">
        @include('dashboard.patients.partials.datatable')
    </div>    
    
</div>


@push('js')

@endpush
@endsection