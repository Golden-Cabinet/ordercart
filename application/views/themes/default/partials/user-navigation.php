<?php $auth = new Authentication();
			$location = $auth->uri->segments['1']; 
			if ($location == 'store') {
				if ($auth->uri->segments['2'] == 'orders' || $auth->uri->segments['2'] == 'categories') {
					$location = $auth->uri->segments['2'];
				}
			} elseif ($auth->uri->segments['1'] == 'settings') {
				$location = $auth->uri->segments['2'];
			}
			
?>

<div class="admin-nav">
    <ul class="nav nav-pills">
			<li class="dropdown <?php if ($location=='dashboard') {echo "admin_active";} else {echo "admin_inactive";} ?>">
				<a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
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

    </ul>
</div>