
        <h2>Patient/Formula</h2>
        <section>
         <h3 style="font-size: 1.8rem;"><i class="fas fa-user-plus"></i> Patient Information</h3>
         <hr />       
        <div class="form-group row">
                <label for="patientLookup" class="col-sm-3 col-form-label">Patient</label>
                <div class="col-sm-9">
                        <select class="form-control" id="patientLookup">
                                <option id="patient_greeting">Please Select a Patient</option>
                                <option id="add_patient">Add a New Patient</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                        </select>
                </div>
        </div>

        <div class="form-group row">
                        <label for="formulaLookup" class="col-sm-3 col-form-label">Formula</label>
                        <div class="col-sm-9">
                                <select class="form-control" id="formulaLookup">
                                        <option id="formula_greeting">Please Select a Formula</option>
                                        <option id="add_formula">Add a New Formula</option>
                                        @foreach($formulas as $formula)
                                        <option data-id="{{ $formula->id }}" value="{{ $formula->id }}">{{ $formula->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                </div>
        <hr />


        <div id="adjustFormula" style="display: none">
              <h3 style="font-size: 1.8rem;"><i class="fas fa-balance-scale"></i> Scale Formula</h3>
              <div class="table-responsive">
                        <table class="table w-100" id="ingListInitial">
                            <tr>
                                <th>Pinyin</th>
                                <th>Common Name</th>
                                <th>$/g</th>
                                <th>Grams</th>
                                <th>Subtotal</th>
                            </tr>
                            <tbody id="currentFormulaIngredients">

                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-group row">
                                <label for="formulaWeight" class="col-sm-3 col-form-label">Total Weight (grams)</label>
                                <div class="col-sm-9">
                                <input type="number" class="form-control" id="formulaWeight" value="">
                                </div>
                        </div>
        </div>


        <div class="form-group row">
                <label for="formulaLookup" class="col-sm-3 col-form-label">Formula Cost</label>
                <div class="col-sm-9">
                        $<span id="formulaCost">0.00</span>
                </div>
        </div>
        <hr />
        <div class="form-group row">
                <label for="formulaLookup" class="col-sm-3 col-form-label">Discount/Dividend</label>
                <div class="col-sm-9">
                        <select id="chooseDividend" name="dividend" class="form-control">
                                <option>Please Select Dividend or Discount</option>
                                <option id="" value="0.90">Apply 10% Discount (no dividend credit)</option>
                                <option id="" value="0.85">No Discount (15% dividend credit)</option>
                        </select>
                </div>
        </div>
        <hr />
        <div class="form-group row">
                <label for="formulaLookup" class="col-sm-3 col-form-label">Total</label>
                <div class="col-sm-9">
                        $<span id="formulaTotal">0.00</span>
                </div>
        </div> 	
        <hr />
        <span style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle text-danger"></i> If you hit the "Back" button on your browser, the order will be cancelled.</span>
                
        </section>           


        @push('js')
        <script>
        $(document).ready(function(){
               

        // dynamically adjust the grand total
       function update_amounts()
           {
               var sum = 0;
               $('.subTotals').each(function () {
                   var prodprice = parseFloat($(this).text());
                   sum = sum + prodprice;
               });
               console.log(sum);
               $("#formulaCost").text(sum.toFixed(2));
           }

       // dynamically adjust gram totals
       function update_gram_amounts()
           {
               var sum = 0;
               $('.userGrams').each(function () {
                   var prodprice = parseFloat($(this).text());
                   sum = sum + prodprice;                    
               });

               $("#formulaWeight").val(sum.toFixed(1));
           }

                //formula dropdown
                $(document).on('change','#formulaLookup',function(){
       
                $("#currentFormulaIngredients").empty();
                $("#currentFormulaIngredients").show(1300); 
               

               // ajax call to get the formula data into the table
               var selection = $('#formulaLookup option:selected').data('id');

               if($(selection).length) {
                        $.ajax({
                        url: "/dashboard/orders/find/"+selection+"",
                        type: 'GET',
                        success: function(res) {
                                var fIngredients = res['formulaIngredients'];
                                
                                $(fIngredients).each(function(key,val){
                                        var addRow = '<tr class="formulaIngredients" data-rowid="'+val["formulaId"]+'"><td>'+val["pinyin"]+'</td><td>'+val["common_name"]+'</td><td>'+val["cpg"]+'</td><td class="userGrams">'+val["current_grams"]+'</td><td class="subTotals">'+val["subtotal"]+'</td></tr>'
                                        $('#ingListInitial > tbody:last').append(addRow);
                                        var grams = grams + parseFloat(val["current_grams"]);                                                                                                               
                                }); 
                                update_gram_amounts();
                                update_amounts();
                                $('#adjustFormula').slideDown();
                                
                        }
                        });
               } else {
                        $('#adjustFormula').hide();
                        $("#currentFormulaIngredients").empty();
                        $("#currentFormulaIngredients").hide(300); 
               }         
       
       });

        
        
        }); // end document ready        
        

        
        
        </script>
        @endpush