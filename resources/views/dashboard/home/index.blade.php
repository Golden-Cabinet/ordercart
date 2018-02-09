@extends('dashboard.layouts.main')
@section('content')
<div class="row mb-4" style="min-height: 400px; max-height: 500px; height: inherit !important">
    
    <div class="col-12 h-150">
        @include('dashboard.home.partials.orderstable')
    </div>    
    
</div>

<div class="row"  style="min-height: 800px; height: inherit !important">

    <div class="col-md-6 h-400">
        @include('dashboard.home.partials.patientstable')
    </div>
    
    <div class="col-md-6 h-400">
        @include('dashboard.home.partials.formulastable')
    </div>

</div>  


@push('js')

@endpush
@endsection