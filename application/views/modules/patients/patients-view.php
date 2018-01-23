<div>
		<div id="patient_view_upper">
    <h2 class="dashboard_headers dashboard-title"><?php echo $patient->firstName . ' ' . $patient->lastName; ?></h2>

    <?php if ($patient->deleted > 0): ?>
      <span class='inactive-label' title='This patient is inactive'>INACTIVE</span>
    <?php endif;?>
    
		<a href="<?php echo base_url('patients/edit') . "/$patient->id" ;?>" class="blue button edit_formula_button"> Edit Patient </a>
		<div class="clear"></div>
		<a href="mailto: <?php echo $patient->email; ?>" target="_blank"><?php echo $patient->email; ?></a><br />
		<a href="tel: (<?php echo $patient->area_code; ?>) <?php echo $patient->phone; ?>">(<?php echo $patient->area_code; ?>) <?php echo $patient->phone; ?></a>
		<br />
		<?php
		echo $patient->bstreetAddress . '<br />';
		echo $patient->bcity . ',' . $patient->bstate . ' ' . $patient->bzip . '<br />';
		?>
		
		</div>
		<div id="patient_view_lower">
		<h3 class="dashboard_headers">Prescriptions</h3>
		<a href="<?php echo base_url('store/orders/add/?patient_id=') . "$patient->id" ;?>" class="blue button order_formula_button"> Order formula for <?php echo $patient->firstName; ?> </a>
		<div class="clear"></div>
		<table id="patient-order-table" class="table table-bordered table-striped table-hover table-condensed">
			<thead>
			<tr>
				<th>Formula</th>
				<th>Date</th>
				<th>Status</th>
			</tr>
			</thead>
			<tbody>
<?php
			if ($patient->orders) {
			foreach($patient->orders as $order) {
?>
				<tr>
					<td>
						<a href="/store/orders/view/<?php echo $order->id; ?>"><?php echo $order->formulaName; ?></a>
					</td>
					<td>
						<a href="/store/orders/view/<?php echo $order->id; ?>"><?php echo $order->created_at; ?></a>
					</td>
					<td>
<?php 
						
						if($order->status == 0 ){
		            echo 'Processing';
		        }elseif($order->status == 1){
		            echo 'Ready For Pick up';
		        }elseif($order->status == 2){
		            echo 'Completed - Shipped';
		        }elseif($order->status == 3){
		            echo 'Completed - Picked up';
		        }elseif($order->status == 4){
		            echo 'Cancelled';
		        }
?>
					</td>
				</tr>
<?php	} }
?>
		</tbody>
		</table>
		
		</div>
		
		<script type="text/javascript">
			$('#patient-order-table').dataTable({ "iDisplayLength": 20, ordering:true, "lengthChange":false, "searching":false });
		
		</script>
</div>
