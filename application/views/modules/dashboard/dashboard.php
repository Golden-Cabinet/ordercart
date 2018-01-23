<div class="row">
  <div class="col-xs-12">

	<div id="dashboard_orders_container" class="dashboard_container">		
    <div class='row'>
        <div class="col-xs-6">
		    	<h2 class="dashboard_headers dashboard-title"><a href="/store/orders/">Orders</a></h2>            
        </div>
        <div class="col-xs-6">
	        <a class="btn-primary btn-sm pull-right" href="<?php echo base_url('store/orders/add');?>">New Order</a>            
        </div>
    </div>
    
   	 <table class="table table-bordered table-striped table-hover table-condensed" id="order_table">
	        <thead>
	        <tr>
              <th>Order ID</th>
	            <th>Patient</th>
	            <th class="hidden-xs hidden-sm">Formula Name</th>
	            <th class="hidden-xs hidden-sm">Refills</th>
	            <th id="date-time">Date</th>
	            <th>Status</th>
	            <th>View</th>
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
	                <td><a href="/patients/view/<?php echo $value->patient_id; ?>"><?php echo $value->patientFirstName . ' ' . $value->patientLastName;?></a></td>
	                <td class="hidden-xs hidden-sm"><a href="/formulas/view/<?php echo $value->formula_id; ?>"><?php echo $value->formula_name;?></a></td>
	                <td class="hidden-xs hidden-sm"><?php echo $value->refills;?></td>
	                <td><?php echo $value->created_at;?></td>
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
	</div>
      
  </div>
</div>


	<div class="row">
	  <div class="col-xs-12 col-md-6">
    	<div id="dashboard_patients_container" class="dashboard_container">

    			<div class='row'>
              <div class="col-xs-6">
      		    	<h2 class="dashboard_headers dashboard_header_short"><a href="/patients/">Patients</a></h2>
              </div>
              <div class="col-xs-6">
      	        <a class="btn-primary  btn-sm  pull-right" href="<?php echo base_url('patients/add');?>">New Patient</a>            
              </div>
    	    </div>


        <table class="table table-bordered table-striped table-hover table-condensed" id="patient_table">
            <thead>
            <tr>
                <th>Patient</th>
                <th class="hidden-xs hidden-sm">Email</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($patients as $value):?>
                <tr>
                    <td><a href="/patients/view/<?php echo $value->id; ?>"><?php echo $value->firstName . ' ' . $value->lastName;?></a></td>
                    <td class="hidden-xs hidden-sm"><a href="mailto: <?php echo $value->email;?>"><?php echo $value->email;?></a></td>
                    <td><a href="<?php echo base_url('patients/edit') . '/' . $value->id;?>"><i class="fa fa-eye"></i></a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    	</div>	    
	  </div>
    
    <div class="col-xs-12 col-md-6">
    	<div id="dashboard_formulas_container" class="dashboard_container">

    		<div class='row'>
            <div class="col-xs-6">
    		    	<h2 class="dashboard_headers dashboard_header_short pull-left"><a href="/formulas/">Formulas</a></h2>
            </div>
            <div class="col-xs-6">
    	        <a class="btn-primary  btn-sm  pull-right" href="<?php echo base_url('formulas/build');?>">New Formula</a>
            </div>
        </div>
    
        <div class="row">
          <div class="col-xs-12">
    	    <table class="table table-bordered table-striped table-hover table-condensed" id="formula_table">
    	        <thead>
    	        <tr>
    	            <th>Formula Name</th>
    	        </tr>
    	        </thead>
    	        <tbody>
    	        <?php foreach($formulas as $value):?>
    	            <tr>
    	                <td><a href="/formulas/view/<?php echo $value->id; ?>"><?php echo $value->name; ?></a></td>
    	            </tr>
    	        <?php endforeach;?>
    	        </tbody>
    	    </table>
          </div>
        </div>   
         
    	</div>        
    </div>

	</div>



	<script type="text/javascript">  
    $(function(){
      $('.table').dataTable({ 
        iDisplayLength: 8, 
        ordering:true, 
        lengthChange:false,
        language: {
                search: "_INPUT_",
                zeroRecords: "Nothing to show"
            } 
        });
    
      $('#date-time').trigger('click')  
      $('input[type=search]').attr('placeholder', 'Search');    
    })
  </script>
