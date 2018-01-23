<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">
    <h1 class='dashboard-title'><?php echo $title; ?></h1>
    <hr>

<!-- START VIEW FILE -->
		<div id="order_form_breadcrumb">
			<ul>
				<li id="order_patient_breadcrumb" class="order_form_breadcrumb_item order_form_breadcrumb_active">Patient/Formula</li>
				<li id="order_patient_breadcrumb_arrow" class="order_form_breadcrumb_arrow order_form_breadcrumb_arrow_active"></li>
				<li id="order_dosage_breadcrumb" class="order_form_breadcrumb_item">Dosage</li>
				<li id="order_dosage_breadcrumb_arrow" class="order_form_breadcrumb_arrow order_form_breadcrumb_arrow"></li>
				<li id="order_shipping_breadcrumb" class="order_form_breadcrumb_item">Shipping/Billing</li>
				<li id="order_shipping_breadcrumb_arrow" class="order_form_breadcrumb_arrow order_form_breadcrumb_arrow"></li>
				<li id="order_notes_breadcrumb" class="order_form_breadcrumb_item">Notes</li>
				<li id="order_notes_breadcrumb_arrow" class="order_form_breadcrumb_arrow order_form_breadcrumb_arrow"></li>
				<li id="order_review_breadcrumb" class="order_form_breadcrumb_item">Review and Submit</li>
				<li id="order_review_breadcrumb_arrow" class="order_form_breadcrumb_arrow order_form_breadcrumb_arrow order_form_breadcrumb_arrow_last"></li>
			</ul>
		</div>
		
    <?php if (isset($error_messages)): ?>
        <div class="well">
            <?php foreach ($error_messages as $message): ?>
                <p><?php echo $message; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

		<div id="order_patient_container" class="order_form_container">

		<form action="/store/orders/add" method="post" accept-charset="utf-8" class="form-horizontal">    <?php
    if ($mode != 'build' AND $mode != 'edit') {
        $this->load->view('modules/store/orders/patient');
    }
    ?>
    <table id="select-formula-table" class="table table-condensed">
        <thead>
        <th></th>
        <th></th>
        <th></th>
        </thead>
        <tbody>

        <tr id="formulaRow">
            <!-- Patient Information-->
            <div class="form-group">
                <?php echo form_label('Formula', 'formula', array('class' => 'control-label col-sm-2'  )); ?>
                <div class="col-sm-10">
                    <select name="formula" class="form-control formula" id="formula">
														<option value="none">Choose a formula...</option>
                        <?php foreach ($formulas as $value): ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pull-right">
										&nbsp;&nbsp;or <a href="#" onclick="showLeavePage('formulas/build'); return false;">Add a formula</a>&nbsp;&nbsp;<img class="link_icon" src="/assets/images/link_icon.gif">
                    </div>

                </div>
								<div class="order_validation_message_container" id="formula_validation">
									Please choose a formula.
								</div>
            </div>
            
            <!-- adjust formula ratios -->
            <section id="formulaAdjustments" class="hidden">
                <h4>Adjust Formula</h4>
                <div id="formulaIngredients"></div>
                <div>
                  <strong>Total Weight: </strong> <input type="number" id="formulaAdjustTotalWeight" data-original-weight=""/>
                </div>
            </section>
        
            <!-- /end adjust formula ratios -->
            
            <td class="hidden"></td>
        </tr>
        
        
        <tr>
            <td class="w200">Formula Cost</td>
            <td id="formula-cost">&#36;0.00</td>

        </tr>
        <tr>
            <td class="w200"><a href='/dividends' class='header_highlighted_links' target='_blank' title='Learn more about our dividend program'>Discount/Dividend</a></td>
            <td>
                <select id="discount" name="discount" class="form-control">
                    <option value=".90">Apply 10% Discount (no dividend credit)</option>
                    <option value=".85">No Discount (15% dividend credit)</option>
                </select>
            </td>
        </tr>
        <tr id="dividend-row" class="hidden">
            <td class="w200">Dividends Earned</td>
            <td id="dividend-user"></td>
            <td class="hidden">
						</td>
        </tr>
        <tr>
            <td class="w200">Total</td>
            <td id="total-user">&#36;0.00</td>
            <td id="total" class="hidden">
            	<input type="hidden" id="formula_cost" name="formula_cost" value="0.00">
	            <input type="hidden" id="dividend" name="dividend" value="0">
							<input type="hidden" id="shipping_cost" name="shipping_cost" value="0.00">
							<input type="hidden" id="real_sub_total" name="sub_total" value="0">
							<input type="hidden" id="display_sub_total" value="0">
							<input type="hidden" id="orderRatio" name="ratio" value="1">
							<input type="hidden" id="real_formula_total" name="formula_total" value="0">
           		<input type="hidden" id="discount_amount" name="discount_amount" value="0">
					 </td>
        </tr>
        </tbody>
    </table>

		<a class="header_highlighted_links btn btn-secondary" href="#" onclick="showLeavePage('orders'); return false;">Cancel</a>&nbsp;&nbsp;&nbsp;
    <a class="btn btn-primary blue" onclick="orderAdvanceStep('dosage', 'patient'); return false;">Dosage <i class="fa fa-arrow-right"></i></a>
		<div class="order_navigation_warning">If you hit the "Back" button on your browser, the order will be cancelled.</div>
		</div>


    <?php

    if ($mode != 'build' AND $mode != 'edit') {
?>				
		<div id="order_dosage_container" class="order_form_container">
<?php        $this->load->view('modules/store/orders/dosage');  ?>
		</div>
		<div id="order_shipping_container" class="order_form_container">
<?php        $this->load->view('modules/store/orders/shipping'); ?>
<?php        $this->load->view('modules/store/orders/billing'); ?>
		</div>
		<div id="order_notes_container" class="order_form_container">
<?php        $this->load->view('modules/store/orders/notes'); ?>
		</div>

<?php   
 		}
?>

		<div id="order_review_container" class="col-sm-3 col-xs-12 order_form_container">
			
			<b>Patient:</b> <span id="order_review_patient"></span><br />
			<b>Dosage:</b> <span id="order_review_scoops"></span><br />
			<b>Frequency:</b> <span id="order_review_frequency"></span><br />
			<b>Refills:</b> <span id="order_review_refills"></span><br />
			<b>Special Instructions:</b> <p id="order_review_instructions"></p>
			<b>Payment:</b> <span id="order_review_billing"></span><br />
			<b>Shipping:</b> <span id="order_review_shipping_type"></span><br />
			<br />
			<b>Notes:</b> <p id="order_review_notes"></p>
			<b>Formula Cost:</b> <span id="order_review_formula_cost"></span><br />
			<b>Discount:</b> <span id="order_review_discount"></span><br />
			<b>Shipping Cost:</b> <span id="order_review_shipping"></span><br />
			<b>Total:</b> <span id="order_review_total"></span><br />
			<br /><br />
			<div class="form-group">
	        <div class="controls">
							<a class="header_highlighted_links btn btn-secondary" href="#" onclick="showLeavePage('orders'); return false;">Cancel</a>&nbsp;&nbsp;
              <input class="btn btn-primary button blue" type="submit" value="Submit Order" name=""><br />
							<a href="#" onclick="reviewStep('notes'); return false;">&#8592;  Back to Notes</a><br />
							<div class="order_navigation_warning">If you hit the "Back" button on your browser, the order will be cancelled.</div>
	        </div>
	    </div>
		</div>
		
		<div id="order_review_formula_container" class="col-sm-9 col-xs-12 order_form_container">
			<b>Formula:</b> <span id="order_review_formula"></span><br />
			<div id="order_review_formula_table_container"></div>
		</div>
		<div class="clear"></div>

    <?php form_close(); ?>

	<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

		

    <script>

        $(document).ready(function () {

            $("input#ship1").change(function () {
                $("div#shipping").show(600);
                $("#pickup").hide();
								calculateFormulaCosts();
            });

            $("input#ship2").change(function () {
                $("div#shipping").hide();
                $("#pickup").show(600);
                //$('td#shipping-user').html('&#36;0.00');
                $('#shipping_cost').val('0.00');
                var preSubTotal = $('#formula_cost').val();
                var discount = $("select#discount").val();
                if (discount == '.90') {
									var total = parseFloat(preSubTotal) * parseFloat(discount);
									var discount_amount = parseFloat(preSubTotal) * parseFloat(0.10);
								} else {
									var total = parseFloat(preSubTotal);
									
									var discount_amount = 0;
								}
								
								
								$('#real_sub_total').val(total.toFixed(2))
                $('#real_formula_total').val(total.toFixed(2))
								$('#discount_amount').val(discount_amount.toFixed(2))
                // $('td#total-user').html('&#36;' + total.toFixed(2));
                // $('#formula_total').html(total.toFixed(2));
                // $('td#sub-total-user').html('&#36;' + preSubTotal.toFixed(2));
                // $('#sub_total').html(preSubTotal.toFixed(2));
            });

						$('#formula').val('none')
						<?php if (!isset($_GET['patient_id'])) { ?>
						$('#patient_id').val('none')
						<?php } ?>


            $(document).on('change', 'select#formula', function () {
										$("select#discount").val('.90');
                    $("select#discount").trigger('change');
										var formulaId = $("select#formula").val();
                    var selector = "tr#formulaRow td:last-child";
                    $(selector).html('<input type="text" hidden="" name="formula_id" value="' + formulaId + '">');
                    
										calculateFormulaCosts();
            });


            $(document).on('change', 'select#discount', function (e) {

                var discount = $("select#discount").val();

                if(discount == '.90'){
                    var formula_cost = $('#formula_cost').val();
                    var display_sub_total = formula_cost * discount;
                    $('td#total-user').html('&#36;' + display_sub_total.toFixed(2));
                    $('#formula_total').html(display_sub_total.toFixed(2));
                    $('tr#dividend-row').hide();
                    $('td#dividend-user').html('');
                    $('#dividend').val(0);
										var discount_amount = parseFloat(formula_cost) * parseFloat(0.10);
										$('#discount_amount').val(discount_amount.toFixed(2))

                }else{
                  	var formula_cost = $('#formula_cost').val();
                    var dividend = parseFloat(formula_cost) * .15;
										var total = parseFloat(formula_cost);
										var real_total = parseFloat(total) + parseFloat($('#shipping_cost').val());
                    $('td#dividend-user').html('&#36;' + dividend.toFixed(2));
                    $('#dividend').val(dividend.toFixed(2));
                    $('td#total-user').html('&#36;' + total.toFixed(2));
                    $('#formula_total').html(total.toFixed(2));
                    $('tr#dividend-row').removeClass('hidden').show();
                    $('#real_sub_total').val(total.toFixed(2));
                    $('#real_formula_total').val(real_total.toFixed(2));
               			$('#discount_amount').val(0)
							 }

            });

        });

        /* New code to handle ratio changing
        ====================================================*/
        
				function calculateFormulaCosts() {
					
         	const formulaId = $("select#formula").val();
          const $formulaAdjustments = $('#formulaAdjustments');
                    
          $.ajax({
            type: 'POST',
            url: '<?php echo base_url('formulas/ingredients');?>',
            data: {
                formula_id: formulaId
            },
            success: function (data) {
              let ingredients = JSON.parse(data),
                  totalGrams = 0,
                  ratios = [],
                ingredientsHTML = [];
              
              // Calculate the total grams (and ratios) for order)              
              ingredients.forEach(function(ingredient){
                totalGrams += parseInt(ingredient.weight);
                ratios.push(1/ingredient.weight);
              });
              
              // update fomrula adjustment with current/default ratios
              let original = changeFormulaGrams(totalGrams, totalGrams, ratios, ingredients);              
              updateFormulaAdjustmentDisplay(original);                          
              
              // Save the original to calculate the ratio towards checkout
              $('#formulaAdjustTotalWeight').data('original-weight', totalGrams);
              updateFormulaRatio();
              
              // update again when the total weight of formual is changed
              $('#formulaAdjustTotalWeight').on('change', function(){
                let grams = parseInt($(this).val());
                let newFormulaRatios = changeFormulaGrams(grams, totalGrams, ratios, ingredients);
                updateFormulaAdjustmentDisplay(newFormulaRatios);                
              });
              
            }
          });
          
          function updateFormulaRatio() {
            let ratio = parseFloat($('#formulaAdjustTotalWeight').val()) / parseFloat($('#formulaAdjustTotalWeight').data('original-weight'));
            $('#orderRatio').val(ratio);
          }
          
          function changeFormulaGrams(newWeight, originalWeight, ratios, ingredients) {
            let newRatio = originalWeight / newWeight;
            let returnRatios = [];
            let returnPrices = [];
            
            ratios.forEach(function(ratio){
              returnRatios.push( parseFloat((1 / (ratio * newRatio)).toFixed(1)));
            });
            
            ingredients.forEach(function(ingredient,offset) {
              returnPrices.push( parseFloat((returnRatios[offset] * parseFloat(ingredient.costPerGram)).toFixed(2)) );
              // console.log(`${ingredient.common_name}: ${returnRatios[offset]} grams ($${returnPrices[offset]})`);
            });
            
            return {
              ingredients: ingredients, 
              ratios: returnRatios, 
              prices: returnPrices, 
              totalGrams: newWeight,
              totalPrice: returnPrices.reduce((a,b) => a+b).toFixed(2)
            };
          }
          
          function updateFormulaAdjustmentDisplay(data) {
            let ingredientsHTML = [];
            
            data.ingredients.forEach(function(ingredient, offset){
              ingredientsHTML.push(`
                <div>
                  <strong>${ingredient.common_name}</strong> —
                  <span>${data.ratios[offset]} grams</span> —
                  <strong>$${data.prices[offset].toFixed(2)}</strong>
                </div>
                `);            
            });
            
            $formulaAdjustments.find('#formulaIngredients').html(`
              <div>
              ${ingredientsHTML.join('')}
              </div>`);              
            
            $formulaAdjustments.find('#formulaAdjustTotalWeight').val(data.totalGrams);
            // update price            
            $('td#formula-cost').html('&#36;' + data.totalPrice);
            $('#formula_cost').val(parseFloat(data.totalPrice));
            
            calculateShipping(formulaId, data.totalPrice);
            if ($formulaAdjustments.hasClass("hidden")) $formulaAdjustments.removeClass('hidden');
          }
          
          
          /*====================================================*/          
          
				 	
					$.ajax({
              type: 'POST',
              url: '<?php echo base_url('formulas/cost');?>',
              data: {
                  formula_id: formulaId
              },
              success: function (data) {

                  var cost = JSON.parse(data);
                  var discount = $("select#discount").val();

                  $('td#formula-cost').html('&#36;' + cost.cost);
                  $('#formula_cost').val(parseFloat(cost.cost).toFixed(2));
									
                  if (cost.cost > 0) calculateShipping(formulaId, cost.cost);

              }
          });
				
          /* Calculate shipping
          ======================================
          */
          function calculateShipping(formulaId, cost) {
            let discount = $("select#discount").val();
            let ratio = parseFloat($('#formulaAdjustTotalWeight').val()) / parseFloat($('#formulaAdjustTotalWeight').data('original-weight'));

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('formulas/shipping-cost');?>',
                data: {
                    formula_id: formulaId,
                    ratio: ratio
                },
                success: function (data) {
                    // $('td#shipping-user').html('&#36;' + data);
                    $('#shipping_cost').val(data);
										if (discount == '.90') {
											var display_total = parseFloat(cost) * discount;
											var discount_amount = parseFloat(cost) * 0.10;
											$('#discount_amount').val(discount_amount.toFixed(2))
										} else {
											var display_total = parseFloat(cost);
											$('#discount_amount').val(0)
											
										}
										var real_total = display_total+parseFloat(data)
                    $('td#total-user').html('&#36;' + display_total.toFixed(2));
                    $('td#sub-total-user').html('&#36;' + parseFloat(cost).toFixed(2));
                    $('#real_sub_total').val(display_total.toFixed(2));
                    $('#real_formula_total').val(real_total.toFixed(2));
                    $('#display_sub_total').val(parseFloat(cost).toFixed(2));

                }
            });          
          }        
        }

    </script>
    <!-- END VIEW FILE -->
    
</div>
</div>
</div>
