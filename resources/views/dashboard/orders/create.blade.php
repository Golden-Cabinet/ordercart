@extends('dashboard.layouts.main')
@section('content')
<h4><i class="fas fa-clipboard-check"></i>  Create A New Order</h4>
<hr />

<form action="/dashboard/orders/store" method="post" enctype="multipart/form-data">
<div id="wizard">
    
        @include('dashboard.orders.partials.step1')

        @include('dashboard.orders.partials.step2')

        @include('dashboard.orders.partials.step3')

        @include('dashboard.orders.partials.step4')

        @include('dashboard.orders.partials.step5')    
            
</div>

{{ csrf_field() }}
</form>

@push('js')
<script>
        $(function ()
        {
            $("#wizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                titleTemplate: "#title#" 
            });
        });
    </script>
@endpush
@endsection