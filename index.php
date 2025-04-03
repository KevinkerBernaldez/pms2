<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SMCC - PMS</title>
	<!-- Bootstrap CSS -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/smcc-logo.png">
	<!-- <link href="assets/css/style.css" rel="stylesheet"> -->
	<link href="assets/css/sweetalert/sweetalert.css" rel="stylesheet">
	<!-- Optional custom CSS for styling -->
	<style>
		.login-container {
			height: 100vh;
		}
		.login-form {
			max-width: 400px;
			margin: auto;
		}
		/* Left side background color */
		.left-side {
			background-color: #f0f8ff; /* You can change this color */
			height: 100%;
		}
		.image-container {
			background: url('assets/img/login-bg.jpg') no-repeat center center;
			background-size: cover;
			height: 100%;
		}
	
		/* Custom styles for form inputs */
		.form-control {
			border-radius: 30px; /* Rounded corners */
			padding: 15px; /* Padding for larger input fields */
			font-size: 14px; /* Larger text */
			transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition on focus */
		}

		.form-control:focus {
			border-color: #007bff; /* Blue border on focus */
			box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); /* Subtle blue shadow */
		}

		.btn {
			border-radius: 30px; /* Rounded corners for the button */
			padding: 12px; /* Button padding */
			font-size: 16px; /* Button font size */
		}

		.form-group {
			margin-bottom: 20px; /* Space between input fields */
		}

		.form-label {
			font-weight: bold; /* Bold labels */
		}
	</style>

</head>

<body>

	<div class="container-fluid login-container d-flex">
		<!-- Left side: Form -->
		<div class="col-md-6 left-side d-flex align-items-center justify-content-center">
			<div class="login-form">
				<div class="d-flex justify-content-center py-2 mt-2">
					<img src="assets/img/smcc-logo.png" width="100" alt="">
				</div>
				<h3 class="text-center mb-4">Property Management System</h3>
				
				<form class="row g-3 needs-validation" novalidate id="login-form" autocomplete="off">
					<div class="col-12">
						<label for="username" class="form-label">Username</label>
						<div class="input-group has-validation">
							<input type="text" name="username" class="form-control"
								id="username" required>
							<div class="invalid-feedback">Please enter your username.</div>
						</div>
					</div>

					<div class="col-12">
						<label for="password" class="form-label">Password</label>
						<input type="password" name="password" class="form-control"
							id="password" required>
						<div class="invalid-feedback">Please enter your password!</div>
					</div>

					<div class="col-12">
						<button class="btn btn-primary w-100" type="submit">LOGIN</button>
					</div>
					<div class="col-12 text-center">
						<!-- <p class="small mb-0"><a href="forgot_password.php">Forgot Password?</a></p> -->
					</div>
				</form>
				
			</div>
		</div>

		<!-- Right side: Image -->
		<div class="col-md-6 image-container"></div>
	</div>

	<!-- Bootstrap JS and dependencies -->
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/css/sweetalert/sweetalert.min.js"></script>

	<script src="assets/js/jquery-3.1.1.min.js"></script>

</body>

</html>

<script> 
	$(document).ready(function() {
		
		$('#login-form').on('submit', function(event){ 
			event.preventDefault();
			const formData = {
				username: $("#username").val(),
				password: $("#password").val()
			};
			const url = 'database/login.php';
			
			$.get(url, formData, (response) => {
				if ($.trim(response) == 'success') {
					window.location = 'dashboard.php';
				} 
				else { swal("System Message", response, "info"); }
			});
		});

	});
</script>