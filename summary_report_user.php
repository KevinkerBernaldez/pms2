<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Summary Report - User';
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
			<h1>Summary Report - User</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label mt-4">Property In-Charge</label><span class="text-danger">*</span>
                                    <select class="form-select" name="user_in_charge" required>
                                        <option selected value="" disabled hidden>Select personnel</option>

                                        <?php 
                                            require_once('database/config.php');

                                            $query = "SELECT * FROM users WHERE `status` = 'Active';";
                                            $result = mysqli_query($connection, $query);
                                            while($row = mysqli_fetch_array($result)) {
                                                $id = $row['id'];
                                                $department_id = $row['department_id'];
                                                $name = $row['fname'].' '. $row['lname'];
                                        ?>
                                            <option value="<?php echo $id?>" data-id="<?php echo $department_id?>"><?php echo $name?></option>
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

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover report-table">
                                    <thead>
                                        <tr>
                                            <th>Inventory Date</th>
                                            <th>Last Inventory</th>
                                            <th>Property Code</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data"></tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->

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
    <script src="assets/js/report/summary_report.js"></script>
	<!-- End Scripts -->

    <script>
		document.getElementById('year').max = new Date().getFullYear();
		document.getElementById('year').value = new Date().getFullYear();

	    $(document).ready(function(){
            $('select[name="user_in_charge"], select[name="month"], input[name="year"]').on('change', function() {
                var in_charge = $('select[name="user_in_charge"]').val();
                var month = $('select[name="month"]').val();
                var year = $('input[name="year"]').val();

                getData(in_charge, month, year);
            });
            
    		// $('select[name="user_in_charge"]').trigger('change');
           
            function getData(in_charge, month, year) {
                const url = 'database/summary/get_property_inventory.php';

                var table = $('.report-table').DataTable();
                table.clear().draw();
                $.get(url, { in_charge, month, year }, (response) => {
                    const rows = JSON.parse(response);
                    rows.forEach(row => {
                        table.row.add($(`<tr id="${row.id}">
                                            <td>${moment(row.date_inventory).format('MMMM D, YYYY')}</td>
                                            <td>${moment(row.date_last).format('MMMM D, YYYY')}</td>
                                            <td>${row.property_code}</td>
                                            <td>${row.item_category}</td>
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }

        });
    </script>
</body>

</html>
