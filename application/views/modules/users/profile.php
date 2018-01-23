<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class="dashboard_container">

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

<div class="row">
  <div class="col-sm-12">
    <h3>Basic Information</h3>
  </div>
</div>

<!-- FIRST NAME -->
<div class="form-group">
    <?php echo form_label('First Name', 'firstName', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
      <?php echo form_input(array('name' => 'firstName', 'id' => 'firstName', 'required' => 'required', 'class'=>'form-control'), $user->firstName); ?>
    </div>
</div>

<!-- LAST NAME -->

<div class="form-group">
    <?php echo form_label('Last Name', 'lastName', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'lastName', 'id' => 'lastName', 'required' => 'required', 'class'=>'form-control'), $user->lastName); ?>
    </div>
</div>

<!-- EMAIL -->

<div class="form-group">
    <?php echo form_label('Email', 'email', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'email', 'id' => 'email', 'required' => 'required','class'=>'form-control'), $user->email); ?>
    </div>
</div>


<!-- BILLING -->
<div class="row">
  <div class="col-sm-12">
    <h3>Billing Address</h3>
  </div>
</div>

<div class="form-group">
  <?php echo form_label('Street', 'street', array('class' => 'col-sm-1 control-label')); ?>
  <div class="col-sm-11">
    <?php echo form_input(array('name' => 'bstreetAddress', 'id' => 'bstreetAddress','placeholder' => 'Street Address', 'class'=>'form-control'), $user->bstreetAddress); ?>
  </div>

  <?php echo form_label('City', 'bcity', array('class' => 'col-sm-1 control-label')); ?>
  <div class="col-sm-3">
    <?php echo form_input(array('name' => 'bcity', 'id' => 'bcity', 'class'=>'form-control', 'placeholder' => 'City'),  $user->bcity ); ?>    
  </div>

  <?php echo form_label('State', 'bstate', array('class' => 'col-sm-1 control-label')); ?>
  <div class="col-sm-2">
        <select name="bstate" class="form-control">
            <?php foreach ($states as $value): ?>
                <option value="<?php echo $value->id; ?>"<?php if ($user->bstate_id == $value->id) echo " selected"; ?>><?php echo $value->name; ?></option>
            <?php endforeach; ?>
        </select>    
  </div>

  <?php echo form_label('Zip', 'bzip', array('class' => 'col-sm-1 control-label')); ?>
  <div class="col-sm-4">
    <?php echo form_input(array('name' => 'bzip', 'id' => 'bzip','class' => 'form-control'), $user->bzip); ?>  
  </div>
  
</div>

  <!-- Check if billing + shipping are the same -->
  <div class="row">
    <div class="col-sm-12">
      <h3>Use billing as shipping address?</h3>
    </div>
  </div>
  <div class="form-group" id="shippingQ">
    <div class="col-sm-12">
      <div class="checkbox">
          <label class="radio-inline">
              <input type="radio" name="billShippingSame" id="optionsRadios1" value="yes" <?php if ($user->billingSameAsShipping == 'true') echo ' checked';?>>
              Yes
          </label>
          <label class="radio-inline">
              <input type="radio" name="billShippingSame" id="optionsRadios2" value="no" <?php if ($user->billingSameAsShipping == 'false') echo ' checked';?>>
              No
          </label>
      </div>
    </div>
  </div>

<!-- SHIPPING -->
<div id="shipping" <?php if ($user->billingSameAsShipping =='true') echo 'style="display:none" ';?>>
  <div class="row">
    <div class="col-sm-12">
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
              <?php foreach ($states as $value): ?>
                  <option value="<?php echo $value->id; ?>" <?php if ($user->shstate_id == $value->id) echo " selected";?>><?php echo $value->name; ?></option>
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
  <div class="row">
    <div class="col-sm-12">
      <h3>Phone</h3>
    </div>
  </div>


<div class="form-group">
  <?php echo form_label('Area Code', 'area_code', array('class' => 'col-sm-2 control-label')); ?>
  <div class="col-sm-2">
      <?php echo form_input(array('name' => 'area_code', 'id' => 'area_code', 'placeholder' => 'Area Code', 'class' => 'form-control input-sm','required' => 'required'), $user->area_code); ?>    
  </div>  
  <?php echo form_label('Phone', 'phone', array('class' => 'col-sm-1  control-label')); ?>
  <div class="col-sm-4">
  <?php echo form_input(array('name' => 'phone', 'id' => 'phone', 'class' => 'form-control input-sm','required' => 'required'), $user->phone); ?>    
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <h3>Additional Settings</h3>
  </div>
</div>


<!-- State of Licensure -->

<div class="form-group">
    <?php echo form_label('State of Licensure or School', 'license_state', array('class' => 'col-sm-4 control-label')); ?>
    <div class="col-sm-8">
      <div class="controls">
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
    
    <!-- User Role -->
    <?php echo form_label('User Role', 'role_id', array('class' => 'control-label col-sm-4')); ?>
    <div class="col-sm-8">
      <div class="controls">
          <select name="role_id" class='form-control'>
              <?php foreach ($roles as $value): ?>
                  <?php if ($user->role_id == $value->id): ?>
                      <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                  <?php else: ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                  <?php endif; ?>
              <?php endforeach; ?>
          </select>
      </div>
    </div>
    
    <!-- Status -->
    <?php echo form_label('Status', 'status', array('class' => 'control-label col-sm-4')); ?>
    <div class="col-sm-8">
      <div class="controls">
          <select name="status" class='form-control'>
              <?php foreach ($status as $key => $value): ?>
                  <?php if ($user->status == $value): ?>
                      <option value="<?php echo $value; ?>" selected><?php echo $key; ?></option>
                  <?php else: ?>
                      <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                  <?php endif; ?>
              <?php endforeach; ?>
          </select>
      </div>

    </div>
    
    <?php if ($mode == 'edit'): ?>
        <!-- Updated Password -->
        <div class="form-group" id="update_password">
            <?php echo form_label('Update Password', 'update_password', array('class' => 'control-label col-sm-4')); ?>
            <div class="col-sm-8">
              <div class="controls">
                  <label class="radio">
                      <input type="radio" name="update_password" id="update_password1" value="yes">
                      Yes
                  </label>
                  <label class="radio">
                      <input type="radio" name="update_password" id="update_password2" value="no" checked>
                      No
                  </label>
              </div>
            </div>
        </div>
    <?php endif; ?>
        
    <div class="password" <?php if ($mode == 'edit') echo "style='display:none"; ?>>
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

        
        

        <?php if ($mode == 'add'): ?>

            <div class="form-group" id="shippingQ">
                <?php echo form_label('Notify User', 'notify', array('class' => 'control-label col-sm-4')); ?>
                <div class="col-sm-8">
                  <div class="controls">
                      <label class="radio-inline">
                          <input type="radio" name="notify" value="yes">
                          Yes
                      </label>
                      <label class="radio-inline">
                          <input type="radio" name="notify" value="no" checked>
                          No
                      </label>

                      <p class="help">The user will be notified by email if yes is checked.</p>
                  </div>
                </div>
            </div>

        <?php endif; ?>

        </div>

        <?php
        
        if ($mode == 'edit') {
            echo form_hidden('billing_record_id', $user->bRecordID);
            echo form_hidden('shipping_record_id', $user->shRecordID);
            echo form_hidden('user_id', $user->id);
        }
        
        ?>
        
        <div class="form-group text-center">
            <div class="controls">
             	<a href="#"  onclick="showLeavePage('users'); return false;" class='btn btn-secondary'>Cancel</a>
    				 <?php echo form_submit(array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary')); ?>
     				</div>
        </div>
        
        
</div>
</div>



    <?php echo form_close();?>















		<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

    <script>
        $(document).ready(function () {
            $("input#optionsRadios2").click(function () {
                $("#shipping").show(600);
            });
            $("input#optionsRadios1").click(function () {
                $("#shipping").hide(600);
            });
        });

        $( '#password' ).focus(function() {
            $('#password').tooltip('show');
        });
    </script>

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