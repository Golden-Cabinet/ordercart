<h2>Shipping &amp; Billing</h2>
<section>
    <h3 style="font-size: 1.8rem;"><i class="fas fa-shipping-fast"></i> Shipping &amp; Pickup</h3>
    <hr />

    <div class="custom-control custom-radio custom-control-inline mb-3">
            <input type="radio" id="ship" name="customRadioInline1" class="shiporpickup ship custom-control-input" checked="checked">
            <label class="custom-control-label" for="ship">Ship</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="instorepickup" name="customRadioInline1" class="shiporpickup instorepickup custom-control-input">
            <label class="custom-control-label" for="instorepickup">In Store pickup</label>
          </div>

   
        <h3 style="font-size: 1.8rem;"><i class="far fa-compass"></i> Shipping Options</h3>
        <hr />


        <div id="pickup" class='form-group mt-3' style="display:none;clear:both">
            <br>
            <h3>Pick Up Options</h3>
            <hr>
            <div class="form-group">
                <label for="pickUpOptions" class="control-label">Pick Up Options</label>        <div class="controls">
                    <select name="howPickup" id="howPickup" class="form-control">
                        <option value="patientPickup">Patient will pick up</option>
                        <option value="personalPickup">I will pick up</option>
                    </select>
                </div>
            </div>
        </div>

    <div class="form-group mt-3 shippingoptions">
            <label for="pickUpOptions">Shipping Options</label>    
            <div class="controls">
            <select name="howShip" id="howShip" class="shipSelect form-control">
                <option value="shipUserMailing">Ship formula to my mailing address</option>
                <option value="shipUserOther">Ship formula to me at another address</option>
                <option value="shipPatient">Ship formula to the Patients mailing address</option>
                <option value="shipPatientOther">Ship formula to the patient at another address</option>
            </select>
        </div>
    </div>


    <div id="shippinginfo" class="w-100 mt-3" style="display: none;">

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

        <h3 style="font-size: 1.8rem; mt-3"><i class="far fa-money-bill-alt"></i> Billing </h3>
        <hr />
<div class="form-group">
    <label for="billing" class="control-label">Billing Options</label>    <div class="controls">
        <select name="billing" id="billing" class="form-control">
            <option value="chargeUserCard">Charge my card on file</option>
            <option value="callInCard">I will call with my credit card information</option>
            <option value="pickUpFormula">I will pay when I pick up the formula</option>
            <option value="patientPay">Patient will pay</option>
        </select>
    </div>
</div>
</section>

@push('js')
<script>


$(document).on('change','.shipSelect',function(){
    var shipval = $('#howShip').val();

        if(shipval == 'shipUserOther')
        {
            $('#shippinginfo').slideDown();
        } else if(shipval == 'shipPatientOther') {
            $('#shippinginfo').slideDown();
        } else {
            $('#shippinginfo').slideUp();            
        }
});

$(document).on('click keydown','.shiporpickup',function(){
        var selected = $(this);
        if(selected.hasClass('instorepickup'))
        {
            $('#pickup').slideDown();
            $('.shippingoptions').slideUp();
            $('#shippinginfo').slideUp();
            $("#howShip option:eq(0)").prop("selected", true);
        } else {
            $('#pickup').slideUp();
            $('.shippingoptions').slideDown();
            $("#howShip option:eq(0)").prop("selected", true);
        }
});

    


</script>    
@endpush