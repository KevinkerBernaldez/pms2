<?php 
	require_once ('database/config.php');  
	$query = mysqli_query($connection, "SELECT 
											(SELECT COUNT(id) FROM `users`) AS `users`,
											(SELECT COUNT(id) FROM `technicians`) AS `technicians`;")
					or die(mysqli_error($connection));
	$row = mysqli_fetch_array($query);
	$users = $row['users'];
	$technicians = $row['technicians'];
?>

<div class="col-lg-12">
	<div class="row">

		<!-- Users Card -->
		<div class="col-xxl-3 col-md-6">
			<div class="card info-card sales-card">
				<div class="card-body">
					<h5 class="card-title">Users</h5>
					<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
						<i class="bi bi-people"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $users; ?></h6>
							<a href="users.php" class="badge bg-info text-white text-decoration-none small pt-1 fw-bold">Proceed to Users</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Technicians Card -->
		<div class="col-xxl-3 col-md-6">
			<div class="card info-card revenue-card">
				<div class="card-body">
					<h5 class="card-title">Technicians & Mechanic</h5>
					<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
						<i class="bi bi-people-fill"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $technicians; ?></h6>
							<a href="technicians.php" class="badge bg-success text-white text-decoration-none small pt-1 fw-bold">Proceed to Technicians</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>