<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class='dashboard_container'>
      <h1 class='dashboard-title'>Profile</h1>
<hr>

<?php if (isset($error_messages)): ?>
    <div class="well">
        <?php foreach ($error_messages as $message): ?>
            <p><?php echo $message; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php echo form_open($path, array('class' => 'form-horizontal')); ?>

<!-- FIRST NAME -->
<div class="row">
  <div class="col-xs-12">
    <h3>Your Information</h3>
  </div>
</div>

<div class="form-group">
    <?php echo form_label('First Name', 'firstName', array('class' => 'control-label col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'firstName', 'id' => 'firstName', 'class' => 'form-control',  'required' => 'required'), $user->firstName); ?>
    </div>
</div>

<!-- LAST NAME -->

<div class="form-group">
    <?php echo form_label('Last Name', 'lastName', array('class' => 'control-label col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'lastName', 'id' => 'lastName', 'class' => 'form-control',  'required' => 'required'), $user->lastName); ?>
    </div>
</div>

<!-- EMAIL -->

<div class="form-group">
    <?php echo form_label('Email', 'email', array('class' => 'control-label col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control',  'required' => 'required'), $user->email); ?>
    </div>
</div>


<!-- BILLING -->
<div class="row">
  <div class="col-xs-12">
    <h3>Billing Address</h3>
  </div>
</div>


    <div class="controls">
        <div class="form-group">
          <?php echo form_label('Street', 'street', array('class' => 'control-label col-sm-1')); ?>
          <div class="col-sm-11">
          <?php echo form_input(array('name' => 'bstreetAddress', 'id' => 'bstreetAddress', 'class' => 'form-control', 'placeholder' => 'Street Address'), $user->bstreetAddress); ?>
          </div>
          <?php echo form_label('City', 'bcity', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-3">
          <?php echo form_input(array('name' => 'bcity', 'id' => 'bcity', 'class' => 'form-control', 'placeholder' => 'City'), $user->bcity); ?>
        </div>
        
        <?php echo form_label('State', 'bstate', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-2">
          <select name="bstate" class="form-control input-small">
              <?php foreach ($states as $value): ?>
                  <?php if ($user->license_state == $value->id): ?>
                      <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                  <?php else: ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                  <?php endif; ?>
              <?php endforeach; ?>
          </select>
        </div>

        <?php echo form_label('Zip', 'bzip', array('class' => 'control-label col-sm-1')); ?>        
        <div class="col-sm-4">
          <?php echo form_input(array('name' => 'bzip', 'id' => 'bzip', 'class' => 'form-control'), $user->bzip); ?>        
        </div>
        
        </div>
    </div>

<?php if ($mode == 'add'):?>
<div class="form-group" id="shippingQ">
    <?php echo form_label('Use billing as shipping address', 'shaddress', array('class' => 'control-label')); ?>
    <div class="controls">
        <label class="radio">
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
            Yes
        </label>
        <label class="radio">
            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
            No
        </label>
    </div>
</div>
<?php endif;?>

<!-- SHIPPING -->
    <div id="shipping" <?php if ($mode != 'edit') {?>style="display:none"<?php } ?>>
      <div class="row">
        <div class="col-xs-12">
          <h3>Shipping Address</h3>
        </div>
      </div>
      
    <div class="controls">
      <div class="form-group">
        <?php echo form_label('Street', 'shstreetAddress', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-11">
        <?php echo form_input(array('name' => 'shstreetAddress', 'id' => 'shstreetAddress', 'class' => 'form-control', 'placeholder' => 'Street Address'), $user->shstreetAddress); ?>
        </div>

        <?php echo form_label('City', 'shcity', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-3">
          <?php echo form_input(array('name' => 'shcity', 'id' => 'shcity', 'class' => 'form-control', 'placeholder' => 'City'), $user->shcity); ?>
        </div>
      
        <?php echo form_label('State', 'shstate', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-2">
          <select name="shstate" class="form-control input-small">
              <?php foreach ($states as $value): ?>
                  <?php if ($user->shstate_id == $value->id): ?>
                      <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                  <?php else: ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                  <?php endif; ?>
              <?php endforeach; ?>
          </select>
        </div>

        <?php echo form_label('Zip', 'shzip', array('class' => 'control-label col-sm-1')); ?>        
        <div class="col-sm-4">
          <?php echo form_input(array('name' => 'shzip', 'id' => 'shzip', 'class' => 'form-control'), $user->shzip); ?>        
        </div>      
      </div>
    </div>

<!-- PHONE -->

      <div class="row">
        <div class="col-xs-12">
          <h3>Phone</h3>
        </div>
      </div>

<div class="form-group">
    <div class="controls">
        <?php echo form_label('Area Code', 'area_code', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-2">
        <?php echo form_input(array('name' => 'area_code', 'id' => 'area_code', 'placeholder' => 'Area Code', 'class' => 'form-control'), $user->area_code); ?>
        </div>
        <?php echo form_label('Phone', 'phone', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-8">
        <?php echo form_input(array('name' => 'phone', 'id' => 'phone', 'class' => 'form-control'), $user->phone); ?>
        </div>
    </div>
</div>

      <div class="row">
        <div class="col-xs-12">
          <h3>Additional Information</h3>
        </div>
      </div>


<!-- State of Licensure -->
<div class="form-group">
    <?php echo form_label('State of Licensure', 'license_state', array('class' => 'control-label col-sm-3')); ?>
    <div class="col-sm-9">
        <select name="license_state" class='form-control'>
            <option value="" disabled selected>--</option>
            <?php foreach ($states as $value): ?>
                <?php if ($user->license_state == $value->id): ?>
                    <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                <?php else: ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<?php if ($mode == 'edit'): ?>
    <div class="form-group" id="update_password">
    <?php echo form_label('Update Password', 'update_password', array('class' => 'control-label col-sm-3')); ?>
    <div class="col-sm-9">
        <label class="radio-inline">
            <input type="radio" name="update_password" id="update_password1" value="yes">
            Yes
        </label>
        <label class="radio-inline">
            <input type="radio" name="update_password" id="update_password2" value="no" checked>
            No
        </label>
        </div>
    </div>

<?php endif; ?>


<div class="password" style="display:none;">
    <div class="form-group">
        <?php echo form_label('Password', 'password', array('class' => 'control-label col-md-4 col-xs-12')); ?>        
        <div class="col-md-8 col-xs-12">
            <?php echo form_password(array('name' => 'password', 'id' => 'password', 'class' => 'form-control register',  'data-original-title' => $this->config->item('password_tooltip') , 'data-html' => 'true' , 'data-placement' => 'right')); ?><br />
						Password must have at least eight characters, including 2 numbers, 2 uppercase letters and 2 lowercase letters.
        </div> 
        
    </div>

    <!-- PASSWORD CONFIRM -->
    <div class="form-group">
        <?php echo form_label('Password Confirmation', 'passConf', array('class' => 'control-label col-md-4 col-xs-12')); ?>
        <div class="col-md-8 col-xs-12">
            <div class="controls">
                <?php echo form_password(array('name' => 'passConf', 'id' => 'passConf', 'style' => 'width:80%')); ?>
            </div>
        </div>
    </div>
</div>


<?php
if ($mode == 'edit') {
    echo form_hidden('billing_record_id', $user->bRecordID);
    echo form_hidden('shipping_record_id', $user->shRecordID);
    echo form_hidden('user_id', $user->id);
}?>

<div class="form-group text-center">
    <div class="controls">
      <a href="#"  class='btn btn-secondary' onclick="showLeavePage('users'); return false;">Cancel</a>
      <?php echo form_submit(array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary blue')); ?>

    </div>
</div>
<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

<?php
if ($mode == 'add'):?>
<script>

    $( '#password' ).focus(function() {
        $('#password').tooltip('show');
    });
    $(document).ready(function () {
        $("input#optionsRadios2").click(function () {
            $("#shipping").show(600);
        });
        $("input#optionsRadios1").click(function () {
            $("#shipping").hide(600);
        });
    });
</script>
<?php endif;?>

<?php if ($mode == 'edit'): ?>

    <script>
        $(document).ready(function () {
            $("input#update_password1").click(function () {
                $(".password").show(600);
            });
            $("input#update_password2").click(function () {
                $(".password").hide(600);
            });
        });
    </script>

<?php endif; ?>

</div>
</div>
</div>