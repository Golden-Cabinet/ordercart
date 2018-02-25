@extends('dashboard.layouts.main')
@section('content')

<h4>Editing: {{ $brand->name }}</h4>
<hr />
<form action="/dashboard/brands/update" method="post" enctype="multipart/form-data">

      <div class="form-group row">
        <label for="brandName" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="brandName" name="name" placeholder="" value="{{ $brand->name }}">
        </div>
      </div>
      <input type="hidden" name="bid" value="{{ $brand->id }}">
    {{ csrf_field() }}
    <button type="submit" class="btn btn-success">Update This Brand</button>
</form>

@push('js')

@endpush
@endsection