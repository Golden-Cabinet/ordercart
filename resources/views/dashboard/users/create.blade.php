@extends('dashboard.layouts.main')
@section('content')
<h4>Create A New User</h4>
<hr />
<form action="/dashboard/users/store" method="post" enctype="multipart/form-data">
    <div class="form-group">

    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Save</button>
</form>

@push('js')

@endpush
@endsection