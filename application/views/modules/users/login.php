<div class='container-fluid'>
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <div class="dashboard-container">
          <div id="content">

              <div id="siteLogin">
                  <h2 class='dashboard-title'>Practitioner Sign In</h2>
                  
                  <?php if ($message) { ?>
                    <div class="text-danger well">
                      <i class="fa fa-warning"></i> <?php echo $message; ?>
                    </div>
                  <?php } ?>
                  
                  
                  <form id="loginForm" action="/login" method="post">

                      <input class="username form-control" name="email" placeholder="Email" type="text" autofocus="autofocus"/>

                      <input class="password form-control" name="password" placeholder="Password" type="password"/>

                      <input id="signin" type="submit" class="btn btn-primary" value="Sign In">
                      <a href="/forgot-password" class="btn btn-secondary">I forgot my password</a>

                  </form>
          <br>
                  <p><span id="registerLink">Not signed up yet? <a href="<?php echo base_url('register');?>" class="registerLink">Register</a></span></p>

              </div>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="homepage_password_reset_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				  	<b>We've Reset Your Password</b>
          </div>
          <div class="modal-body" id="required_field_modal_content">
						You should be able to login with your new password now.
          </div>
        </div>
    </div>
</div>


<script>
(function(){
  var message = location.search.split("=")[1];  
  if (message == "registration_success") showHomepageModal('registration');
  if (message == "status_message") showHomepageModal('status');  
  if (message == "password_reset") showHomepageModal('password_reset');  
})();  
</script>