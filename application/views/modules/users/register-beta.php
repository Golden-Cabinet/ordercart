<div class='container-fluid'>
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <div class="dashboard-container">
  <br>      
    <h1 class='dashboard-title'>Register</h1>
    <hr>

    <?php if (isset($error_messages)):?>
       <div class="well">
          <?php foreach($error_messages as $message):?>
              <p><?php echo $message;?></p>
           <?php endforeach;?>
       </div>
    <?php endif;?>

<?php echo form_open($path, array('class' => 'form-horizontal')); ?>

<!-- FIRST NAME -->
<div class="form-group">
    <?php echo form_label('First Name', 'firstName', array('class' => 'control-label col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'firstName', 'id' => 'firstName', 'class' => 'form-control', 'required' => 'required'), $user->firstName); ?>
    </div>
</div>

<!-- LAST NAME -->

<div class="form-group">
    <?php echo form_label('Last Name', 'lastName', array('class' => 'control-label col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'lastName', 'id' => 'lastName', 'class' => 'form-control', 'required' => 'required'), $user->lastName); ?>
    </div>
</div>

<!-- EMAIL -->

<div class="form-group">
    <?php echo form_label('Email', 'email', array('class' => 'control-label col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'required' => 'required'), $user->email); ?>
    </div>
</div>

<!-- BILLING -->
  <div class="row">
    <div class="col-sm-12">
      <h3>Billing Address</h3>
    </div>
  </div>


<div class="form-group">
    <div class="controls">
        <?php echo form_label('Street', 'street', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-11">
        <?php echo form_input(array('name' => 'bstreetAddress', 'id' => 'bstreetAddress', 'class' =>'form-control', 'placeholder' => 'Street Address'), $user->bstreetAddress); ?>
        </div>
        <?php echo form_label('City', 'bcity', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-3">
        <?php echo form_input(array('name' => 'bcity', 'id' => 'bcity', 'class' => 'form-control', 'placeholder' => 'City'),  $user->bcity ); ?>
        </div>        
        <?php echo form_label('State', 'bstate', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-2">
          <select name="bstate" class="form-control">
         	<option value="" disabled selected>--</option>
              <?php foreach ($states as $value): ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
              <?php endforeach; ?>
          </select>
        </div>
        <?php echo form_label('Zip', 'bzip', array('class' => 'control-label col-sm-1')); ?>
        <div class="col-sm-4">
        <?php echo form_input(array('name' => 'bzip', 'id' => 'bzip', 'class' => 'form-control'), $user->bzip); ?>
        </div>
    </div>
</div>

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

<!-- SHIPPING -->
<div id="shipping" style="display:none" >
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
          <select name="bstate" class="form-control">
          	<option value="" disabled selected>--</option>
              <?php foreach ($states as $value): ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
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
    
    
     <div class="password">
          <div class="form-group">
              <!-- PASSWORD -->
              <?php echo form_label('Password', 'password', array('class' => 'control-label col-sm-4')); ?>
              <div class="col-sm-8">
                <div class="controls">
                    <?php echo form_password(array('name' => 'password', 'id' => 'password', 'class' => 'register', 'data-original-title' => $this->config->item('password_tooltip') , 'data-html' => 'true' , 'data-placement' => 'right')); ?>
                </div>
              </div>
              
              <!-- PASSWORD CONFIRM -->                
              <?php echo form_label('Password Confirmation', 'passConf', array('class' => 'control-label col-sm-4')); ?>
              <div class="col-sm-8">
                <div class="controls">
                    <?php echo form_password(array('name' => 'passConf', 'id' => 'passConf')); ?>
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


<div class="form-group">
    <div class="controls">
      
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <button
      class="g-recaptcha btn btn-primary"
      data-sitekey="6Lfr8BMUAAAAAL7i70m82IuCQzv1Q1wUnGpfE5QJ"
      data-callback="YourOnSubmitFn"
      data-badge="inline"
      >
      Finish Registration
      </button>

      <script>
      function YourOnSubmitFn(a,b,c) {
        document.forms[0].submit();
      }
      </script>
      
        <!-- <?php echo form_submit(array('type' => 'submit', 'value' => 'Submit', 'class' => 'btn')); ?> -->
   			<div class="order_navigation_warning">Once your registration is submitted you will receive a confirmation email with further instructions</div>
	 </div>

</div>

<?php form_close();?>

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
</div>      
      
    </div>
  </div>
    </div>