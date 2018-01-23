<div class="home_container" id="contact_container">
	<a id="contact"></a>
	<h1>CONTACT US</h1>
	<div id="contact_form_container">
	<p>
		<span class="home_emphasized" >HAVE QUESTIONS</span>&nbsp;&nbsp;about your formula, our products, our services, or Chinese medicine in general? Drop us a line. We’re always happy to help.
	</p>

		<p>
	    <?php if (isset($error_messages)):?>
	        <div class="contact_error_message_container">
	            <?php foreach($error_messages as $message):?>
	                <?php echo $message;?>
	            <?php endforeach;?>
	        </div>
	    <?php endif;?>

		</p>
		<p>
    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>
    <div class="form-group">
        <?php echo form_label('First Name', 'firstname', array('class' => 'control-label col-sm-2')); ?>
        <div class="col-sm-4">
            <?php echo form_input(array('name' => 'firstName', 'id' => 'firstName', "class" => 'form-control', 'required' => 'required'),$contact->firstName); ?>
        </div>
        <?php echo form_label('Last Name', 'lastName', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-4">
            <?php echo form_input(array('name' => 'lastName', 'id' => 'lastName', "class" => 'form-control', 'required' => 'required'),$contact->lastName); ?>
        </div>  
		</div>    
    <div class="form-group">
        <?php echo form_label('Email', 'email', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-4">
            <?php echo form_input(array('name' => 'email', 'id' => 'email', "class" => 'form-control',  'required' => 'required'),$contact->email); ?>
        </div>
        <?php echo form_label('Phone Number', 'phone', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-4">
            <?php echo form_input(array('name' => 'phone', 'id' => 'phone', "class" => 'form-control',  'required' => 'required'),$contact->phone); ?>
        </div>
    </div>


    <div class="form-group">
        <?php echo form_label('Message', 'question', array('class' => 'control-label col-sm-2')); ?>
        <div class="col-sm-10">
            <?php echo form_textarea(array('name' => 'question', 'id' => 'question', "class" => 'form-control', 'required' => 'required'),$contact->question); ?>
        </div>
    </div>

    <div class="form-group captcha-control">            
        <?php echo form_label('', 'captcha', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php // echo form_error('recaptcha_response_field'); ?>
            <?php // echo $captcha; ?>
        </div>
        <div id="contact_submit_container">
 
           <script src='https://www.google.com/recaptcha/api.js'></script>
            <button
            class="g-recaptcha large blue button push_right"
            data-sitekey="6Lfr8BMUAAAAAL7i70m82IuCQzv1Q1wUnGpfE5QJ"
            data-callback="YourOnSubmitFn"
            data-badge="inline"
            >
            Send
            </button>
      
            <script>
            function YourOnSubmitFn(a,b,c) {
              document.forms[0].submit();
            }
            </script>
            
        </div>
    </div>

    <?php echo form_close();?>
	</p>
	</div>
	<div class="clear"></div>
	
	<?php if (isset($contact_success)):?>
		<script type="text/javascript">alert('Thank you! Your message was successfully sent!')</script>
  <?php endif;?>
	
</div>
