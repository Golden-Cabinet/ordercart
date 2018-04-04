@extends('dashboard.layouts.main')
@section('content')
<h4><i class="far fa-plus-square"></i> Create A New Formula</h4>
<hr />



    <div class="card">
    <h5 class="card-header bg-info text-white"><i class="fas fa-flask"></i>  Formula Overview</h5>
    <div class="card-body">
        <h5>Step 1: Search For Ingredients</h5>
            <input id="ingredientsAuto" class="form-control mb-4" tabindex="0" placeholder="Start Your Search Here">
        
        <div id="stepTwo" style="display: none;">
        <form method="POST" id="newFormula" enctype="application/x-www-form-urlencoded" action="/dashboard/formulas/store">        
            <div class="table-responsive mb-4" style="width: 100%;">
                    <h5>Step 2: Modify Your Selected Ingredients</h5>
                <table class="ca-dt-bootstrap table" id="ingredientslist">
                    <tr>
                        <th style="width: 40%">Pinyin</th>
                        <th style="width: 25%">Grams</th>
                        <th style="width: 20%">$/Gram</th>
                        <th style="10%">Subtotal</th>
                        <th style="width: 5%">&nbsp;</th>
                    </tr>                
                    <tbody id="ingRows"></tbody>
                </table>
                <hr />
                <a href="#" id="calculateFormula" style="display:none;" class="btn btn-info btn-lg text-center float-right"><i class="fas fa-calculator"></i> Finalize Formula</a>
            </div>            
            {{ csrf_field() }}
            <hr />
        </div>
            <div class="finalizeFormula" style="display: none;">
                    <h5>Step 3: Create Your Formula Name and Save It!</h5>
                <input type="text" style="background: #ffffe0" class="form-control mb-4" id="formulaName" name="formula_name" placeholder="Enter Your New Formula Name">
                <div class="col-md-6 float-left text-bold" style="font-size: 1.2rem;"><p>Grand Total: $<span id="grandTotal">0.00</span></p> </div> 
                    <button href="#" id="saveFormula" type="submit" class="btn btn-success btn-lg text-center float-right"><i class="fas fa-check"></i> Save Formula</button>
               
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="dupeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This ingredient has already been added.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

            $("#ingredientsAuto").focus();
            $('#saveFormula').prop('disabled',true);        
           /**~~~ AUTOCOMPLETE SEARCH - STEP 1 OF CREATING FORMULAS ~~~**/
            var dataSrc = [
                @foreach($formulas as $formula)
                    "{!! $formula['name'] !!} - {!! $formula['brand'] !!}",
                @endforeach
            ];

            $("#ingredientsAuto").autocomplete({
                source: dataSrc,
                minLength: 2,
                _renderItem: function(ul, item) {
                    return $("<li>")
                        .attr("data-value", item.value)
                        //no need to unescape here
                        //because htmlentities will get interpreted
                        .append($("<a>").html(item.label))
                        .appendTo(ul);
                },
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
                            $("#ingredientsAuto").val('');
                            $('#stepTwo').slideDown( "slow", function() {
                                $( "#newFormula" ).fadeIn(1300);
                              });                            
                            var productDetails = data['ingredient'][0];

                            //check for existing row to prevent dupe
                            if($("#row_"+ productDetails['id'] +"").length){
                                $('#dupeModal').modal();
                                
                            } else {                                
                                var addRow = '<tr id="row_'+ productDetails["id"] +'"><td>'+ productDetails["pinyin"] +'</td><td><input type="number" onkeydown="limit(this);" onkeyup="limit(this);" min="0" max="99" data-cpg="'+ productDetails["costPerGram"] +'" data-prid="'+ productDetails["id"] +'" autofocus class="userGrams form-control" style="max-width: 100%" step="0.1" id="userGram_'+ productDetails["id"] +'" name="userGram_'+ productDetails["id"] +'"></td><td>$'+ productDetails["costPerGram"] +'</td><td>$<span class="subTotals" id="subTotal_'+ productDetails["id"] +'">0.00</span></td><td><a href="#" tabindex="-1" class="removeIngredient btn btn-sm btn-danger text-white">Remove</a></td></tr>';
                                $('#ingredientslist > tbody:last').append(addRow);
                            }
                            
                            $("#userGram_"+ productDetails['id'] +"").focus();                           
                        }
                    })                    
                }
            });          
        
        // address weird shift+tab issue to get back into grams field
        $( document ).ready(function() {
            $('#calculateFormula').on('keydown blur', function(e) {    
                var keyCode = e.keyCode || e.which;     
                    if(e.shiftKey && e.keyCode == 9) {
                        $("#ingredientsAuto").focus();
                    }                       
            });
        });
        
            
        /**~~~ FORMULA OVERVIEW MANAGEMENT - STEP 2 OF CREATING FORMULAS ~~~**/

        $(document).on('change keyup keydown', '.userGrams', function(){
            if($('.userGrams').length){
                $('#calculateFormula').show(); 
            }
                       
            var currentSubTotal = $("#subTotal_"+ prid +"").text();  
            var grams = $(this);
            var prid = $(grams).data('prid');
            var cpg = $(grams).data('cpg');
            var userGrams = $(grams).val();            
            var subTotal = parseFloat(userGrams) * parseFloat(cpg);             
            var ingredientSubTotal = parseFloat(subTotal).toFixed(2);
            var grandTotal = '0.00';            

            $("#subTotal_"+ prid +"").html(ingredientSubTotal);
            
        });

        function limit(element)
        {
             
            var split = element.value.toString().split('.');
            if(split[0] < 4){
                var max_chars = 3; 
            } else {
                var max_chars = 4; 
            }

            if(split[1] > max_chars) {
                element.value = element.value.substr(0, max_chars);
            }
        }
          
        /** FORMULA OVERVIEW - REMOVE ADDED INGREDIENT **/
            $(document).on('click','.removeIngredient', function() {
                var remove = $(this);
                var rprid = $(this).data('prid');
                
                var tr = $(this).closest('tr');
                $('#subtotal_'+rprid).html('');
                $(tr).remove();
                if ($('#ingRows > tr').length == 0){
                    $('#calculateFormula').hide();  
                    $('#saveFormula').prop('disabled',true);
                    $( ".finalizeFormula" ).slideUp( "slow", function() {
                        $( ".finalizeFormula" ).hide();
                  });
                    $('#stepTwo').slideUp( "slow", function() {
                        $( "#newFormula" ).fadeOut(1300);
                      });
                    $("#ingredientsAuto").focus();
                }  
                return false;
            });
            
         /** FORMULA CALCULATION **/ 
         $('#calculateFormula').on('click',function(){

            $("#formulaName").focus();
            var sum = 0;
            $( ".subTotals" ).each(function() {
                var value = $(this).text();
                // add only if the value is number
                if(!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
              });
              $('#grandTotal').html(parseFloat(sum).toFixed(2));
              $( ".finalizeFormula" ).slideDown( "slow", function() {
                    $( ".finalizeFormula" ).show();
                    $("#formulaName").focus();
              });
         });
         
         $('#formulaName').on('change',function(){
             if($('#formulaName').length){
                $('#saveFormula').prop('disabled',false);
             }            
         });
         
            
        </script>       
    @endpush
   
@endsection