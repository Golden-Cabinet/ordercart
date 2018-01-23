<div class="home_container" id="home_title_container">
	<a id="home"></a>
	<?php $this->load->view('modules/pages/home-title'); ?>
</div>
<div class="home_quote_container">
	<div class="home_quote_inner">
		<div class="home_quote_container_left">
			<i>"I feel like I'm part of this amazing team that cares about what happens to me and takes my health and my well-being very personally.  Everyone at Golden Cabinet makes you feel welcome and relaxed and they're just so compassionate from the minute you walk in the door you feel like you just belong."</i>
		</div>
		<div class="home_quote_container_right">
			Leah Smith
		</div>
	</div>
</div>
		<div class="clear"></div>
</div>

<div class="modal fade" id="homepage_registration_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				  	<b>Your registration has been submitted successfully!</b>
          </div>
          <div class="modal-body" id="required_field_modal_content">
						Thank you for registering - you are almost ready to begin exploring your own personal Chinese Medicine Cabinet.  Please check your email for details on what to do next.  If you have any additional questions, you can call us at (503)233-4102.
          </div>
          
          
        </div>
    </div>
</div>


<div class="modal fade" id="homepage_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				  	<b>Sorry, your account is not yet activated</b>
          </div>
          <div class="modal-body" id="required_field_modal_content">
						Once you register, we will verify your credentials and will send you an email when your account has been approved.  Feel free to contact us at
						(503)233-4102 if you have any questions or if it has been longer than 1 business day since you submitted your registration.
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="homepage_password_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				  	<b>We've Sent a Password Reset Link</b>
          </div>
          <div class="modal-body" id="required_field_modal_content">
						Check your email and follow the link we sent you to reset your password.
          </div>
        </div>
    </div>
</div>


<script>
(function(){
  var message = location.search.split("=")[1];  
  if (message == "registration_success") showHomepageModal('registration');
  if (message == "status_message") showHomepageModal('status');  
  if (message == "reset_message") showHomepageModal('password_status');  
})();  
</script>