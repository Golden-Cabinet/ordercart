@extends('dashboard.layouts.main')
@section('content')
<h4><i class="fas fa-flask"></i> Editing Formula: {{ $formulaName }}</h4>
<hr />

    <div class="card">
    <h5 class="card-header bg-info text-white">  Formula Overview</h5>
    <div class="card-body">
        
        
        <div id="stepTwo">
        <form method="POST" id="newFormula" enctype="application/x-www-form-urlencoded" action="/dashboard/formulas/update/{{ $formulaId }}">        
            <div class="table-responsive" style="width: 100%;">
                <h5>Modify Your Selected Ingredients</h5>                    
                    <table class="ca-dt-bootstrap table" style="width: 100%;" id="ingredientslist">
                        <tr>
                            <th style="width: 37%">Pinyin</th>
                            <th style="width: 2%">Grams</th>
                            <th style="width: 20%">$/Gram</th>
                            <th style="width: 20%;">Subtotal</th>
                            <thstyle="width: 20%">&nbsp;</th>
                        </tr>                
                        <tbody id="ingRows" style="width: 100%"></tbody>
                    </table>             
            </div>
            

            <div id="ingredientsTotal" class="col-md-8 mt-1" style="float: right; margin-right: 150px; clear: both; border-top: 1px solid black; font-weight: bold">

                <div class="col-md-3 float-left pt-2">Totals:</div>
                <div class="col-md-5 float-left pt-2" style="padding-left: 1.3rem;">&nbsp;&nbsp;<span id="totalGrams"></span></div>
                <div class="col-md-2 float-left pt-2" style="padding-left: 3rem; margin-left: 0;">$<span id="runningTotal">0.00</span></div>

            </div>

                
            {{ csrf_field() }}          
        
        </div>
        
        <div style="width: 100%; clear: both;">
                <hr />
            <div class="col-md-7 float-left">
                    <h5 class="ingredientSearch">Add Additional Ingredients To Formula</h5>
                    <input id="ingredientsAuto" autofocus class="form-control mb-4" tabindex="0" placeholder="Start Your Search Here">  
            </div>
            
            <div class="col-md-3 float-left">
                    <h5>Grams</h5>
                <input type="number" step="0.1" onkeydown="limit(this);" onkeyup="limit(this);" min="0" max="99" id="initialgrams" class="form-control">
            </div>

            <div class="col-md-2  float-left mt-2 mb-4">
                <p class="text-right"><a href="#" style="display: none" id="addToTopRow" class="btn btn-info mt-4 text-white" data-ingredientId="" data-ingredient="" data-cpg="">Add To Formula</a></p>            
            </div>            
        </div>

        
        <hr style="clear: both; width: 100%" />
        <div class="finalizeFormula" style="width: 100%; clear: both;">
                
            <h5>Create Your Formula Name and Save It!</h5>
            <input type="text" style="background: #ffffe0" class="form-control mb-4" value="{{ $formulaName }}" id="formulaName" name="formula_name" placeholder="Enter Your New Formula Name">
            @if($formulaDeleted == 1)
            <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="undelete" value="undelete" id="undelete">
                    <label class="form-check-label" for="undelete">
                      <strong class="text-danger">This formula is deleted. Click here To re-enable it as available for use.</strong>
                    </label>
                  </div>
            @endif
            <button href="#" id="saveFormula" type="submit" class="btn btn-success btn-lg text-center float-right"><i class="fas fa-check"></i> Save Formula</button>           
                
        </div>
        <input type="hidden" name="formulaData" id="formulaData" value="">        
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
            $( document ).ready(function() {
                // add in existing ingredients this way... for some stupid reason
            @foreach($formulaIngredients as $ingredient)
            var productId = "{{ $ingredient['id'] }}";
            var productName = "{{ $ingredient['name'] }}";
            var productCostPerGram = "{{ $ingredient['cpg'] }}";
            var currentGrams = "{{ $ingredient['current_grams'] }}";
            var subTotal = productCostPerGram * currentGrams; 
            var ingredientSubTotal = parseFloat(subTotal).toFixed(2);
            var currentGrandTotal = $('#runningTotal').text();
            var newGrandTotal = parseFloat(currentGrandTotal) + parseFloat(subTotal);
            
            // add to the elems object at beginning of script
            
            var addedTotal = newGrandTotal;
            $('#runningTotal').html(parseFloat(newGrandTotal).toFixed(2)); 
            
             var addRow = '<tr id="row_'+ productId +'"><td>'+ productName +'</td><td><input type="number" onkeydown="limit(this);" onkeyup="limit(this);" min="0" max="99" data-cpg="'+ productCostPerGram +'" data-prid="'+ productId +'" class="userGrams form-control" style="width: 80px" step="0.1" id="userGram_'+ productId +'" value="'+currentGrams+'"></td><td>$'+ productCostPerGram +'</td><td class="subs">$<span class="subTotals" id="subTotal_'+ productId +'">'+ingredientSubTotal+'</span></td><td><a href="#" tabindex="-1" class="removeIngredient btn btn-sm btn-danger text-white">Remove</a></td></tr>';
             $('#ingredientslist > tbody:last').append(addRow);

             update_gram_amounts();

             var obj = {};
              var elements = []; // create object for hidden form field
            $('.userGrams').each(function(){
                var productID = $(this).attr('data-prid');
                var productGrams = $(this).val();
                var data = {"product_id":productID,"product_grams":productGrams};
                elements.push(data);
            });
            $('#formulaData').val(JSON.stringify(elements));
            @endforeach             
        });
        
        $(document).ready(function() {
            $(window).keydown(function(event){
              if(event.keyCode == 13) {
                event.preventDefault();
                return false;
              }
            });
          });
            

            $("#ingredientsAuto").focus();
            $('#saveFormula').prop('disabled',false);        
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
                    $("#ingredientsAuto").focus();                                        

                    //do an ajax get call to return this one product/brand combo for the formula overview
                    $.ajax({
                        url : '/dashboard/formulas/search/product/'+ product +'/brand/'+ brand,
                        type: 'GET',
                        success : function(data){   
                            $("#initialgrams").focus();                            

                            // add data fields to button
                            var productDetails = data['ingredient'][0];
                            var productName= product;
                            var productId = productDetails['id'];
                            var productCostPerGram = productDetails['costPerGram'];
                            $("#addToTopRow").attr('data-ingredientId',productId);
                            $("#addToTopRow").attr('data-ingredient',productName);
                            $("#addToTopRow").attr('data-cpg',productCostPerGram);

                        }
                    })                    
                }
            });

        // enable add to formula if grams field is filled in
        $("#initialgrams").on('keyup keydown', function(){
            var igVal = $("#initialgrams").val();
            if(igVal.length > 0){
                $("#addToTopRow").show();
            } else {
                $("#addToTopRow").hide();
            }
        });

                

        // add ingredient button stuff
        $("#addToTopRow").on('click keydown', function(){
            
            $(".ingredientSearch").text('Add Additional Ingredients To Formula');
            var currentGrams = $('#initialgrams').val();
            $("#ingredientsAuto").val('');
            $('#initialgrams').val('');
            $('#stepTwo').slideDown( "slow", function() {
                $( "#newFormula" ).fadeIn(1300);
                $("#calculateFormula").show();
            });                           
            
            var productId = $(this).attr('data-ingredientId');
            var productName = $(this).attr('data-ingredient');
            var productCostPerGram = $(this).attr('data-cpg');
            var subTotal = productCostPerGram * currentGrams; 
            var ingredientSubTotal = parseFloat(subTotal).toFixed(2);
            var currentGrandTotal = $('#runningTotal').text();
            var newGrandTotal = parseFloat(currentGrandTotal) + parseFloat(subTotal);
            
            // add to the elems object at beginning of script

            
            var addedTotal = newGrandTotal;
            $('#runningTotal').html(parseFloat(newGrandTotal).toFixed(2));            

            //check for existing row to prevent dupe
            if($("#row_"+productId +"").length){
                $('#dupeModal').modal();                                
            } else {                
                var addRow = '<tr id="row_'+ productId +'"><td>'+ productName +'</td><td><input type="number" onkeydown="limit(this);" onkeyup="limit(this);" min="0" max="99" data-cpg="'+ productCostPerGram +'" data-prid="'+ productId +'" class="userGrams form-control" style="width: 80px" step="0.1" id="userGram_'+ productId +'" value="'+currentGrams+'"></td><td>$'+ productCostPerGram +'</td><td class="subs">$<span class="subTotals" id="subTotal_'+ productId +'">'+ingredientSubTotal+'</span></td><td><a href="#" tabindex="-1" class="removeIngredient btn btn-sm btn-danger text-white">Remove</a></td></tr>';
                $('#ingredientslist > tbody:last').append(addRow);
                // if we have any existing rows, we always wait until the new one has got a value before moving on
                $("#addToTopRow").attr('data-ingredientId','');
                $("#addToTopRow").attr('data-ingredient','');
                $("#addToTopRow").attr('data-cpg','');
                if($('#ingRows > tr').length > 0){
                    //$('#calculateFormula').hide();

                    update_gram_amounts()
                }
                $("#ingredientsAuto").focus();
                //$("#userGram_"+ productId +"").focus();
            }
            $("#addToTopRow").hide();
            
        })    

        
            
        /**~~~ FORMULA OVERVIEW MANAGEMENT - STEP 2 OF CREATING FORMULAS ~~~**/

        $(document).on('change keyup keydown click', '.userGrams', function(){
                        
            var currentSubTotal = $("#subTotal_"+ prid +"").text();            
            var grams = $(this);
            var prid = $(grams).data('prid');
            var cpg = $(grams).data('cpg');
            var userGrams = $(grams).val();            
            var subTotal = parseFloat(userGrams) * parseFloat(cpg);                               
            var ingredientSubTotal = parseFloat(subTotal).toFixed(2);            
            var currentGrandTotal = $('#runningTotal').text();
            var parsedGrandTotal = parseFloat(currentGrandTotal);
            update_gram_amounts();
            update_amounts();
       

            $("#subTotal_"+ prid +"").html(ingredientSubTotal);

            var obj = {};
              var elements = []; // create object for hidden form field
            $('.userGrams').each(function(){
                var productID = $(this).attr('data-prid');
                var productGrams = $(this).val();
                var data = {"product_id":productID,"product_grams":productGrams};
                elements.push(data);
            });
            $('#formulaData').val(JSON.stringify(elements));
            
        });

        // dynamically adjust the grand total
        function update_amounts()
            {
                var sum = 0;
                $('.subTotals').each(function () {
                    var prodprice = parseFloat($(this).text());
                    console.log(prodprice);
                    sum = sum + prodprice;
                });
                $("#runningTotal").text(sum.toFixed(2));
            }

        // dynamically adjust gram totals
        function update_gram_amounts()
            {
                var sum = 0;
                $('.userGrams').each(function () {
                    var prodprice = parseFloat($(this).val());
                    console.log(prodprice);
                    sum = sum + prodprice;
                });

                $("#totalGrams").text(sum.toFixed(1));
            }    

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
          
        /** FORMULA OVERVIEW - REMOVE ADDED INGREDIENT  **/
            $(document).on('click','.removeIngredient', function() {
                 
                var remove = $(this);
                var rprid = $(this).data('prid');
                
                var tr = $(this).closest('tr');
                $('#subtotal_'+rprid).html('');
                $(tr).remove();
                if ($('#ingRows > tr').length == 0){
                    $('#calculateFormula').hide();  
                    $('#saveFormula').prop('disabled',true);
                    
                    $('#stepTwo').slideUp( "slow", function() {
                        $( "#newFormula" ).fadeOut(1300);
                      });
                    $("#ingredientsAuto").focus();
                }
                update_gram_amounts();
                update_amounts();  
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
              $( ".finalizeFormula" ).slideDown( "slow", function() {
                    $( ".finalizeFormula" ).show();
                    $("#formulaName").focus();
              });
              var obj = {};
              var elements = []; // create object for hidden form field
            $('.userGrams').each(function(){
                var productID = $(this).attr('data-prid');
                var productGrams = $(this).val();
                var data = {"product_id":productID,"product_grams":productGrams};
                elements.push(data);
            });
            $('#formulaData').val(JSON.stringify(elements));
         });
         
         $('#formulaName').on('change keydown',function(e){
            var keyCode = e.keyCode || e.which;     
            if(e.shiftKey && e.keyCode == 9) {
                $("#ingredientsAuto").focus();
            }
             if($('#formulaName').val().length <= 4){
                $('#saveFormula').prop('disabled',true);
             } else {
                $('#saveFormula').prop('disabled',false);
             }           
         });
            
        </script>       
    @endpush
   
@endsection

