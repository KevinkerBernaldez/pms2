<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Property History';
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
			<h1>All Property History</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-4">
                                <label class="form-label mt-4">Property In-Charge</label><span class="text-danger">*</span>
                                <select class="form-select" name="in_charge" required>
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
                            <br>
                            
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover inventory-table">
                                    <thead>
                                        <tr>
                                            <th>Item Category</th>
                                            <th>PR No.</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Action</th>
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

    <!-- ADD MODAL -->
	<?php include ('modal/history_record.php'); ?>
    <!-- END ADD MODAL -->
    
    <!-- VIEW ITEMS MODAL -->
	<?php include ('modal/view/items_history.php'); ?>
    <!-- END VIEW ITEMS MODAL -->

    <!-- INVENTORY REPORT MODAL -->
	<?php include ('modal/report/history_report.php'); ?>
    <!-- END INVENTORY REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/property_history.js"></script>
	<!-- End Scripts -->

    <script>
	    $(document).ready(function(){
            $('select[name="in_charge"]').on('change', function() {
                var in_charge = $(this).val();
                getData(in_charge);
            });
            
    		$('select[name="in_charge"]').trigger('change');
           
            function getData(id = null) {
                const url = 'database/inventory/get_inventory_by_id.php';
                // var showApproveBtn = (status == 'Pending') ? 'block' : 'none';
               
                var table = $('.inventory-table').DataTable();
                table.clear().draw();
                $.get(url, { id }, (response) => {
                    const rows = JSON.parse(response);

                    rows.forEach(row => {
                        table.row.add($(`<tr id="${row.id}">
                                            <td>${row.item_category}</td>
                                            <td>${row.pr_no}</td>
                                            <td>${row.description}</td>
                                            <td>${row.quantity}</td>
                                            <td>${row.unit}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-primary btn-sm' data-role='history' data-id="${row.id}" style="color: white;" title="Add History Record"><i class="bi bi-file-earmark-plus"> </i> </a>
                                                    <a class='btn btn-info btn-sm' data-role='items' data-id="${row.id}" style="color: white;" title="View Records"><i class="bi bi-binoculars"> </i> </a>
                                                    <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                </div>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }

            $('#history-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'database/history/submit.php',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                })
                .done(function(data) {
                    if ($.trim(data) === 'success') {
                        Swal.fire('System Message', 'Data saved successfully!', 'info').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('System Message', $.trim(data), 'info');
                    }
                });
            });

        });
    </script>
</body>

</html>
