<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Homepage';
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
			<h1>Homepage</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">

						<!-- Events Card -->
						<div class="col-xxl-12 col-md-12">
							<div class="card info-card sales-card shadow-lg rounded-3 border-0">

								<div class="card-body text-center p-3">
									<!-- Welcome Text with larger font size and bolder styling -->
									<h3 class="fw-bold text-primary mb-3">Welcome to</h3>
									<h4 class="fw-bold text-dark mb-3">Saint Michael College of Caraga</h4>
									<h5 class="lead text-muted">Property Management System</h5>
								</div>

							</div>
						</div>

						<div class="col-xxl-12 col-md-12">
							<!-- Second Card: Streamline Your Property -->
							<div class="card info-card sales-card shadow-lg rounded-3 border-0">
								<div class="card-body text-center p-3">
									<h3 class="fw-bold text-primary">Streamline Your Property, Elevate Your Management</h3>
								</div>
							</div>
						</div>

						<!-- End Events Card -->

						<!-- Recent Sales -->
						<div class="col-12">
							<div class="card recent-sales overflow-auto">

								<div class="card-body" style="padding-top: 20px; display: flex; justify-content: center; align-items: center; height: 100%;">
									<video controls width="640" height="360">
										<source src="assets/video/smcc.mp4" type="video/mp4">
										Your browser does not support the video tag.
									</video>
								</div>

							</div>
						</div>
						<!-- End Recent Sales -->

					
					</div>
				</div>

			</div>
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