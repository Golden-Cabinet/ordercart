@extends('dashboard.layouts.main')
@section('content')
<h4><i class="fas fa-list"></i> Create A New Category</h4>
<hr />
<form action="/dashboard/categories/store" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <label for="brandName" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="brandName" name="name" placeholder="" value="">
        </div>
      </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Save</button>
</form>

@push('js')

@endpush
@endsection