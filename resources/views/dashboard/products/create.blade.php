@extends('dashboard.layouts.main')
@section('content')
<h4>Create A New Product</h4>
<hr />
<form action="/dashboard/products/store" method="post" enctype="multipart/form-data">
    <div class="form-group row">

        <label for="productPinyin" class="col-sm-2 col-form-label">Pinyin</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="productPinyin" name="pinyin" placeholder="">
        </div>

        <label for="productLatinName" class="col-sm-2 col-form-label">Latin Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="productLatinName" name="latin_name" placeholder="">
        </div>

        <label for="productCommonName" class="col-sm-2 col-form-label">Common Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="productCommonName" name="common_name" placeholder="">
        </div>

        <label for="productBrand" class="col-sm-2 col-form-label">Brand</label>
        <div class="col-sm-10">
            <select class="form-control" name="brands_id">
                <option>Please Select</option>
                @foreach($brands as $brand)
                <option value="$brand->id">{{$brand->name}}</option>
                @endforeach
            </select>
        </div>

        <label for="productConcentration" class="col-sm-2 col-form-label">Concentration</label>
        <div class="col-sm-10">
          <input type="number" step="any" min="0" class="form-control" id="productConcentration" name="concentration" placeholder="">
        </div>

        <label for="productCostGram" class="col-sm-2 col-form-label">Cost Per Gram</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="productCostGram" name="costpergram" placeholder="">
        </div>


      </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Save</button>
</form>

@push('js')

@endpush
@endsection