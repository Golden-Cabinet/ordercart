@extends('dashboard.layouts.main')
@section('content')
<h4>Create A New User</h4>
<hr />
<form action="/dashboard/users/store" method="post" enctype="multipart/form-data" class="form-inline"> 
    <div class="form-group w-100">
        
        
        <div class="col ml-0 pl-0">
                <div class="row">
                    <h5 class="col-xs-12 w-100 pb-2 pt-2">Basic Information</h5>
                    <div class="col-md-2 font-weight-bold">
                        <p>First Name</p>
                    </div>
                    <div class="col-md-7 w-100">
                        <input type="text" class="form-control w-100"  id="first_name" name="first_name" placeholder="">
                    </div>    
                     
                </div>
            
                <div class="row">
                    <div class="col-md-2 font-weight-bold">
                        <p>Last Name</p> 
                    </div>
                    <div class="col-md-7 w-100">    
                        <input type="text" class="form-control w-100" id="last_name" name="last_name" placeholder="">
                    </div>
                </div>
   

            <div class="row">
                <div class="col-md-2 font-weight-bold">
                    <p>Email Address</p>
                </div>
                    <div class="col-md-7 w-100"> 
                <input type="email" class="form-control w-100"  id="email" name="email" placeholder="">
                </div>
            </div>
        </div>

        <h5 class="w-100 pb-2 pt-2">Billing Address</h5>

        <div class="col ml-0 pl-0">

            <div class="row">
                <div class="col-md-12 float-left mr-4" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
                    <div class="col-md-2 float-left font-weight-bold">
                        <p>Street Address</p>
                    </div>
                    <div class="col-md-7 float-left">
                        <input type="text" class="form-control w-100" id="billing_street" name="billing_street" placeholder="">
                    </div>   
                </div>
            </div>
                               
        
            <div class="row">
                <div class="col-md-3 float-left mr-4" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
                    <div class="col-md-2 float-left font-weight-bold">
                            <p>City</p>
                        </div>
                        <div class="col-md-6 float-left">
                            <input type="text" class="form-control" id="billing_city" name="billing_city" placeholder="">
                        </div>                         
                </div>
                
                
                <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0;">
                    <div class="col-md-3 float-left mr-2 font-weight-bold">
                        <p>State</p>
                    </div>
                    <div class="col-md-2 float-left">
                        <select class="form-control" id="billing_state" name="billing_state">
                            <option>Please Select</option>
                            @foreach($states as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select> 
                    </div>
                          
                </div>
                 

                <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0; ">
                    <div class="col-md-2 float-left mr-2 font-weight-bold">
                        <p>Zip</p>
                    </div>
                    <div class="col-md-2 float-left">
                        <input type="number" class="form-control"  id="billing_zip" name="billing_zip" placeholder="">
                    </div>
                            
                </div>
            </div> 

                             
        </div>
            
        <h5 class="w-100 pb-2 pt-2">Use billing as shipping address?</h5>
           
        <div class="col-md-1 col-xs-6 float-left" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
            <div class="form-check form-check-inline ml-3 mr-4">
                    <input class="form-check-input" type="radio" checked name="inlineRadioOptions" id="inlineRadio1" value="Yes">
                    <label class="form-check-label font-weight-bold" for="inlineRadio1">Yes</label>
            </div>
        </div>
        
        <div class="col-md-1 col-xs-6 float-left">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No">
                <label class="form-check-label font-weight-bold" for="inlineRadio2">No</label>
            </div>
        </div>
 

        <div id="shippinginfo" class="w-100" style="display: none;">

            <h5 class="w-100 pb-2 pt-2">Shipping Address</h5>

            <div class="col">
                <div class="row">
                    <div class="col-md-2 font-weight-bold">
                        <p>Street Address</p>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control w-100" id="shipping_address" name="shipping_address" placeholder="">
                    </div>   
                </div>                                        
                
                <div class="row">

                    <div class="col-md-3 float-left mr-4" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
                        <div class="col-md-2 float-left font-weight-bold">
                            <p>City</p>
                        </div>
                        <div class="col-md-6 float-left">
                            <input type="text" class="form-control" id="shipping_city" name="shipping_city" placeholder="">
                        </div> 

                    </div>                        
                    
                    <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0;">

                        <div class="col-md-3 float-left mr-2 font-weight-bold">
                            <p>State</p>
                        </div>
                        <div class="col-md-2 float-left">
                            <select class="form-control" id="shipping_state" name="shipping_state">
                                <option>Please Select</option>
                                @foreach($states as $state)
                                <option value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select> 
                        </div> 

                    </div>                            
    
                    <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0; ">

                        <div class="col-md-2 float-left mr-2 font-weight-bold">
                            <p>Zip</p>
                        </div>
                        <div class="col-md-2 float-left">
                            <input type="number" class="form-control"  id="shipping_zip" name="shipping_zip" placeholder="">
                        </div>

                    </div>

                </div>
            </div>

        </div> 
            
        <h5 class="w-100 pb-2 pt-2">Phone</h5>

        <div class="row">
            <div class="col">
                <div class="col-md-2 float-left font-weight-bold">
                    <p>Area Code</p>
                </div>
                <div class="col-md-2 float-left">
                    <input type="number" max="999" maxlength="3" class="form-control w-100" id="area_code" name="area_code" placeholder="">
                </div>

                <div class="col-md-1 float-left font-weight-bold">
                    <p>Phone</p>
                </div>
                <div class="col-md-4 float-left">
                    <input type="number" max="9999999" maxlength="7"  class="form-control  w-100" id="phone" name="phone" placeholder="">
                </div>
            </div>

                   
        </div>
        
        <h5 class="w-100 pb-2 pt-2">Additional Settings</h5>

        <div class="col">
            <div class="row">
                <div class="col-md-12 float-left" style="padding-left: 0; margin-left: 0;">
                    <div class="col-md-3 float-left mr-2 font-weight-bold">
                        <p>State of Licensure or School</p>
                    </div>
                    <div class="col-md-2 float-left">
                        <select class="form-control" id="license_state" name="license_state">
                            <option>Please Select</option>
                            @foreach($states as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select> 
                    </div>                            
                </div>

            </div>
            
            <div class="row">

                <div class="col-md-12 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0;">
                    <div class="col-md-3 float-left mr-2 font-weight-bold">
                        <p>User Role</p>
                    </div>
                    <div class="col-md-2 float-left">
                        <select class="form-control" id="user_role" name="user_role">
                            <option>Please Select</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select> 
                    </div>

                </div>
            </div>

            <div class="row">

                    <div class="col-md-12 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0;">
                            <div class="col-md-3 float-left mr-2 font-weight-bold">
                                <p>User Status</p>
                            </div>
                            <div class="col-md-2 float-left">
                                <select class="form-control" id="user_status" name="user_status">
                                    <option>Please Select</option>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select> 
                            </div>
        
                        </div>

            </div>

            <div class="row">

                <div class="col-md-3 font-weight-bold">
                    <p>Create Password</p>
                </div>
                <div class="col-sm-7 w-100">
                    <input type="password" class="form-control w-100" id="updated_password" name="updated_password" placeholder="">
                </div>  
                     
            </div>

            <div class="row">
                <div class="col-md-3 font-weight-bold">
                    <p>Confirm New Password</p>
                </div>
                <div class="col-sm-7 w-100">
                    <input type="password" class="form-control w-100" id="updated_password_confirmation" name="updated_password_confirmation" placeholder="">
                </div>
            </div>

            <div class="row">
                <div class="alert alert-info text-center" style="width: 47%; margin: auto" role="alert">                

                <div style="margin: 0 auto 0 auto; padding: 0;">
                    <p class="font-weight-bold">Notify User Via Email Of Password Change?</p>
                    <div class="col form-check form-check-inline float-left mb-2">
                        <input class="form-check-input" type="radio" name="passwordUpdateNotify" id="inlineNotify1" value="Yes">
                        <label class="form-check-label font-weight-bold" for="inlineNotify1">Yes</label>
                    </div>
                    <div class="col form-check form-check-inline float-left">
                        <input class="form-check-input" type="radio" checked name="passwordUpdateNotify" id="inlineNotify2" value="No">
                        <label class="form-check-label font-weight-bold" for="inlineNotify2">No</label>
                    </div>
                </div>                     

                </div>                
            </div>
        </div>        
    
    </div>  
    <!-- end -->
    {{ csrf_field() }}
    <div class="col">
            <button type="submit" class="btn btn-primary">Save This New User</button>
    </div>
    
</form>

@push('js')
<script>

    $('#inlineRadio2').on('click',function(){
        $('#shippinginfo').show('slow');
    });

    $('#inlineRadio1').on('click',function(){       
        $('#shippinginfo').hide('slow');
    });



    
</script>
@endpush
@endsection