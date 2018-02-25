@extends('dashboard.layouts.main')
@section('content')
<h4>Editing: {{ $category->name }}</h4>
<hr />
<form action="/dashboard/categories/update" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <label for="categoryName" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="categoryName" name="name" placeholder="" value="{{ $category->name }}">
        </div>
      </div>
      <input type="hidden" name="cid" value="{{ $category->id }}">
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@push('js')

@endpush
@endsection