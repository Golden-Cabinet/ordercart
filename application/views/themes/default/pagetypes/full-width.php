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
				<div id	="backend_content_wrapper">
        <?php $this->load->view($content); ?>
				</div>
    </div>
    <?php $this->load->view($this->config->item('theme_footer')); ?>
</div>


</body>
</html>