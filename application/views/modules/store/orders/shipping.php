<h3>Shipping / Pickup</h3>
<hr>
<div class="form-group" id="shippingQ">
    <div class="col-xs-12">
        <label class="radio-inline">
            <input type="radio" name="ship" id="ship1" value="1" checked>
            Ship
        </label>
        <label class="radio-inline">
            <input type="radio" name="ship" id="ship2" value="0">
            In Store pickup
        </label>
    </div>
</div>


<div id="pickup" class='form-group' style="display:none;clear:both">
    <br>
    <h3>Pick Up Options</h3>
    <hr>
    <div class="form-group">
        <?php echo form_label('Pick Up Options', 'pickUpOptions', array('class' => 'control-label')); ?>
        <div class="controls">
            <select name="howPickup" id="howPickup" class="form-control">
                <option value="patientPickup">Patient will pick up</option>
                <option value="personalPickup">I will pick up</option>
            </select>
        </div>
    </div>
</div>

<div id="shipping" class='form-group' style='clear:both'>
    <br>
    <h3>Shipping Options</h3>
    <hr>
    <div class="form-group">
        <?php echo form_label('Shipping Options', 'pickUpOptions', array('class' => 'control-label')); ?>
    <div class="controls">
        <select name="howShip" id="howShip" class="form-control" onchange="toggleOtherAddress(this.value); return false;">
            <option value="shipUserMailing">Ship formula to my mailing address</option>
            <option value="shipUserOther">Ship formula to me at another address</option>
            <option value="shipPatient">Ship formula to the Patients mailing address</option>
            <option value="shipPatientOther">Ship formula to the patient at another address</option>
        </select>
    </div>
    </div>
		<div id="shipping_other_address_container">
			<h3>Alternate Address</h3>
			<label for="other_address1">Street:</label> <input type="text" name='other_address1' id="other_address1"><br />
			<label for="other_city">City:</label> <input type="text" name='other_city' id="other_city"><br />
			<label for="other_state">State:</label> <input type="text" name='other_state' id="other_state"><br />
			<label for="other_zip">Zip:</label> <input type="text" name='other_zip' id="other_zip"><br />
		</div>
</div>
