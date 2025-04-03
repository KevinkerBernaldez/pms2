<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Dashboard';
	include ('layout/header.php');
	if(!isset($_SESSION['id'])){ header("Location: index.php"); }
?>

<body>

	<!-- ======= Header ======= -->
	<?php include ('layout/navbar.php'); ?>
	<!-- End Header -->

	<!-- ======= Sidebar ======= -->
	<?php include ('layout/sidebar.php'); ?>
	<!-- End Sidebar-->

	<main id="main" class="main">

		<div class="pagetitle">
			<h1>Dashboard</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard">

			<?php if($_SESSION['role'] == 'General Services') { ?> 
				<?php include ('dashboard_general_services.php'); ?>
			<?php } else if($_SESSION['role'] == 'PMO Head') { ?>
				<?php include ('dashboard_pmo.php'); ?>
			<?php } else if($_SESSION['role'] == 'Property Custodian') { ?>
				<?php include ('dashboard_property_custodian.php'); ?>
			<?php } else if($_SESSION['role'] == 'VP') { ?>
				<?php include ('dashboard_vp.php'); ?>
			<?php } else if($_SESSION['role'] == 'Administrator') { ?>
				<?php include ('dashboard_administrator.php'); ?>
			<?php } else if($_SESSION['role'] == 'Employee') { ?>
				<?php include ('dashboard_employee.php'); ?>
			<?php } ?>
		
		</section>

	</main><!-- End #main -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
	<!-- End Scripts -->

</body>

</html>