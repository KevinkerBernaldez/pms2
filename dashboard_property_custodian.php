<?php 
	require_once ('database/config.php');  
	$query = mysqli_query($connection, "SELECT 
											(SELECT COUNT(id) FROM `request_form` WHERE `status` = 'FOR PROPERTY CUSTODIAN') AS `request`,
											(SELECT COUNT(id) FROM `transfer_property` WHERE `status` = 'FOR PROPERTY CUSTODIAN') AS `transfer`,
											(SELECT COUNT(id) FROM `property_disposal` WHERE `status` = 'FOR PROPERTY CUSTODIAN') AS `disposal`;")
					or die(mysqli_error($connection));
	$row = mysqli_fetch_array($query);
	$request = $row['request'];
	$transfer = $row['transfer'];
	$disposal = $row['disposal'];
?>

<div class="col-lg-12">
	<div class="row">

		<!-- Request Card -->
		<div class="col-xxl-3 col-md-6">
			<div class="card info-card sales-card">
				<div class="card-body">
					<h5 class="card-title">Request Form <span>| Pending</span></h5>
					<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
						<i class="bi bi-hammer"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $request; ?></h6>
							<a href="request_form_approval.php" class="badge bg-info text-white text-decoration-none small pt-1 fw-bold">Proceed to Request</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Transfer Card -->
		<div class="col-xxl-3 col-md-6">
			<div class="card info-card revenue-card">
				<div class="card-body">
					<h5 class="card-title">Transfer Property <span>| Pending</span></h5>
					<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
						<i class="bi bi-send"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $transfer; ?></h6>
							<a href="transfer_property_approval.php" class="badge bg-success text-white text-decoration-none small pt-1 fw-bold">Proceed to Transfer</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Disposal Card -->
		<div class="col-xxl-3 col-md-6">
			<div class="card info-card customers-card">
				<div class="card-body">
					<h5 class="card-title">Property Disposal <span>| Pending</span></h5>
					<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
						<i class="bi bi-trash"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $disposal; ?></h6>
							<a href="property_disposal_approval.php" class="badge bg-warning text-white text-decoration-none small pt-1 fw-bold">Proceed to Disposal</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>