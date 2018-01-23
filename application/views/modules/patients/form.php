<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class="dashboard_container">
      
    <h1 class='dashboard-title'><?php echo $title ;?></h1>
    <hr>


<div>
	<div id="new_patient_form_container">

    <?php if (isset($error_messages)): ?>
        <div class="well">
            <?php foreach ($error_messages as $message): ?>
                <p><?php echo $message; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>
    
    <div class="row">
      <div class="col-xs-12">
        <h3>Patient Info</h3>
      </div>
    </div>
		

    <!-- FIRST NAME -->
    <div class="form-group">
        <?php echo form_label('First Name', 'firstName', array('class' => 'control-label col-sm-2')); ?>
        <div class="col-sm-10">
            <?php echo form_input(array('name' => 'firstName', 'id' => 'firstName', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'First Name'), $patient->firstName); ?>
        </div>
    </div>
    <div class="form-group">
    <!-- LAST NAME -->
        <?php echo form_label('Last Name', 'lastName', array('class' => 'control-label col-sm-2')); ?>
        <div class="col-sm-10">
            <?php echo form_input(array('name' => 'lastName', 'id' => 'lastName',  'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Last Name'), $patient->lastName); ?>
        </div>
    </div>
    <div class="form-group">
    <!-- EMAIL -->

        <?php echo form_label('Email', 'email', array('class' => 'control-label col-sm-2')); ?>
        <div class="col-sm-10">
            <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control',  'placeholder' => ''), $patient->email); ?>
        </div>
    </div>


    <div class="row">
      <div class="col-xs-12">
        <h3>Billing Address</h3>
      </div>
    </div>

    <!-- BILLING -->

    <div class="controls">
        <div class="form-group">
          <?php echo form_label('Street', 'street', array('class' => 'control-label col-sm-1')); ?>
          <div class="col-sm-11">
          <?php echo form_input(array('name' => 'bstreetAddress', 'id' => 'bstreetAddress', 'class' => 'form-control', 'placeholder' => 'Street Address'), $patient->bstreetAddress); ?>
          </div>
          <?php echo form_label('City', 'bcity', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-3">
          <?php echo form_input(array('name' => 'bcity', 'id' => 'bcity', 'class' => 'form-control', 'placeholder' => 'City'), $patient->bcity); ?>
        </div>
        
        <?php echo form_label('State', 'bstate', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-2">
          <select name="bstate" class="form-control input-small">            
              <option value="" disabled selected>Choose</option>
              <?php foreach ($states as $value): ?>
                <option value="<?php echo $value->id; ?>" <?php if ($patient->bstate_id == $value->id) echo "selected"; ?>><?php echo $value->name; ?></option>
              <?php endforeach; ?>
          </select>
        </div>

        <?php echo form_label('Zip', 'bzip', array('class' => 'control-label col-sm-1')); ?>        
        <div class="col-sm-4">
          <?php echo form_input(array('name' => 'bzip', 'id' => 'bzip', 'class' => 'form-control'), $patient->bzip); ?>        
        </div>
        
        </div>
    </div>

    <?php if ($mode == 'add'): ?>

  <div class="row">
    <div class="col-sm-12">
      <h3>Use billing as shipping address?</h3>
    </div>
  </div>

  <div class="form-group" id="shippingQ">
    <div class="col-sm-12">
      <div class="checkbox">
          <label class="radio-inline">
              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
              Yes
          </label>
          <label class="radio-inline">
              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
              No
          </label>
      </div>
    </div>
  </div>

    <?php endif; ?>

    <!-- SHIPPING -->

    <div id="shipping"   <?php if ($mode == 'add') { ?>style="display:none"<?php } ?>>
      <div class="row">
        <div class="col-xs-12">
          <h3>Shipping Address</h3>
        </div>
      </div>

      <div class="form-group">
        <?php echo form_label('Street', 'street', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-11">
          <?php echo form_input(array('name' => 'shstreetAddress', 'id' => 'shstreetAddress','placeholder' => 'Street Address', 'class'=>'form-control'), $user->shstreetAddress); ?>
        </div>

        <?php echo form_label('City', 'shcity', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-3">
          <?php echo form_input(array('name' => 'shcity', 'id' => 'shcity', 'class'=>'form-control', 'placeholder' => 'City'),  $user->shcity ); ?>    
        </div>  
        <?php echo form_label('State', 'shstate', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-2">
              <select name="shstate" class="form-control">
                <option value="" disabled selected>Choose</option>
                  <?php foreach ($states as $value): ?>
                      <option value="<?php echo $value->id; ?>"  <?php if ($patient->shstate_id == $value->id) echo "selected"; ?>><?php echo $value->name; ?></option>
                  <?php endforeach; ?>
              </select>    
        </div>
        <?php echo form_label('Zip', 'shzip', array('class' => 'col-sm-1 control-label')); ?>
        <div class="col-sm-4">
          <?php echo form_input(array('name' => 'shzip', 'id' => 'shzip','class' => 'form-control'), $user->shzip); ?>  
        </div>
      </div>  
 		
      </div>

        <!-- PHONE -->
		 		<h3>Phone</h3>

        <div class="form-group">
          <div class="controls">
          <label for="area_code" class="control-label col-sm-2">Area Code</label>
          <div class="col-sm-2">
          <?php echo form_input(array('name' => 'area_code', 'id' => 'area_code', 'placeholder' => 'Area Code', 'class' => 'form-control input-sm','required' => 'required'), $patient->area_code); ?>
          </div>

          <label for="area_code" class="control-label col-sm-1">Phone</label>
          <div class="col-sm-5">
          <?php echo form_input(array('name' => 'phone', 'id' => 'phone', 'class' => 'form-control input-sm', 'placeholder' => '###-####','required' => 'required'), $patient->phone); ?>
          </div>
         </div>
        </div>



        <?php if ($mode == 'edit') {
            echo form_hidden('billing_record_id', $patient->bRecordID);
            echo form_hidden('shipping_record_id', $patient->shRecordID);
            echo form_hidden('id', $patient->id);
        }
        ?>


        <div class="form-group text-center">
            <div class="controls">
                <?php echo form_submit(array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary blue')); ?>
								<a href="#" class='btn btn-secondary' onclick="showLeavePage('patients'); return false;">Cancel</a>
								<?php if ($mode != 'add') { ?>
                  <?php if ($patient->deleted == 0): ?>                            
  						    <a href="#" class="btn btn-danger pull-right delete_link" onclick="confirmDeletePatient(); return false;">Make Patient Inactive</a>
                  <?php else: ?>
  						    <a href="#" class="btn btn-danger pull-right delete_link" onclick="confirmReactivatePatient(); return false;">Reactivate Patient</a>                    
                  <?php endif; ?>
								<?php } ?>
            </div>
        </div>
      </div>
    </div>

        <?php form_close(); ?>
	</div>
	
	<div class="modal fade" id="delete_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
            <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					  	<b>Are you sure you want to <strong>deactivate</strong> <?php echo $patient->lastName . ' ' . $patient->firstName; ?>?</b><br />
          <!-- <br /> -->
          <!-- <b>You cannot automatically undo this.</b> -->
            </div>
	          <div class="modal-body" id="required_field_modal_content">
							<a href="/patients/delete/<?php echo $patient->id; ?>" class="btn">Deactivate</a>
							<a href="#" data-dismiss="modal" aria-hidden="true">Cancel</a>
            </div>
	        </div>
	    </div>	
	</div>

	<div class="modal fade" id="reactivate_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
            <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					  	<b>Are you sure you want to <strong>reactivate</strong> <?php echo $patient->lastName . ' ' . $patient->firstName; ?>?</b>
            </div>
	          <div class="modal-body" id="required_field_modal_content">
							<a href="/patients/reactivate/<?php echo $patient->id; ?>" class="btn">Reactivate</a>
							<a href="#" data-dismiss="modal" aria-hidden="true">Cancel</a>
            </div>
	        </div>
	    </div>	
	</div>

	<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

        <?php if ($mode == 'add'): ?>
        <script>
            $(document).ready(function () {
                $("input#optionsRadios2").click(function () {
                    $("#shipping").show(600);
                    // $('input[name=shstate]').attr('required','required');
                });
                $("input#optionsRadios1").click(function () {
                    $("#shipping").hide(600);
                   //  $('input[name=shstate]').attr('required',false);
                });
                
            });
        </script>
<?php endif; ?>


  </div>
</div>
</div>