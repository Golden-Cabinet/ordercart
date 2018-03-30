@extends('dashboard.layouts.main')
@section('content')
<h4><i class="far fa-plus-square"></i> Create A New Formula</h4>
<hr />

<input id="testAuto">
<div class="table-responsive col-md-6 float-left fade-in">
    <table id="dashboardFormulasTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
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

    @push('dataSet')
    <script>

            var dataSet = [                
                @foreach($formulas as $formula)
                    [                      
                    "<strong>{{ $formula['name'] }}</strong> <br /><em class='text-secondary'>{{ $formula['brand'] }}</em>",
                    "<span>{{ $formula['costPerGram'] }}</span>",
                    "<button href='#' data-selected_ingredient='{{ $formula['name'] }}' data-prid='{{ $formula['id'] }}' id='{{ $formula['id'] }}' data-cpg='{{ $formula['costPerGram'] }}' class='passformula_{{ $formula['id'] }} btn btn-success btn-sm'>Add</button>",                    
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
                        { title: "$/gram" },
                        { title: "Add" }
                    ],
    
                } );                
                
            } );
            

            var prodArray = [];

            $(document).ready(function() { 
                $('div.dataTables_filter input').focus();
                $('.dataTables_scroll').css('display','none');  
                $('.btn-success').prop('disabled',false); 

                $('#dashboardFormulasTable').on('shown.bs.modal', function(e){
                    $($.fn.dataTable.tables(true)).DataTable()
                       .columns.adjust();
                 });
                              
                 $('#formulaName').prop('disabled', true);
                 $('#formulaName').val('');
                 var searchBox = $('input[type="search"]');
                var $buttons = $('input[type=button]');
                $(searchBox).bind('keyup change', function() {                    

                    if($(searchBox).val().length > 1) {                    
                        $('.dataTables_scroll').slideDown('slow');
                    } else {                        
                        $('.dataTables_scroll').slideUp('slow');
                    };

                });

                var userGrams = $('.userGrams');
                $(userGrams).bind('keyup change', function() {
                    $(this).siblings(':button').prop('disabled', true);
                    var current = $(this); 
                    var prid = $(this).attr('data-prid'); 
                    var currentButton = $('.passformula_' + prid);                  
                                     
                    if( $(current).val().length > 0) {                      
                        
                        hideTr(prid);
                        $('.passformula_' + prid).prop('disabled',false);                        

                        var ingredient = $(current).attr('data-ingredient');
                        var grams = parseFloat($(current).val());
                        var cpg = parseFloat($(current).attr('data-cpg'));
                        var sub = grams*cpg;
                        $('#subtotal_' + prid).html('$' + parseFloat(sub).toFixed(2));

                        // add to overview

                        $('.btn-success').unbind().click(function(){
                            $('div.dataTables_filter input').val('');
                            $('.dataTables_scroll').slideUp('slow');
                            $('div.dataTables_filter input').focus();
                            var newRow = '<tr id="row_' + prid + '"><td>' + ingredient +'</td><td><input type="number" step=".1" min="0" id="" class="userGrams form-control" data-ingredient="'+prid+'" data-cpg="" data-prid="'+prid+'" name="grams_'+prid+'"></td><td>$' + parseFloat(sub).toFixed(2) +'</td><td><a href="#" data-subtotal="'+ parseFloat(sub).toFixed(2) +'" data-ingredientid="' + prid + '" id="removeIngredient_' + prid + '" class="removeIngredient btn btn-sm btn-danger"><i class="fas fa-minus-circle"></i> Remove</a></td>';
                            $('#ingredientslist > tbody:last-child').append(newRow);
                            $('.passformula_' + prid).prop('disabled',true);
                            
                            // update the total in the formula overview
                            var currentTotal = $('#grandTotal').text();
                            var newSum = parseFloat(sub).toFixed(2);
                            
                           if(currentTotal == '0.00')
                           {
                            var grandTotal = parseFloat(newSum).toFixed(2);
                            showTr(prid);  
                            
                           } else {
                            var addedTotals = parseFloat(currentTotal) + parseFloat(newSum);
                            var grandTotal = parseFloat(addedTotals).toFixed(2);
                           }
                            $('#grandTotal').html(grandTotal);

                            $('#formulaName').prop('disabled', false);
                            $('#saveFormula').show();

                            showTr(prid);
                            
                            //create new hidden field with values
                            var values = {
                                product_id: parseInt(prid),
                                grams: parseInt(grams),
                                subtotal: parseFloat(sub).toFixed(2)
                            };
                            
                            $('<input>').attr({
                                type: 'hidden',
                                id: "formulaDataString",
                                class: prid,
                                name: "formulaData_"+prid+"",
                                value: JSON.stringify(values)
                            }).appendTo('#newFormula');
                            //var hiddenField = '<input type="hidden" id="formulaDataString_'+prid+'" name="formulaData_'+prid+'" value="'+JSON.stringify(values)+''">';

                             return false;
                        });

                    } else {                        
                        $('.passformula_' + prid).prop('disabled',true);
                        $('#subtotal_' + prid).html('');
                    };
                });
                
                function hideTr(id) {
                    $('.userGrams').not('#' + id).prop('disabled',true);
                }

                function showTr(id) {
                    $('.userGrams').not('#' + id).prop('disabled',false);
                }

                
            });
            
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
    @push('js')
    <script>
        var data = [
			{ value: "AL", label: "Alabama" },
			{ value: "AK", label: "Alaska" },
			{ value: "AZ", label: "Arizona" },
			{ value: "AR", label: "Arkansas" },
			{ value: "CA", label: "California" },
			{ value: "CO", label: "Colorado" },
			{ value: "CT", label: "Connecticut" },
			{ value: "DE", label: "Delaware" },
			{ value: "FL", label: "Florida" },
			{ value: "GA", label: "Georgia" },
			{ value: "HI", label: "Hawaii" },
			{ value: "ID", label: "Idaho" },
			{ value: "IL", label: "Illinois" },
			{ value: "IN", label: "Indiana" },
			{ value: "IA", label: "Iowa" },
			{ value: "KS", label: "Kansas" },
			{ value: "KY", label: "Kentucky" },
			{ value: "LA", label: "Louisiana" },
			{ value: "ME", label: "Maine" },
			{ value: "MD", label: "Maryland" },
			{ value: "MA", label: "Massachusetts" },
			{ value: "MI", label: "Michigan" },
			{ value: "MN", label: "Minnesota" },
			{ value: "MS", label: "Mississippi" },
			{ value: "MO", label: "Missouri" },
			{ value: "MT", label: "Montana" },
			{ value: "NE", label: "Nebraska" },
			{ value: "NV", label: "Nevada" },
			{ value: "NH", label: "New Hampshire" },
			{ value: "NJ", label: "New Jersey" },
			{ value: "NM", label: "New Mexico" },
			{ value: "NY", label: "New York" },
			{ value: "NC", label: "North Carolina" },
			{ value: "ND", label: "North Dakota" },
			{ value: "OH", label: "Ohio" },
			{ value: "OK", label: "Oklahoma" },
			{ value: "OR", label: "Oregon" },
			{ value: "PA", label: "Pennsylvania" },
			{ value: "RI", label: "Rhode Island" },
			{ value: "SC", label: "South Carolina" },
			{ value: "SD", label: "South Dakota" },
			{ value: "TN", label: "Tennessee" },
			{ value: "TX", label: "Texas" },
			{ value: "UT", label: "Utah" },
			{ value: "VT", label: "Vermont" },
			{ value: "VA", label: "Virginia" },
			{ value: "WA", label: "Washington" },
			{ value: "WV", label: "West Virginia" },
			{ value: "WI", label: "Wisconsin" },
			{ value: "WY", label: "Wyoming" }
		];
            $('#testAuto').autocomplete({
                source: data
            });
    </script>
    @endpush
   
@endsection