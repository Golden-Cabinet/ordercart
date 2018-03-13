@extends('dashboard.layouts.main')
@section('content')
<h4>Create A New Formula</h4>
<hr />


<div class="table-responsive col-md-7 float-left">
    <table id="dashboardFormulasTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
<div class="col-md-5 float-right">
    <div class="card">
    <h5 class="card-header bg-info text-white">Formula Overview</h5>
    <div class="card-body">
        <h5 class="card-title">Select from the ingredients table, then create a formula name below.</h5>
        <hr />
        <form method="POST" enctype="application/x-www-form-urlencoded" action="/dashboard/formulas/store">
        <input type="text" class="form-control" name="formula_name" placeholder="Enter Your New Formula Name">
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
            <input type="hidden" id="formulaData" name="formulaData[]">
            {{ csrf_field() }}
            <hr />
            <div class="col-md-9 float-left text-bold" style="font-size: 1.2rem;"><p>Grand Total: $<span id="grandTotal">0.00</span></p> </div> 
            
            <div class="col-md-3 float-left"> 
                <button href="#" id="saveFormula" type="submit" style="width: 100%; display: none" class="btn btn-primary btn-sm text-center">Create</button>
                </div>
        </form>
        </div>
    </div>
    </div>
</div>
    @push('dataSet')
    <script>

            var dataSet = [                
                @foreach($formulas as $formula)
                    [                      
                    "<strong>{{ $formula['name'] }}</strong> <br /><em class='text-secondary'>{{ $formula['brand'] }}</em>",
                    "<input type='number' step='.01' min='0' class='userGrams form-control' data-ingredient='{{ $formula['name'] }}' data-cpg='{{$formula['costPerGram']}}' data-prid='{{ $formula['id'] }}' name='grams_{{ $formula['id'] }}'>",
                    "<span>{{ $formula['costPerGram'] }}</span>",
                    "<span id='subtotal_{{ $formula['id'] }}'></span>",
                    "<button href='#' data-selected_ingredient='{{ $formula['name'] }}'data-id='{{ $formula['id'] }}' data-cpg='{{ $formula['costPerGram'] }}' class='passformula_{{ $formula['id'] }} btn btn-success btn-sm'>Add</button>",                    
                    ],
               
                @endforeach                
            ];
    
            $(document).ready(function() {                

                $('#dashboardFormulasTable').DataTable( {
                    data: dataSet, 
                    "bLengthChange": false,
                    "scrollY": "600px",
                    "bInfo" : false,
                    "paging": false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search The Ingredients Table"
                    }, 
    
                    columns: [                        
                        { title: "Pinyin" },
                        { title: "Grams" },
                        { title: "$/gram" },
                        { title: "Subtotal" },
                        { title: "Add" }
                    ],
    
                } );                
                
            } );
            
            $(document).ready(function() { 
                
                

                
                $('.btn-success').prop('disabled',true); 
                $('.dataTables_scroll').hide();
                var searchBox = $('input[type="search"]');
                $(searchBox).bind('keyup change', function() {

                    if($(searchBox).val().length > 0) {                    
                        $('.dataTables_scroll').slideDown('slow');
                    } else {                        
                        $('.dataTables_scroll').slideUp('slow');
                    };

                });

                var userGrams = $('.userGrams');
                $(userGrams).bind('keyup change', function() {
                    var current = $(this); 
                    var prid = $(this).attr('data-prid');                   
                                     
                    if($(current).val().length > 0) {                                                    
                        $('.passformula_' + prid).prop('disabled',false);
                        var ingredient = $(current).attr('data-ingredient');
                        var grams = parseFloat($(current).val());
                        var cpg = parseFloat($(current).attr('data-cpg'));
                        var sub = grams*cpg;
                        $('#subtotal_' + prid).html('$' + parseFloat(sub).toFixed(2));

                        // add to overview

                        $('.btn-success').unbind().click(function(){
                            var newRow = '<tr id="row_' + prid + '"><td>' + ingredient +'</td><td>'+ grams +'</td><td>$' + parseFloat(sub).toFixed(2) +'</td><td><a href="#" data-subtotal="'+ parseFloat(sub).toFixed(2) +'" data-ingredientid="' + prid + '" id="removeIngredient_' + prid + '" class="removeIngredient btn btn-sm btn-danger">Remove</a></td>';
                            $('#ingredientslist > tbody:last-child').append(newRow);
                            $('.passformula_' + prid).prop('disabled',true);
                            
                            // update the total in the formula overview
                            var currentTotal = $('#grandTotal').text();
                            var newSum = parseFloat(sub).toFixed(2);
                            
                           if(currentTotal == '0.00')
                           {
                            var grandTotal = parseFloat(newSum).toFixed(2);  
                            
                           } else {
                            var addedTotals = parseFloat(currentTotal) + parseFloat(newSum);
                            var grandTotal = parseFloat(addedTotals).toFixed(2);
                           }
                            $('#grandTotal').html(grandTotal);

                            $('#saveFormula').show();
                           
                             return false;
                        });

                    } else {                        
                        $('.passformula_' + prid).prop('disabled',true);
                        $('#subtotal_' + prid).html('');
                    };
                });              


            });
            
            $(document).on('click','.removeIngredient', function() {
                var remove = $(this);
                var subTotal = $(this).attr('data-subtotal');
                var rprid = $(this).attr('data-ingredientid');
                var tr = $(this).closest('tr');
                var currentTotal = $('#grandTotal').text();

                var subtractedTotals = parseFloat(currentTotal) - parseFloat(subTotal);
                var finalSubtracted = parseFloat(subtractedTotals).toFixed(2);

                $('.passformula_' + rprid).prop('disabled',false);
                $('#row_'+rprid).remove();  
                
                if(subtractedTotals < 0.01 )
                {
                    var newTotal = $('#grandTotal').html('0.00');
                    $('#saveFormula').hide();
                } else {
                    var newTotal = $('#grandTotal').html(finalSubtracted);
                }
                var grandTotal = parseFloat(newTotal).toFixed(2);
                return false;
            });        
            
        </script>
    @endpush
    @push('js')
    <script>
        
            
    </script>
    @endpush
   
@endsection