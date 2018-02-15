@extends('dashboard.layouts.main')
@section('content')

<form action=""  method="post" enctype="multipart/form-data">
<div id="wizard">
    
        
        @include('dashboard.registration.partials.step1')

        @include('dashboard.registration.partials.step2')      

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
                transitionEffect: "slideLeft"
            });
        });
    </script>
@endpush
@endsection