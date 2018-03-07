
@if (Session::has('success'))
<div id="flashAlert" style="display:none; text-align: center; font-size: 2rem; width: 100%; height: 100px;">
<div class="alert alert-success">

	<button type="button" class="close" data-dismiss="alert">×</button>	

        <strong>{{ Session::get('success') }}</strong>

</div>
</div>
@push('js')
<script>
        $( "#flashAlert" ).slideDown( 1100 ).delay( 1800 ).slideUp( 800 );
</script>    
@endpush

@endif


@if (Session::has('error'))
<div id="flashAlert" style="display:none; text-align: center; font-size: 2rem; width: 100%; height: 100px;">
<div class="alert alert-danger">

	<button type="button" class="close" data-dismiss="alert">×</button>	

        <strong>{{ Session::get('error') }}</strong>

</div>
</div>
@push('js')
<script>
        $( "#flashAlert" ).slideDown( 300 ).delay( 1600 ).slideUp( 500 );
</script>    
@endpush

@endif


@if (Session::has('warning'))
<div id="flashAlert" style="display:none; text-align: center; font-size: 2rem; width: 100%; height: 100px;">
<div class="alert alert-warning">

	<button type="button" class="close" data-dismiss="alert">×</button>	

	<strong>{{ Session::get('warning') }}</strong>

</div>
</div>
@push('js')
<script>
        $( "#flashAlert" ).slideDown( 300 ).delay( 1600 ).slideUp( 500 );
</script>    
@endpush

@endif


@if (Session::has('info'))
<div id="flashAlert" style="display:none; text-align: center; font-size: 2rem; width: 100%; height: 100px;">
<div class="alert alert-info">

	<button type="button" class="close" data-dismiss="alert">×</button>	

	<strong>{{ Session::get('info') }}</strong>

</div>
</div>
@push('js')
<script>
        $( "#flashAlert" ).slideDown( 300 ).delay( 1600 ).slideUp( 500 );
</script>    
@endpush

@endif

