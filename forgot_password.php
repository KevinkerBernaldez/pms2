<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>SMCC - Forgot Password</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/smcc-logo.png">
	<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link
		href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
		rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
	<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/sweetalert/sweetalert.css" rel="stylesheet">

    <style>
        body {
            background-image: url('assets/img/background.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
	<!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body> 

	<main>
		<div class="container">

			<section
				class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

							<div class="card mb-3">

								<div class="card-body">
                                    <div class="d-flex justify-content-center py-4">
                                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                                        <img src="assets/img/smcc-logo.png" alt="">
                                        <span class="d-none d-lg-block">SMCC - Events</span>
                                    </a>
                                </div><!-- End Logo -->

									<div class="pb-2">
										<h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
										<p class="text-center small">Enter your username & password to login</p>
									</div>

									<form class="row g-3 needs-validation div_contact mb-2" novalidate id="login-form">
										<div class="col-12">
											<label for="username" class="form-label">Contact Number</label>
											<div class="input-group has-validation">
												<input type="text" name="contact_number" class="form-control"
													id="contact_number" maxlength="11" 
														onkeydown="return ( event.ctrlKey || event.altKey 
														|| (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
														|| (95<event.keyCode && event.keyCode<106)
														|| (event.keyCode==8) || (event.keyCode==9) 
														|| (event.keyCode>34 && event.keyCode<40) 
														|| (event.keyCode==46) )" required>
												<div class="invalid-feedback">Please enter your contact number.</div>
											</div>
										</div>

										<div class="col-12">
											<button class="btn btn-primary w-100 btn_contact" type="submit">Submit</button>
										</div>
									</form>

									<form class="row g-3 needs-validation div_otp mb-2" novalidate id="otp-form">
										<div class="col-12">
											<label for="username" class="form-label">OTP Number</label>
											<div class="input-group has-validation">
												<input type="text" name="otp_number" class="form-control"
													id="otp_number" maxlength="6" 
														onkeydown="return ( event.ctrlKey || event.altKey 
														|| (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
														|| (95<event.keyCode && event.keyCode<106)
														|| (event.keyCode==8) || (event.keyCode==9) 
														|| (event.keyCode>34 && event.keyCode<40) 
														|| (event.keyCode==46) )" required>
												<div class="invalid-feedback">Please enter your OTP number.</div>
											</div>
											<small>Please enter the OTP sent to your number</small>

										</div>
									
										<div class="col-12">
											<button class="btn btn-primary w-100 btn_otp" type="submit">Submit</button>
										</div>
									</form>

									<div class="col-12 text-center">
										<p class="small mb-0">Already have an account? <a href="index.php">Log in</a></p>
									</div>


								</div>
							</div>

						</div>
					</div>
				</div>

			</section>

		</div>
	</main><!-- End #main -->

	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a>

	<!-- Vendor JS Files -->
	<?php require_once('init.php'); ?>

	<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/chart.js/chart.min.js"></script>
	<script src="assets/vendor/echarts/echarts.min.js"></script>
	<script src="assets/vendor/quill/quill.min.js"></script>
	<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
	<script src="assets/vendor/tinymce/tinymce.min.js"></script>
	<script src="assets/vendor/php-email-form/validate.js"></script>

	<!-- Template Main JS File -->
	<script src="assets/js/main.js"></script>
	<script src="assets/css/sweetalert/sweetalert.min.js"></script>

	<script src="assets/js/jquery-3.1.1.min.js"></script>
</body>

</html>

<script> 

	function sendSMS(number, message) { 
        payload = {'to':number,'message': message};
        r = $.post('http://<?php echo ip_address; ?>:1688/services/api/messaging', params=payload);
        console.log("Message sent!");
    }

$(document).ready(function() {
	$(".div_otp").hide();
    
    $('#login-form').on('submit', function(event){ 
        event.preventDefault();
        const formData = {
            contact_number: $("#contact_number").val()
        };

		if (formData.contact_number == '') {
			return
		}
        const url = 'database/forgot_password/otp.php';
        
        $.post(url, formData, (response) => {
			const row = JSON.parse(response);
        
            if ($.trim(row.message) == 'success') {
				$(".div_contact").hide();
				$(".div_otp").show();
				sendSMS(formData.contact_number, "The OTP is " + row.otp);
            } 
            else { swal("System Message", row.message, "info"); }
        });
    });

	$('#otp-form').on('submit', function(event){ 
        event.preventDefault();
		
		const formData = {
            contact_number: $("#contact_number").val(),
            otp_number: $("#otp_number").val()
        };
        
		const url = 'database/forgot_password/reset_password.php';
        $.post(url, formData, (response) => {
			const row = JSON.parse(response);
			if ($.trim(row.message) == 'success') {
				sendSMS(formData.contact_number, "Your account password has been reset, this is your new password: " + row.password);
				window.location = "index.php";
            } 
            else { swal("System Message", row.message, "info"); }
        });
    });

});
</script>