<!doctype html>
<?php $this->load->view($this->config->item('theme_header')); ?>
<body>

<div id="backend_container">
    <?php $this->load->view($this->config->item('theme_header_navigation')); ?>
    <div class="content">
        <?php
        $auth = new Authentication();
				if ($auth->is_logged_in() && $auth->is_admin()){
	            $this->load->view('themes/default/partials/admin-navigation');
	        } elseif ($auth->is_logged_in()) {
	            $this->load->view('themes/default/partials/user-navigation');
	        }
        ?>
        <!-- FULL WIDTH -->
        <!-- <div id  ="backend_content_wrapper"> -->
          <!-- <div id="container" class='page-content'> -->
            <div class="container-fluid">
            <div class='row'>
            <div class="col-xs-12">            
              <?php $this->load->view($content); ?>
            </div>
            </div>
            </div>
          <!-- </div> -->
        <!-- </div> -->
    </div>
    <?php $this->load->view($this->config->item('theme_footer')); ?>
</div>


</body>
</html>