<!-- START VIEW FILE -->
<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class="dashboard_container">      
    <h1 class='dashboard-title'><?php echo $title ;?></h1>
    <hr>

<div id="build_formula_container">




<?php if (isset($error_messages)): ?>
    <div class="well">
        <?php foreach ($error_messages as $message): ?>
            <p><?php echo $message; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>



<form action="/formulas/build" method="post" accept-charset="utf-8" class="form-horizontal">
  <div class="row">
    <div class="col-xs-12">
    <h3>Formula Name</h3>      
    </div>
  </div>

   	<input type="text" name="formula_name" value="" id="formula_name" class="form-control" required="" onkeyup="checkFormulaName(0);"  />
		<div class="order_validation_message_container" id="formula_name_validation">
			A formula with this name already exists. Please modify the name.
		</div>

  <div class="row">
    <div class="col-xs-12">
    <h3>Ingredients</h3>      
    </div>
  </div>


    <a class="new_button_right btn btn-primary blue add-product" href="#">Add Ingredient</a>
    
		<div class="clear"></div>
    <table id="formula-table" class="table table-condensed">
    <thead>
    <th>Pinyin</th>
    <th>Grams</th>
    <th>$/gram</th>
    <th>Subtotal</th>
    <th></th>
    <th></th>
    </thead>
    <tbody>
    <tr class="ingredient-row" id="row_1">
        <td style="width:80%;">
            <input type="text" name="product_name_1" value="" id="product_name" class="ingredients input-xxxlarge ui-autocomplete-input" data-original-title="Ingredient not found." data-content="Please try again." data-html="true"  data-placement="right" required="" autocomplete="off"></td>
        <td class="pull-left"><input type="text" class="input-mini formula_weight" name="weight_1" value="" id="weight" required=""></td>
        <td class=""><input type="text" name="cost_per_gram_1" value="" id="cost_per_gram_1" class="input-mini" readonly="readonly"></td>
        <td class=""><input type="text" class="formula_subtotal input-mini" name="subtotal_1" value="" id="subtotal_1" readonly="readonly"></td>
        <td class="hidden"></td>
        <td class="hidden"><input type="text" class="hidden" value="" required=""></td>
    </tr>
    <?php for($i = 2; $i <= 5; $i++):?>
    <tr class="ingredient-row" id="row_<?php echo $i;?>">
        <td style="width:80%;"><input type="text" name="product_name_<?php echo $i;?>" value="" id="product_name" class="ingredients input-xxxlarge ui-autocomplete-input"  autocomplete="off" data-original-title="Ingredient not found." data-content="Please try again." data-html="true"  data-placement="right"></td>
        <td class="pull-left"><input type="text" class="formula_weight input-mini" name="weight_<?php echo $i;?>" value="" id="weight"></td>
        <td class=""><input type="text" name="cost_per_gram_<?php echo $i;?>" value="" id="cost_per_gram_<?php echo $i;?>" class="input-mini" readonly="readonly"></td>
        <td class=""><input type="text" class="formula_subtotal input-mini" name="subtotal_<?php echo $i;?>" value="" id="subtotal_<?php echo $i;?>" readonly="readonly"></td>

        <td class="hidden"></td>
        <td><a class="remove-row" href="#" rel="row_<?php echo $i;?>"><i class="fa fa-remove remove-sign"></i></a></td>
        <td class="hidden"><input type="text" class="hidden" value=""></td>
    </tr>
    <?php endfor;?>
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


			<input type="submit" name="" id="save_formula_button" value="Save" class=" blue btn btn-primary"  />&nbsp;&nbsp;
			<a class="formula_cancel_link btn btn-secondary" href="#" onclick="showLeavePage('formulas'); return false;">Cancel</a>


<?php form_close(); ?>
</div>

</div>
</div>
</div>
<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

<script>

    $(document).ready(function () {

        $('a.remove-row').on('click',function(e){
            e.preventDefault();
            var rowId = $(this).attr('rel');
            $('#' + rowId).remove();
						updateTotal();

        });

        var data = <?php echo $products;?>;
        var source = [];

        for (var i=0;i < data.length; i++) {
            var row = data[i];
            source[i] = { label: row.label , value: row.value , id: row.id, brand: row.brand, concentration: row.concentration, cost_per_gram: row.cost_per_gram };
        }

        $('.ingredients').each(function() {
						$(this).autocomplete({
            minLength: 1,
            source: function(request, response) {
            var results = $.ui.autocomplete.filter(source, request.term);
            response(results);
        },
        select: function(event, ui){
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
				

        $('a.add-product').on('click', function (e) {

            e.preventDefault();

            var rowId = $('.ingredient-row').length + 1;

            $("tbody tr:last").after('<tr class="ingredient-row" id="row_' + rowId + '"><td><input class="ingredients input-xxxlarge" id="product_name_" type="text" name="product_name_' + rowId +'" data-original-title="Ingredient not found." data-content="Please try again." data-html="true"  data-placement="right"></td><td><input type="text" class="formula_weight input-mini" name="weight_' + rowId +'"></td><td class=""><input type="text" name="cost_per_gram_'+rowId+'" value="" id="cost_per_gram_'+rowId+'" class="input-mini" readonly="readonly"></td><td class=""><input type="text" class="formula_subtotal input-mini" name="subtotal_' + rowId + '" value="" id="subtotal_' + rowId + '" readonly="readonly"></td><td><a class="remove-row" href="#" rel="row_' + rowId + '"><i class="fa fa-remove remove-sign"></i></a></td><td class="hidden"></td></tr>');

						$('.formula_weight').change(function(e){
		          var tableRow = $(this).parent().parent();
		          var rowID = $(tableRow[0]).attr("id");
							var rowSplit = rowID.split('_');
							var rowIndex = rowSplit[1];
							var cost_per_gram = $('#cost_per_gram_'+rowIndex).val()
							var subtotal = (weight*cost_per_gram).toFixed(2)
							$('#subtotal_'+rowIndex).val(subtotal)
							updateTotal();
							

						})

            $('.ingredients').each(function () {
								$(this).autocomplete({
                minLength: 1,
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(source, request.term);
                    response(results);
                },
								autoFocus: true,

                select: function(event, ui){
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

        });

        //remove row
        $(document).on('click','a.remove-row',function(e){
            e.preventDefault();
            var rowId = $(this).attr('rel');
            $('#' + rowId).remove();
						updateTotal();

        });

        $(document).on('click',function(){
            $('div.popover').remove();
        });
        
        // Only allow numbers in this field
				$('.formula_weight').keypress(function(e){                    
          if ( !e.key.match(/[0-9]/) && !e.keyCode != 9 ) e.preventDefault();
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

				function updateTotal() {
					var total = parseFloat(0);
					$('.formula_subtotal').each(function(){
						if ($(this).val()!='') {
							total = total+parseFloat($(this).val())
						}
					})
					$('#formula_total').html('$'+total.toFixed(2))
				}

    });
</script>

<!-- END VIEW FILE -->
    
    