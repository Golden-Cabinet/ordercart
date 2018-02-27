@extends('dashboard.layouts.main')
@section('content')
<h4>Create A New User</h4>
<hr />
<form action="/dashboard/users/store" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <h5 class="w-100 pb-2 pt-2">Basic Information</h5>
        
        <div class="col-md-6 mb-2 pl-0 pr-0">
            <label for="first_name" class="col-sm-3 float-left text-left col-form-label">First Name</label>
            <input type="text" class="form-control col-sm-9" id="first_name" name="first_name" placeholder="">
        </div>


        <div class="col-md-6 mb-2 pl-0">
            <label for="last_name" class="col-sm-3 float-left text-right col-form-label">Last Name</label>
            <input type="text" class="form-control col-sm-9" id="last_name" name="last_name" placeholder="">
        </div>

        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="email" name="email" placeholder="">
        </div>

        <h5 class="w-100 pb-2 pt-2">Billing Address</h5>

        <label for="billing_street" class="col-sm-2 col-form-label">Street</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="billing_street" name="billing_street" placeholder="">
        </div>

        <label for="billing_city" class="col-sm-2 col-form-label">City</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="billing_city" name="billing_city" placeholder="">
        </div>

        <label for="billing_state" class="col-sm-2 col-form-label">State</label>
        <div class="col-sm-10">
            <select class="form-control" id="billing_state" name="billing_state">
                <option>Please Select</option>
                @foreach($states as $state)
                <option value="{{$state->id}}">{{$state->name}}</option>
                @endforeach
            </select>   
        </div>

        <label for="billing_zip" class="col-sm-2 col-form-label">Zip Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="billing_zip" name="billing_zip" placeholder="">
        </div>

        <h5 class="w-100 pb-2 pt-2">Use billing as shipping address?</h5>

        <div class="form-check form-check-inline ml-3 mr-4">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Yes">
                <label class="form-check-label" for="inlineRadio1">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No">
            <label class="form-check-label" for="inlineRadio2">No</label>
        </div>

        <div style="display: none;">

                <h5 class="w-100 pb-2 pt-2">Shipping Address</h5>
                
                <label for="shipping_address" class="col-sm-2 col-form-label">Street</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="shipping_address" name="shipping_address" placeholder="">
                </div>
        
                <label for="shipping_city" class="col-sm-2 col-form-label">City</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="shipping_city" name="shipping_city" placeholder="">
                </div>
        
                <label for="shipping_state" class="col-sm-2 col-form-label">State</label>
                <div class="col-sm-10">
                    <select class="form-control" id="shipping_state" name="shipping_state">
                        <option>Please Select</option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>  
                </div>
        
                <label for="shipping_zip" class="col-sm-2 col-form-label">Zip Code</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="shipping_zip" name="shipping_zip" placeholder="">
                </div>

        </div>   

        <h5 class="w-100 pb-2 pt-2">Phone</h5>

        <label for="area_code" class="col-sm-2 col-form-label">Area Code</label>
        <div class="col-sm-10">
          <input type="number" max="999" maxlength="3" class="form-control" id="area_code" name="area_code" placeholder="">
        </div>

        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
        <div class="col-sm-10">
          <input type="number" max="9999999" maxlength="7"  class="form-control" id="billing_zip" name="billing_zip" placeholder="">
        </div>

        <h5 class="w-100 pb-2 pt-2">Additional Settings</h5>

    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Save</button>
</form>

@push('js')

@endpush
@endsection