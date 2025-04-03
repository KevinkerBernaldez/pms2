<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

	<li class="nav-item">
		<a class="nav-link <?php if($title != 'Homepage') echo 'collapsed'; ?>" href="homepage.php">
			<i class="bi bi-house-fill"></i>
			<span>Homepage</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link <?php if($title != 'Dashboard') echo 'collapsed'; ?>" href="dashboard.php">
			<i class="bi bi-grid"></i>
			<span>Dashboard</span>
		</a>
	</li><!-- End Dashboard Nav -->

	<?php if($_SESSION['role'] == 'General Services') { ?> 
		<?php include ('menu/general_services.php'); ?>
	<?php } else if($_SESSION['role'] == 'PMO Head') { ?>
		<?php include ('menu/pmo.php'); ?>
	<?php } else if($_SESSION['role'] == 'Property Custodian') { ?>
		<?php include ('menu/property_custodian.php'); ?>
	<?php } else if($_SESSION['role'] == 'VP') { ?>
		<?php include ('menu/vp.php'); ?>
	<?php } else if($_SESSION['role'] == 'Administrator') { ?>
		<?php include ('menu/administrator.php'); ?>
	<?php } else if($_SESSION['role'] == 'Employee') { ?>
		<?php include ('menu/employee.php'); ?>
	<?php } ?>
</ul>

</aside>

