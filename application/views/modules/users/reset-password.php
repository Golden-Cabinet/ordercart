<div class='container-fluid'>
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <div class="dashboard-container">
          <div id="content">

              <div id="siteLogin">
                  <h2 class='dashboard-title'>Reset Password</h2>
                  <p>Please enter and confirm a <strong>new password</strong> for your account below:</p>

                  <?php if ($message) { ?>
                    <div class="text-danger well">
                      <i class="fa fa-warning"></i> <?php echo $message; ?>
                    </div>
                  <?php } ?>
                  
                  <form id="loginForm" action="" method="post">
                      <input class="username form-control" name="password" placeholder="New Password" type="password" autofocus="autofocus"/>
                      <input class="username form-control" name="passConf" placeholder="Confirm New Password" type="password" autofocus="autofocus"/>
                      <input id="signin" type="submit" class="btn btn-primary" value="Update Password">
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