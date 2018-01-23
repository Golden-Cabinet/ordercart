<h3>Patient Information</h3>
<hr>
<!-- Patient Information-->
<div class="form-group">
    <?php echo form_label('Patient', 'patient_id', array('class' => 'control-label col-sm-2' )); ?>
    <div class="col-sm-10">
    <select name="patient_id" id="patient_id" class="form-control">
						<option value="none">Choose a patient...</option>
        <?php 
				if (isset($_GET['patient_id'])) {
					$patient_id = $_GET['patient_id'];
				} else {
					$patient_id = 0;
				}
				foreach ($patients as $value): ?>
            <option value="<?php echo $value->id; ?>" <?php if ($patient_id == $value->id) {echo 'selected="selected"';} ?>><?php echo $value->firstName . ' ' . $value->lastName; ?></option>
        <?php endforeach; ?>
    </select>
        <div class="pull-right">
      		 &nbsp;&nbsp;or <a href="#" onclick="showLeavePage('patients/add'); return false;">Add a patient</a>&nbsp;&nbsp;<img class="link_icon" src="/assets/images/link_icon.gif">
         </div>
    </div>
		<div class="order_validation_message_container" id="patient_validation">
			Please choose a patient.
		</div>
</div>