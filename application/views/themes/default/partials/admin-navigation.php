<?php $auth = new Authentication();
			$location = $auth->uri->segments['1']; 
			if ($location == 'store') {
				if ($auth->uri->segments['2'] == 'orders' || $auth->uri->segments['2'] == 'categories' || $auth->uri->segments['2'] == 'brands') {
					$location = $auth->uri->segments['2'];
				}
			} elseif ($auth->uri->segments['1'] == 'settings') {
				$location = $auth->uri->segments['2'];
			}
			
?>
<div class="container-fluid admin-nav">
  <div class="row">
    <div class="col-xs-12">
      <ul class="nav nav-pills">
      		<li class="<?php if ($location=='dashboard') {echo "admin_active";} else {echo "admin_inactive";} ?>">
      			<a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
      		</li>
          <li class="<?php if ($location=='users') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('users'); ?>">
                  Users
              </a>
          </li>
          <li class="<?php if ($location=='patients') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('patients'); ?>">
                  Patients
              </a>
          </li>
          <li class="<?php if ($location=='orders') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('/store/orders'); ?>">
                  Orders
              </a>
          </li>
          <li class="<?php if ($location=='formulas') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('formulas'); ?>">
                  Formulas
              </a>
          </li>           
          <li class="<?php if ($location=='profile') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('profile'); ?>">
                  My Profile
              </a>
          </li>
          <li class="<?php if ($location=='categories') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('/store/categories'); ?>">
                  Categories
              </a>
          </li>
          <li class="<?php if ($location=='store') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('/store/products'); ?>">
                  Products
              </a>
          </li>
          <li class="<?php if ($location=='brands') {echo "admin_active";} else {echo "admin_inactive";} ?>">
              <a href="<?php echo base_url('/store/brands'); ?>">
                  Brands
              </a>
          </li>
          <li class="admin_blank">
          </li>
          <li class="admin_blank">
          </li>
          <li class="admin_blank">
          </li>
      </ul>

    </div>
  </div>
</div>