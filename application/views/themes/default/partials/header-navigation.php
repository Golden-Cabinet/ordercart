<?php 
			$auth = new Authentication();
			$segments = $auth->uri->segments;
			if (array_key_exists('3',$segments)) {
				$segment_1 = $segments[1];
				$segment_2 = $segments[2];
				$segment_3 = $segments[3];
			} else {
				if (array_key_exists('1',$segments)) {
					$segment_1 = $segments[1];
				} else {
					$segment_1 = '';
				}
				if (array_key_exists('2',$segments)) {
					$segment_2 = $segments[2];
				} else {
					$segment_2 = '';
				}
				$segment_3 = '';
			}
?>
<div id="header_wrapper">
	<header>
    <nav class='hidden-xs hidden-sm'>			    
        <a href="<?php echo base_url(); ?>" id="logo"></a>
					<ul id="headerLinks">
                <!-- <li><a href="/">Home</a></li> -->
		            <li><a href="<?php echo base_url('about'); ?>">About Us</a></li>
		            <li><a href="<?php echo base_url('order'); ?>">Orders</a></li>
		            <li><a href="<?php echo base_url('contact'); ?>">Contact</a></li>
					      <li><a href="<?php echo base_url('location'); ?>" class="">Hours &amp; Location</a></li>
		            <li><a href="<?php echo base_url('faq'); ?>" class="">FAQ</a></li>
  	           	<?php if ($auth->is_logged_in()) { ?><li class=''><a href="<?php echo base_url('dashboard'); ?>" >My Cabinet</a></li>  <?php } ?>
					</ul>							
					<div id="logged_header">

            <?php
            if ($auth->is_logged_in()): ?>
            		<a class="header_highlighted_links" href="<?php echo base_url('policies'); ?>">Policies and Procedures</a> | 
                <a href="<?php echo base_url('logout'); ?>">Log out</a>
            <?php else: ?>
								Practitioners:
                 <a class="blue button" href="<?php echo base_url('login'); ?>">Sign In</a>
                <a class="header_highlighted_links" href="<?php echo base_url('register'); ?>">Sign Up</a>
            <?php endif; ?>

					</div>
	    </nav>

      
      <!-- Mobile navbar -->
      <nav class="navbar navbar-default hidden-md hidden-lg">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand text-hide" href="/">Golden Cabinets</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
	            <li><a href="<?php echo base_url('about'); ?>">About Us</a></li>
	            <li><a href="<?php echo base_url('order'); ?>">Orders</a></li>
	            <li><a href="<?php echo base_url('contact'); ?>">Contact</a></li>
				      <li><a href="<?php echo base_url('location'); ?>" class="">Hours &amp; Location</a></li>
	            <li><a href="<?php echo base_url('faq'); ?>" class="">FAQ</a></li>
              <?php if ($auth->is_logged_in()): ?>
  	           	<li><a href="<?php echo base_url('dashboard'); ?>" >My Cabinet</a></li>
            		<li><a href="<?php echo base_url('policies'); ?>">Policies and Procedures</a></li>
                <li><a href="<?php echo base_url('logout'); ?>">Log out</a></li>                
              <?php else: ?>
                <li><a href="<?php echo base_url('login'); ?>">Sign In</a></li>
                <li><a href="<?php echo base_url('register'); ?>">Sign Up</a></li>
              <?php endif; ?>
              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      
      
      
	</header>
</div>



