@extends('dashboard.layouts.main')
@section('content')
<h4><i class="far fa-plus-square"></i> Create A New Formula</h4>
<hr />


<div class="col-md-6 float-left">
    <input id="ingredientsAuto" class="form-control" placeholder="Search Ingredients Table">
</div>
<div class="col-md-6 float-right">
    <div class="card">
    <h5 class="card-header bg-info text-white"><i class="fas fa-flask"></i>  Formula Overview</h5>
    <div class="card-body">
        <h5 class="card-title">Select from the ingredients table, then create a formula name below.</h5>
        <hr />
        <form method="POST" id="newFormula" enctype="application/x-www-form-urlencoded" action="/dashboard/formulas/store">
        <input type="text" class="form-control" id="formulaName" name="formula_name" placeholder="Enter Your New Formula Name">
            <div class="table-responsive" style="width: 100%;">
                <table class="ca-dt-bootstrap table" id="ingredientslist">
                    <tr>
                        <th>Ingredient</th>
                        <th>Grams</th>
                        <th>Subtotal</th>
                        <th>&nbsp;</th>
                    </tr>                
                    <tbody></tbody>
                </table>
            </div>            
            {{ csrf_field() }}
            <hr />
            <div class="col-md-8 float-left text-bold" style="font-size: 1.2rem;"><p>Grand Total: $<span id="grandTotal">0.00</span></p> </div> 
            
            <div class="col-md-4 float-left"> 
                <button href="#" id="saveFormula" type="submit" style="width: 100%; display: none" class="btn btn-primary btn-sm text-center"><i class="fas fa-check-circle"></i> Create</button>
                </div>
        </form>
        </div>
    </div>
    </div>
</div>

@push('headscripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush    

    @push('js')
    <script>        
           /**~~~ AUTOCOMPLETE SEARCH - STEP 1 OF CREATING FORMULAS ~~~**/
            var dataSrc = [
                @foreach($formulas as $formula)
                    "{{ $formula['name'] }} - {{ $formula['brand'] }}",
                @endforeach
            ];

            $("#ingredientsAuto").autocomplete({
                source: dataSrc,
                minLength: 3,
                select: function( event , ui ) {
                    var selectedProduct = ui.item.label;
                    var prodKey = selectedProduct.split(" - ");
                    var product = prodKey[0];
                    var brand = prodKey[1];

                    //do an ajax get call to return this one product/brand combo for the formula overview
                    $.ajax({
                        url : '/dashboard/formulas/search/product/'+ product +'/brand/'+ brand,
                        type: 'GET',
                        success : function(data){
                            
                        }
                    })                    
                }
            });            
    
        /**~~~ FORMULA OVERVIEW MANAGEMENT - STEP 2 OF CREATING FORMULAS ~~~**/
        
        /** FORMULA OVERVIEW - ADD INGREDIENT TABLE ROW **/
        
        
        /** FORMULA OVERVIEW - REMOVE ADDED INGREDIENT **/
            $(document).on('click','.removeIngredient', function() {
                $('div.dataTables_filter input').val('');
                $('div.dataTables_filter input').focus();
                var remove = $(this);
                var subTotal = $(this).attr('data-subtotal');
                var rprid = $(this).attr('data-ingredientid');
                var tr = $(this).closest('tr');
                var currentTotal = $('#grandTotal').text();

                var subtractedTotals = parseFloat(currentTotal) - parseFloat(subTotal);
                var finalSubtracted = parseFloat(subtractedTotals).toFixed(2);

                $('.passformula_' + rprid).prop('disabled',true);
                $('#'+rprid).val('');
                $('#subtotal_'+rprid).html('');
                $('#row_'+rprid).remove();  
                
                if(subtractedTotals < 0.01 )
                {
                    var newTotal = $('#grandTotal').html('0.00');
                    $('#saveFormula').hide();
                    $('#formulaName').val('');
                    $('#formulaName').prop('disabled', false);
                } else {
                    var newTotal = $('#grandTotal').html(finalSubtracted);
                }
                var grandTotal = parseFloat(newTotal).toFixed(2);
                return false;
            });        
            
        </script>       
    @endpush
   
@endsection