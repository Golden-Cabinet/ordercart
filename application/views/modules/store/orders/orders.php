<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">

      <div class="row">
        <div class="col-xs-6">
        	<h2 class='dashboard-title'>Orders</h2>
        </div>
        <div class="col-xs-6">
          <div id="newuser">
      	     <a href="<?php echo base_url('store/orders/add');?>" id="new_order_button" class="btn-primary btn-sm pull-right">New Order</a>
          </div>
      		<div id="order_main_filters" class='pull-right'>
      			<input type="checkbox" id="order_filter_processing" class="order_table_filters" name="order_filter_processing" checked="checked" value="Processing"> <label for="order_filter_processing">Processing</label>&nbsp;&nbsp;
      			<input type="checkbox" id="order_filter_submitted" class="order_table_filters" name="order_filter_submitted" checked="checked" value="Ready"><label for="order_filter_submitted">Ready for Pick-up</label>&nbsp;&nbsp;			
      			<input type="checkbox" id="order_filter_filled" class="order_table_filters" name="order_filter_filled" checked="checked" value="Shipped"><label for="order_filter_filled">Shipped</label>&nbsp;&nbsp;
      			<input type="checkbox" id="order_filter_picked" class="order_table_filters" name="order_filter_picked" checked="checked" value="Picked"><label for="order_filter_picked">Picked up</label>&nbsp;&nbsp;
      			<input type="checkbox" id="order_filter_cancelled" class="order_table_filters" name="order_filter_cancelled" checked="checked" value="Cancelled"><label for="order_filter_cancelled">Cancelled</label>
      		</div>          
        </div>
      </div>

    <?php if(!empty($orders)):?>
        <table id="orders-table" class="table table-bordered table-striped table-hover table-condensed tablesorter">
            <thead>
            <tr>
                <th>Order Id</th>
                <th>Patient</th>
                <th>Formula Name</th>
                <th class="hidden-xs hidden-sm">Refills</th>
                <th id="date-time">Order Date</th>
                <th class="hidden-xs hidden-sm">Status</th>
                <th>View Order Details</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($orders as $value):?>
                <tr>
                    <td><?php echo $value->id; ?>
                    <?php if ($value->notes): ?>
                      <i class="fa fa-sticky-note"></i>
                    <?php endif;?>
                    </td>
                    <td>
                      <a href="/patients/view/<?php echo $value->patient_id; ?>"><?php echo $value->patientFirstName . ' ' . $value->patientLastName;?></a> <?php if ($value->patientDeleted > 0): ?><span class='inactive-label'>Inactive</span><?php endif; ?>
                    </td>                      
                    <td><a href="/formulas/view/<?php echo $value->formula_id; ?>"><?php echo $value->formulaName;?></a></td>
                    <td class="hidden-xs hidden-sm"><?php echo $value->refills;?></td>
                    <td class="hidden-xs hidden-sm"><?php echo $value->created_at;?></td>
                    <td><?php

												if($value->status == 0 ){
								            echo 'Processing';
								        }elseif($value->status == 1){
								            echo 'Ready For Pick up';
								        }elseif($value->status == 2){
								            echo 'Completed - Shipped';
								        }elseif($value->status == 3){
								            echo 'Completed - Picked up';
								        }elseif($value->status == 4){
								            echo 'Cancelled';
								        }
                        ?></td>
                    <td><a href="<?php echo base_url('store/orders/view') . '/' . $value->id;?>"><i class="fa fa-eye"></i></a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    <?php else:?>

        <table id="orders-table" class="table table-bordered table-striped table-hover table-condensed"><thead>
        <tr>
            <th>Patient</th>
            <th>Formula Name</th>
            <th>Refills</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>View Order Details</th>
        </tr>
        </thead>
				<tbody>
				</tbody>
        </table>

    <?php endif;?>

</div>

<div class="modal fade" id="order_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				  	<b>Thank you! Your order has been submitted successfully.</b>
          </div>
          <div class="modal-body" id="required_field_modal_content">
						An order confirmation email has been sent to <span id="confirmation_email"></span><br /><br />
						If you have any questions or need to change this order, please call (503) 233-4102 or <a href="/contact/">send us a message</a>
          </div>
        </div>
    </div>

</div>
</div>
</div>

<script>
    $(document).ready(function()
        {
					order_table = $('#orders-table').DataTable({ 
            "iDisplayLength": 10, 
            ordering:true, 
            "lengthChange":false, 
            "language": {
              search: "_INPUT_",
              zeroRecords: "Nothing to show"
				  } 
        });
					$('#date-time').trigger('click')
					$('#date-time').trigger('click')
        
        
        $('input[type=search]').attr('placeholder', 'Search');    
        
        }
    );


		<?php if (isset($_GET['order_success'])) { ?>
			showOrderConfirmation('<?php echo $_GET["email"]; ?>');
		<?php	}
		
		?>

		$('.order_table_filters').on( 'change', function () {
			
				search_values = ''
				count = 1
			
				$('.order_table_filters').each(function() {
					if ($(this).is(":checked")) {
						if (count == 1) {
							search_values = search_values+this.value
							count = 2
						} else {
							search_values = search_values+'|'+this.value
							count=count+1
						}
					}
				})
				
				if (count==1) {
					search_values = 'XXXX'
				} else {
					search_values = search_values+''
				}
			
		    order_table
		        .search( search_values, true, false )
		        .draw();
		} );
</script>
    