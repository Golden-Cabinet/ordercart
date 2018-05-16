@extends('dashboard.layouts.main')
@section('content')
<h4><i class="fas fa-clipboard-check"></i>  Create A New Order</h4>
<hr />

<form id="newOrder" action="/dashboard/orders/store" method="post" enctype="multipart/form-data">
    <div class="form-group w-100">
    <div id="wizard">
    
        @include('dashboard.orders.partials.step1')

        @include('dashboard.orders.partials.step2')

        @include('dashboard.orders.partials.step3')

        @include('dashboard.orders.partials.step4')

        @include('dashboard.orders.partials.step5')    
            
    </div>
    </div>

{{ csrf_field() }}
</form>

@push('js')
<script>
        $(function ()
        {
            $("#wizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                titleTemplate: "#title#",
                autoFocus: true,
                enableFinishButton: true,                
                enableKeyNavigation: true,

                labels: {
                    finish: 'Submit Order',
                },

                onStepChanging: function (event, currentIndex, newIndex) 
                { 
                    
                    if(currentIndex == '0') 
                    {
                        var patientLookup = $('#patientLookup').val();
                        var formulaLookup = $('#formulaLookup').val(); 
                        var chooseDividend = $('#chooseDividend').val();

                        if(patientLookup == 'nopatient'){
                            $('#errPatientLookup').text('Please select a patient first');
                            $('#patientLookup').css('border','1px solid red');
                            return false;
                        } else if(formulaLookup == 'noformula'){
                            $('#errFormulaLookup').text('Please select a formula first');
                            $('#formulaLookup').css('border','1px solid red');
                            return false;
                        } else if(chooseDividend == 'nodividend'){
                            $('#errDividend').text('Please select a dividend first');
                            $('#chooseDividend').css('border','1px solid red');
                            return false;
                        } else {
                            $('#errPatientLookup').text('');
                            $('#errFormulaLookup').text('');
                            $('#errDividend').text('');
                            $('#patientLookup').css('border','1px solid #ccc');
                            $('#formulaLookup').css('border','1px solid #ccc');
                            $('#chooseDividend').css('border','1px solid #ccc');
                            return true;
                        }                      

                    } 
                        
                        if(currentIndex == '1') 
                    {
                        var dosageLookup = $('#dosageQuantity').val();
                        var timesDay = $('#timesDay').val();
                        var chooseRefills = $('#refillsAllowed').val();
                        if(dosageLookup == 'nodosage'){
                            $('#errDosageLookup').text('Please select a dosage first');
                            return false;
                        } else if(timesDay == 'notimes'){
                            $('#errTimesDay').text('Please select how many times per day');
                            return false;
                        } else if(chooseRefills == 'norefills'){
                            $('#errRefills').text('Please select a how many refills are available');
                            return false;
                        } else {
                            $('#errDosageLookup').text('');
                            $('#errTimesDay').text('');
                            $('#errRefills').text('');
                            $('#dosageQuantity').css('border','1px solid #ccc');
                            $('#timesDay').css('border','1px solid #ccc');
                            $('#refillsAllowed').css('border','1px solid #ccc');
                            return true;
                        }                     

                    } 
                      if(currentIndex == '2') 
                    {
                        var dosageLookup = $('#dosageQuantity').val();
                        var timesDay = $('#times_day').val();
                        var chooseRefills = $('#refills_amount').val();
                        if(dosageLookup == 'nodosage'){
                            $('#errDosageLookup').text('Please select a dosage first');
                            return false;
                        } else if(timesDay == 'notimes'){
                            $('#errTimesDay').text('Please select how many times per day');
                            return false;
                        } else if(chooseRefills == 'norefills'){
                            $('#errRefills').text('Please select a how many refills are available');
                            return false;
                        } else {
                            $('#errDosageLookup').text('');
                            $('#errTimesDay').text('');
                            $('#errRefills').text('');
                            return true;
                        }                     

                    }
              
                },


                onFinished: function (event, currentIndex) {
                    $( "#newOrder" ).submit();
                 },

            });
        });
    </script>
@endpush

@endsection