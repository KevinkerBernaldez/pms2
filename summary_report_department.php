<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Summary Report - Department';
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
			<h1>Summary Report - Department</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label mt-4">Department</label><span class="text-danger">*</span>
                                    <select class="form-select" name="department" required>
                                        <option selected value="" disabled hidden>Select department</option>

                                        <?php 
                                            require_once('database/config.php');
                                            $query = "SELECT * FROM departments WHERE `status` = 'Active';";
                                            $result = mysqli_query($connection, $query);
                                            while($row = mysqli_fetch_array($result)) {
                                                $id = $row['id'];
                                                $department = $row['department'];
                                        ?>
                                            <option value="<?php echo $id?>"><?php echo $department?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mt-4">Select Month</label><span class="text-danger">*</span>
                                    <select class="form-select" name="month" required>
                                        <option selected value="" disabled hidden>Select Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label mt-4">Select Year</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" id="year" name="year" min="1950" autocomplete="off" required>
                                </div>

                                <div class="col-md-3">
                                    <br>
                                    <button type="button" class="btn btn-primary btnReport mt-4">Generate Report</button>
                                </div>
                            </div>
                            <br>

                        </div>
                    </div>
                </div>
			</div>
		</section>

	</main><!-- End #main -->

    <!-- INVENTORY REPORT MODAL -->
	<?php include ('modal/report/summary_report.php'); ?>
    <!-- END INVENTORY REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/summary_report_department.js"></script>
	<!-- End Scripts -->

    <script>
		document.getElementById('year').max = new Date().getFullYear();
		document.getElementById('year').value = new Date().getFullYear();

	    $(document).ready(function(){
        });
    </script>
</body>

</html>
