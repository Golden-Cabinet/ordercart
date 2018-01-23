<div class='container-fluid'>
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <div class="dashboard-container">
          <div id="content">

              <div id="siteLogin">
                  <h2 class='dashboard-title'>Reset Password</h2>
                  <p>Enter your email address below and we will send you a link you can use to reset your password.</p>

                  <?php if ($message) { ?>
                    <div class="text-danger well">
                      <i class="fa fa-warning"></i> <?php echo $message; ?>
                    </div>
                  <?php } ?>
                  
                  <form id="loginForm" action="<?php echo base_url('/reset-password');?>" method="post">

                      <input class="username form-control" name="email" placeholder="Email" type="text" autofocus="autofocus"/>

                      <input id="signin" type="submit" class="btn btn-primary" value="Send Password Reset Link">


                  </form>
                  <br>
                  <p>
                    <a href="/login"><i class="fa fa-arrow-left"></i> Back to sign in</a>
                  </p>
              </div>

          </div>
      </div>
    </div>
  </div>
</div>