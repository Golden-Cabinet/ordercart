<!-- START VIEW FILE -->

    <?php if (isset($error_messages)): ?>
        <div class="well">
            <?php foreach ($error_messages as $message): ?>
                <p><?php echo $message; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

		<div id="formula_builder_left">

    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>

    <h3>Formula Name</h3>

		<input type="text" name="formula_name" value="<?php echo $formula->name; ?>" id="formula_name" class="input-xxxlarge" required="" onkeyup="checkFormulaName(<?php echo $formula->id; ?>);"  />
		<div class="clear"></div>
   	<div class="order_validation_message_container" id="formula_name_validation">
			A formula with this name already exists. Please modify the name.
		</div>

		<h3 class="dashboard_headers">Ingredients</h3>
    <br>    
    <p><a class="btn btn-primary add-product" href="#">Add Ingredient</a></p>
    
    
    
		<div class="clear"></div>
    <table id="formula-edit-table" class="table table-condensed">
        <thead>
        <th>Pinyin</th>
        <th>Grams</th>
        <th>$/Gram</th>
        <th>Subtotal</th>
        <th></th>
        <th></th>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($ingredients as $row):?>

            <tr class="ingredient-row" id="row_<?php echo $i; ?>">
                <td style="width:80%;">
                    <input type="text" class="ingredients input-xxxlarge" id="product_name" value="<?php echo $row->pinyin;?>" name="product_name_<?php echo $i; ?>" required="" data-original-title="Ingredient not found." data-content="Please try again." data-html="true"  data-placement="right">
                </td>
                <td class="pull-left">
                    <input type="text" class="input-mini formula_weight" value="<?php echo $row->weight;?>" name="weight_<?php echo $i; ?>" required="">
                </td>
				        <td class="">
									<input type="text" name="cost_per_gram_<?php echo $i;?>" value="<?php echo $row->costPerGram;?>" id="cost_per_gram_<?php echo $i;?>" class="input-mini" readonly="readonly">
								</td>
				        <td class="">
									<input type="text" class="formula_subtotal input-mini" name="subtotal_<?php echo $i;?>" value="<?php echo $row->costPerGram*$row->weight;?>" id="subtotal_<?php echo $i;?>" readonly="readonly">
								</td>
                <td>
                    <?php if($i > 1):?>
                    <a class="remove-row" href="#" rel="row_<?php echo $i; ?>"><i class="fa fa-remove remove-sign"></i></a>
                    <?php endif;?>
                </td>
                <td class="hidden"><input type="text" class="hidden" value="<?php echo $row->product_id; ?>" name="product_id_row_<?php echo $i; ?>" required=""></td>
            </tr>

        <?php
        $i++;
        endforeach;
        ?>
        </tbody>
    </table>
		<hr>
		<div id="formula_total_container" style="text-align: right; font-weight: bold;">
			Total: <span id="formula_total"></span>
		</div>
		
    <?php

    if ($mode == 'edit') {
        echo form_hidden('id', $formula->id);
    }
    ?>

            <?php echo form_submit(array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary')); ?>
						&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" onclick="showLeavePage('formulas'); return false;">Cancel</a>
						<?php if ($mode != 'add') { ?>
				    <a href="#" class="btn btn-danger pull-right delete_link" onclick="confirmDeleteFormula(); return false;">Delete formula</a>
						<?php } ?>
    <?php form_close(); ?>
	</div>
<!--	<div id="formula_builder_right">
		<h3>Summary</h3>
		<div id="formula_summary_container">
		</div>
	</div>
	<div class="clear"></div>
	<br /><br /> -->
	<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

	
	<div class="modal fade" id="delete_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
            <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					  	<b>Are you sure you want to delete <?php echo $formula->name; ?>?</b><br />
					<br />
          <!-- <b>You can not undo this.</b> -->
            </div>
	          <div class="modal-body" id="required_field_modal_content">
							<a href="/formulas/delete/<?php echo $formula->id; ?>" class="btn">Delete</a>
							<a href="#" data-dismiss="modal" aria-hidden="true">Cancel</a>
            </div>
	        </div>
	    </div>
	
	</div>
    <script>

        $(document).ready(function () {
	
						// fillSummaryTable(<?php echo $formula->id; ?>);

            var data = <?php echo $products;?>;
            var source = [];

		       for (var i=0;i < data.length; i++) {
		            var row = data[i];
		            source[i] = { label: row.label , value: row.value , id: row.id, brand: row.brand, concentration: row.concentration, cost_per_gram:row.cost_per_gram };
		        }
						

            $('input.ingredients').each(function() {
								$(this).autocomplete({
                minLength: 1,
                source: function (request, response) {
                    var results = $.ui.autocomplete.filter(source, request.term);
                    response(results);
                },
								autoFocus: true,
                select: function (event, ui) {
                  var selectedProduct = ui.item;
                  var tableRow = $(this).parent().parent();
                  var rowID = $(tableRow[0]).attr("id");
									var rowSplit = rowID.split('_');
									var rowIndex = rowSplit[1];
									var selector = "tr#" + rowID + " td:last-child";
                  $(selector).html('<input type="hidden" name="product_id_' + rowID + '" value="' + selectedProduct.id  + '">"');
                  var weightSelector = "tr#" + rowID + " td:nth-child(2) input";
                  $(weightSelector).attr('required', '');
									$('#cost_per_gram_'+rowIndex).val(ui.item.cost_per_gram)
									updateTotal();
									

                },
                change: function(event,ui)
                {
                    if (ui.item==null)
                    {
                        var tableRow = $(this).parent().parent();
                        var rowID = $(tableRow[0]).attr("id");
                        var selector = "tr#" + rowID + " input.ingredients";
                        $(selector).val('');
                        $(selector).trigger('focus');
                        setTimeout(function() { $(selector).focus(); }, 10);
                        $(selector).popover('show');
												updateTotal();

                    }
                }
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
						        return $( "<li></li>" ).data("item.autocomplete", item)
				            		.append( "<a><b>" + item.label + "</b> ("+ item.concentration +")<br><i>" + item.brand + "</i></a>")
						            .appendTo( ul );
						}
						});

            $('a.add-product').on('click', function (e) {

                e.preventDefault();

                var rowId = $('.ingredient-row').length + 1;

                $("#formula-edit-table tbody tr:last").after('<tr class="ingredient-row" id="row_' + rowId + '"><td><input class="ingredients input-xxxlarge" id="product_name_" type="text" name="product_name_' + rowId + '" data-original-title="Ingredient not found." data-content="Please try again." data-html="true"  data-placement="right"></td><td><input type="text" class="formula_weight input-mini" name="weight_' + rowId + '"</td><td class=""><input type="text" class="input-mini" name="cost_per_gram_'+rowId+'" value="" id="cost_per_gram_'+rowId+'" readonly="readonly"></td><td class=""><input type="text" class="formula_subtotal input-mini" name="subtotal_' + rowId + '" value="" id="subtotal_' + rowId + '" readonly="readonly"></td><td><a class="remove-row" href="#" rel="row_' + rowId + '"><i class="fa fa-remove remove-sign"></i></a></td><td class="hidden"></td></tr>');

            
								$('.formula_weight').change(function(e){
				          var tableRow = $(this).parent().parent();
				          var rowID = $(tableRow[0]).attr("id");
									var rowSplit = rowID.split('_');
									var rowIndex = rowSplit[1];
									var weight = $(this).val();
									var cost_per_gram = $('#cost_per_gram_'+rowIndex).val()
									var subtotal = (weight*cost_per_gram).toFixed(2)
									$('#subtotal_'+rowIndex).val(subtotal)
									updateTotal();

								})

                $('input.ingredients').each(function() {
										$(this).autocomplete({
                    minLength: 1,
                    source: function (request, response) {
                        var results = $.ui.autocomplete.filter(source, request.term);
                        response(results);
                    },
                    select: function (event, ui) {
	                    var selectedProduct = ui.item;
	                    var tableRow = $(this).parent().parent();
	                    var rowID = $(tableRow[0]).attr("id");
											var rowSplit = rowID.split('_');
											var rowIndex = rowSplit[1];
											var selector = "tr#" + rowID + " td:last-child";
	                    $(selector).html('<input type="hidden" name="product_id_' + rowID + '" value="' + selectedProduct.id  + '">"');
	                    var weightSelector = "tr#" + rowID + " td:nth-child(2) input";
	                    $(weightSelector).attr('required', '');
											$('#cost_per_gram_'+rowIndex).val(ui.item.cost_per_gram)
											updateTotal();

                    },
										autoFocus: true,

                    change: function(event,ui)
                    {
                        if (ui.item==null)
                        {
                            var tableRow = $(this).parent().parent();
                            var rowID = $(tableRow[0]).attr("id");
                            var selector = "tr#" + rowID + " input.ingredients";
                            $(selector).val('');
                            $(selector).trigger('focus');
                            setTimeout(function() { $(selector).focus(); }, 10);
                            $(selector).popover('show');
														updateTotal();

                        }
                    }
                }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
								        return $( "<li></li>" ).data("item.autocomplete", item)
						            		.append( "<a><b>" + item.label + "</b> ("+ item.concentration +")<br><i>" + item.brand + "</i></a>")
								            .appendTo( ul );
								}
								});


            });

						updateTotal();
						
            //remove row
            $(document).on('click', 'a.remove-row', function () {
                var rowId = $(this).attr('rel');
                $('#' + rowId).remove();
								updateTotal();

            });

            $(document).on('click',function(){
                $('div.popover').remove();
            });

						$('.formula_weight').change(function(e){
		          var tableRow = $(this).parent().parent();
		          var rowID = $(tableRow[0]).attr("id");
							var rowSplit = rowID.split('_');
							var rowIndex = rowSplit[1];
							var weight = $(this).val();
							var cost_per_gram = $('#cost_per_gram_'+rowIndex).val()
							var subtotal = (weight*cost_per_gram).toFixed(2)
							$('#subtotal_'+rowIndex).val(subtotal)
							updateTotal();
							

						})


        });

				function updateTotal() {
					var total = parseFloat(0);
					$('.formula_subtotal').each(function(){
						if ($(this).val()!='') {
							total = total+parseFloat($(this).val())
						}					})
					$('#formula_total').html('$'+total.toFixed(2))
				}
    </script>
    <!-- END VIEW FILE -->