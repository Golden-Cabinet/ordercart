@extends('dashboard.layouts.main')
@section('content')
<h4><i class="fas fa-clipboard-check"></i>  Create A New Order</h4>
<hr />
<form action="/dashboard/orders/store" method="post" enctype="multipart/form-data">
    <div class="form-group">

    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Save</button>
</form>

@push('js')

@endpush
@endsection