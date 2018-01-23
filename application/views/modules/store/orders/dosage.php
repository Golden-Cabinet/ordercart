<h3>Dosage Information</h3>
<hr>
<div class="form-group">
    <?php echo form_label('Dosage Quantity', 'numberOfScoops', array('class' => 'control-label col-sm-3')); ?>
    <div class="col-sm-9">
        <select name="numberOfScoops" id="numberOfScoops" class="form-control">
            <option value="default">Choose...</option>
            <option value='As Directed (1 level scoop is 1.5g)'>As Directed (1 level scoop is 1.5g)</option>
            <option value='1 level scoop (1.5g)'>1 level scoop (1.5g)</option>
            <option value='1 slightly rounded scoop (2g)'>1 slightly rounded scoop (2g)</option>
            <option value='1 heaping scoop (2.5g)'>1 heaping scoop (2.5g)</option>
            <option value='2 level scoops (3g)'>2 level scoops (3g)</option>
            <option value='2 slightly rounded scoops (4g)'>2 slightly rounded scoops (4g)</option>
            <option value='3 level scoops (4.5g)'>3 level scoops (4.5g)</option>
            <option value='2 heaping scoops (5g)'>2 heaping scoops (5g)</option>
            <option value='4 level scoops (6g)'>4 level scoops (6g)</option>
            <option value='5 level scoops (7.5g)'>5 level scoops (7.5g)</option>
            <option value='4 slightly rounded scoops (8g)'>4 slightly rounded scoops (8g)</option>
            <option value='6 level scoops (9g)'>6 level scoops (9g)</option>
            <option value='4 heaping scoops (10g)'>4 heaping scoops (10g)</option>
            <option value='Other – add dosage in “Special Instructions” below'>Other – add dosage in “Special Instructions” below</option>
        </select>
    </div>
		<div class="order_validation_message_container" id="scoop_validation">
			Please choose the number of scoops.
		</div>
		<div class="clear"></div>
</div>

<div class="form-group">
    <?php echo form_label('Number Of Times/Day', 'timesPerDay', array('class' => 'control-label col-sm-3')); ?>
    <div class="col-sm-9">
      <select name="timesPerDay" id="timesPerDay" class="form-control">
          <option value="">Choose...</option>
          <option value='Once per day'>Once per day</option>
          <option value='Two times per day'>Two times per day</option>
          <option value='Three times per day'>Three times per day</option>
          <option value='Four times per day'>Four times per day</option>
          <option value='Five times per day'>Five times per day</option>
          <option value='As Needed'>As Needed</option>
          <option value='Other – add details in “Special Instructions” below'>Other – add details in “Special Instructions” below</option>
      </select>
    </div>
		<div class="order_validation_message_container" id="times_per_day_validation">
			Please choose the number of times per day.
		</div>
		<div class="clear"></div>
</div>


<div class="form-group">
    <?php echo form_label('Special Instructions', 'special_instructions', array('class' => 'control-label col-sm-3')); ?>
    <div class="col-sm-9">
        <?php echo form_textarea(array('name' => 'instructions', 'id' => 'special_instructions', 'class' => 'form-control'), set_value('special_instructions')); ?>
        <br>
    </div>
</div>

<div class="form-group">
    <?php echo form_label(' Number of refills allowed', 'refillNumber', array('class' => 'control-label col-sm-3')); ?>
    <div class="col-sm-9">
        <select name="refills" id="refills" class="form-control">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="unlimited">Unlimited</option> <!-- Change to -1 to indicate unlimited? -->
        </select>
    </div>
</div>

<div class="form-group text-center" style='clear:both'>
<br />
  <p><a class="header_highlighted_links btn btn-secondary" href="#" onclick="showLeavePage('orders'); return false;">Cancel</a>&nbsp;&nbsp;&nbsp;
    <a class="btn btn-primary blue"  onclick="orderAdvanceStep('shipping', 'dosage'); return false;">Shipping and Billing <i class="fa fa-arrow-right"></i></a></p>
<br />
</div>

<a href="#" onclick="reviewStep('patient'); return false;">&#8592;  Back to Patient/Formula</a><br />
<div class="order_navigation_warning">If you hit the "Back" button on your browser, the order will be cancelled.</div>


