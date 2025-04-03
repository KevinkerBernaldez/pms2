<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
    if($_GET['form'] == 'Profile' || $_GET['form'] == 'Password') { 
	    $title = $_GET['form'];
    } else {
        header("Location: index.php");
    }
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
			<h1>Profile</h1>
		</div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="uploads/profile/<?php echo $_SESSION["avatar"]; ?>" alt="Profile" class="rounded-circle">
                        <h2><?php echo $_SESSION["fname"].' '.$_SESSION["lname"]; ?></h2>
                        <h3><?php echo $_SESSION["role"]; ?></h3>
                    </div>
                </div>

                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link <?php if($title == 'Profile') echo 'active'; ?>" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link <?php if($title == 'Password') echo 'active'; ?>" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade <?php if($title == 'Profile') echo 'show active'; ?> profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form id="profile-form" autocomplete="off">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="uploads/profile/<?php echo $_SESSION['avatar']; ?>" alt="Profile">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fname" type="text" class="form-control" required value="<?php echo $_SESSION["fname"]; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="lname" type="text" class="form-control" required value="<?php echo $_SESSION["lname"]; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">Picture</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="file" accept="image/png, image/jpg, image/jpeg" name="file" class="form-control">
                                            <small>Note: Leave this blank if you don't want to change the picture.</small>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                            <div class="tab-pane fade <?php if($title == 'Password') echo 'show active'; ?> pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                                <form id="change-pass-form" autocomplete="off">

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="old_password" type="password" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="new_password" type="password" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="confirm_password" type="password" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                        </div>
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

    <script>
        $(document).ready(function(){
            
            $('#profile-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'database/profile/submit.php',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                })
                .done(function(response) {
                    if ($.trim(response) === 'success') {
                        Swal.fire('System Message', 'Data saved successfully!', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('System Message', $.trim(response), 'info');
                    }
                });

            });

        });

        $('#change-pass-form').submit(function(e){
            e.preventDefault();

            const formData = {
                old_password: $("#old_password").val(),
                new_password: $("#new_password").val(),
                confirm_password: $("#confirm_password").val()
            };
            const url = 'database/profile/change_password.php';

            if (formData.new_password == formData.confirm_password) {
                $.post(url, formData, (response) => {
                    if ($.trim(response) === 'success') {
                        Swal.fire('System Message', 'Data saved successfully!', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('System Message', $.trim(response), 'info');
                    }
                });
            }
            else {
                Swal.fire('System Message', "New and Confirm password does not match!", 'info');
            }
        });

    </script>
</body>

</html>
