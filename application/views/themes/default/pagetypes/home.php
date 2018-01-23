<!doctype html>
<?php $this->load->view($this->config->item('theme_header')); ?>
<body>
    <div id="container">
        <?php $this->load->view($this->config->item('theme_header_navigation')); ?>
        <div id="content_wrapper">
            <?php
            // $auth = new Authentication();
            // if ($auth->is_logged_in() AND $auth->is_admin() ){
            //     $this->load->view('themes/default/partials/admin-navigation');
            // }elseif($auth->is_logged_in()){
            //     $this->load->view('themes/default/partials/user-navigation');
            // }
            ?>
            <?php $this->load->view($content); ?>
        </div>
		    <?php $this->load->view($this->config->item('theme_footer')); ?>
    </div>

</body>
</html>