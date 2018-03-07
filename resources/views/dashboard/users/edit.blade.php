@extends('dashboard.layouts.main')
@section('content')
<h4>Editing User:</h4>
<hr />
<form action="/dashboard/users/update/{{ $result->id }}" method="post" enctype="multipart/form-data" class="form-inline"> 
    <div class="form-group w-100">        
        
        <div class="col ml-0 pl-0">
                <div class="row">
                    <h5 class="col-xs-12 w-100 pb-2 pt-2">Basic Information</h5>
                    <div class="col-md-2 font-weight-bold">
                        <p>First Name</p>
                    </div>
                    <div class="col-md-7 w-100">
                        <input type="text" class="form-control w-100"  id="first_name" name="first_name" value="{{ $first_name }}" placeholder="">
                    </div>    
                     
                </div>
            
                <div class="row">
                    <div class="col-md-2 font-weight-bold">
                        <p>Last Name</p> 
                    </div>
                    <div class="col-md-7 w-100">    
                        <input type="text" class="form-control w-100" id="last_name" name="last_name" value="{{ $last_name }}" placeholder="">
                    </div>
                </div>
   

            <div class="row">
                <div class="col-md-2 font-weight-bold">
                    <p>Email Address</p>
                </div>
                    <div class="col-md-7 w-100"> 
                <input type="email" class="form-control w-100"  id="email" name="email" value="{{ $result->email }}" placeholder="">
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
                        <input type="text" class="form-control w-100" id="billing_street" value="{{ $billing->street }}" name="billing_street"  placeholder="">
                    </div>   
                </div>
            </div>
                               
        
            <div class="row">
                <div class="col-md-3 float-left mr-4" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
                    <div class="col-md-2 float-left font-weight-bold">
                            <p>City</p>
                        </div>
                        <div class="col-md-6 float-left">
                            <input type="text" class="form-control" value="{{ $billing->city }}" id="billing_city" name="billing_city" placeholder="">
                        </div>                         
                </div>
                
                
                <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0;">
                    <div class="col-md-3 float-left mr-2 font-weight-bold">
                        <p>State</p>
                    </div>
                    <div class="col-md-2 float-left">
                        <select class="form-control" id="billing_state" name="billing_state">
                            @foreach($states as $state)
                            @if($billing->address_states_id == $state->id)
                            <option value="{{$state->id}}" selected>{{$state->name}}</option>
                            @else
                            <option value="{{$state->id}}">{{$state->name}}</option>
                            @endif                            
                            @endforeach
                        </select> 
                    </div>
                          
                </div>
                 

                <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0; ">
                    <div class="col-md-2 float-left mr-2 font-weight-bold">
                        <p>Zip</p>
                    </div>
                    <div class="col-md-2 float-left">
                        <input type="number" class="form-control" value="{{ $billing->zip }}"  id="billing_zip" name="billing_zip" placeholder="">
                    </div>
                            
                </div>
            </div> 

                             
        </div>
            
        <h5 class="w-100 pb-2 pt-2">Use billing as shipping address?</h5>
           
        <div class="col-md-1 col-xs-6 float-left" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
            <div class="form-check form-check-inline ml-3 mr-4">
                    @if($billing->street == $shipping->street)
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" checked value="Yes">
                    @else
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Yes">
                    @endif
                    <label class="form-check-label font-weight-bold" for="inlineRadio1">Yes</label>
            </div>
        </div>
        
        <div class="col-md-1 col-xs-6 float-left">
            <div class="form-check form-check-inline">                
                @if($billing->street != $shipping->street)
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" checked value="No">
                @else
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No">               
                @endif
                <label class="form-check-label font-weight-bold" for="inlineRadio2">No</label>
            </div>
        </div>
 
        @if($billing->street != $shipping->street)
        <div id="shippinginfo" class="w-100" style="display: block;">
        @else
        <div id="shippinginfo" class="w-100" style="display: none;">
        @endif

            <h5 class="w-100 pb-2 pt-2">Shipping Address</h5>

            <div class="col">
                <div class="row">
                    <div class="col-md-2 font-weight-bold">
                        <p>Street Address</p>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control w-100" id="shipping_address" name="shipping_address" value="{{ $shipping->street }}" placeholder="">
                    </div>   
                </div>                                        
                
                <div class="row">

                    <div class="col-md-3 float-left mr-4" style="padding-left: 0; padding-right: 0; margin-left: 0; margin-right: 0;">
                        <div class="col-md-2 float-left font-weight-bold">
                            <p>City</p>
                        </div>
                        <div class="col-md-6 float-left">
                            <input type="text" class="form-control" id="shipping_city" value="{{ $shipping->city }}" name="shipping_city" placeholder="">
                        </div> 

                    </div>                        
                    
                    <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0;">

                        <div class="col-md-3 float-left mr-2 font-weight-bold">
                            <p>State</p>
                        </div>
                        <div class="col-md-2 float-left">
                            <select class="form-control" id="shipping_state" name="shipping_state">
                                @foreach($states as $state)
                                @if( $shipping->address_states_id == $state->id )
                                <option value="{{$state->id}}" selected>{{$state->name}}</option>
                                @else
                                <option value="{{$state->id}}">{{$state->name}}</option>
                                @endif                                
                                @endforeach
                            </select> 
                        </div> 

                    </div>                            
    
                    <div class="col-md-2 float-left mr-4 pr-2" style="padding-left: 0; margin-left: 0; ">

                        <div class="col-md-2 float-left mr-2 font-weight-bold">
                            <p>Zip</p>
                        </div>
                        <div class="col-md-2 float-left">
                            <input type="number" class="form-control"  id="shipping_zip" value="{{ $shipping->zip }}" name="shipping_zip" value="" placeholder="">
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
                    <input type="number" max="999" maxlength="3" class="form-control w-100" id="area_code" name="area_code" value="{{ $result->phonePre }}" placeholder="">
                </div>

                <div class="col-md-1 float-left font-weight-bold">
                    <p>Phone</p>
                </div>
                <div class="col-md-4 float-left">
                    <input type="number" max="9999999" maxlength="7"  class="form-control  w-100" id="phone" name="phone" value="{{ $result->phonePost }}" placeholder="">
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
                            @foreach($states as $state)
                            @if($result->license_state == $state->id)
                            <option value="{{$state->id}}" selected>{{$state->name}}</option>
                            @else 
                            <option value="{{$state->id}}">{{$state->name}}</option>
                            @endif                            
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
                            @foreach($roles as $role)
                            @if($result->user_roles_id == $role->id)
                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                            @else 
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endif
                            
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
                                    @if($result->is_approved == 0)
                                    <option value="0" selected>Inactive</option>
                                    @else
                                    <option value="1" selected>Active</option>
                                    @endif
                                </select> 
                            </div>
        
                        </div>

            </div>

            <div class="row">

                <div class="col-md-3 font-weight-bold">
                    <p>Update Password</p>
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
                        <input class="form-check-input" type="radio" name="passwordUpdateNotify" checked id="inlineNotify2" value="No">
                        <label class="form-check-label font-weight-bold" for="inlineNotify2">No</label>
                    </div>
                </div>                     

                </div>                
            </div>
        </div>        
    
    </div>  
    <!-- end -->
    <input type="hidden" name="sid" value="{{ $shipping->id }}">
    <input type="hidden" name="bid" value="{{ $billing->id }}">
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