<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Property Inventory';
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
			<h1>Property Inventory Approval</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
                                            <th>SY</th>
                                            <th>Items</th>
                                            <th>Status</th>
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

    <!-- VIEW ITEMS MODAL -->
	<?php include ('modal/view/items_inventory.php'); ?>
    <!-- END VIEW ITEMS MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/property_inventory.js"></script>
	<!-- End Scripts -->

    <script>
	    $(document).ready(function(){
            var user_id = '<?php echo $_SESSION['id']; ?>';
            getData(user_id);

            function getData(id = null) {
                const url = 'database/inventory/get_property_inventory_by_id.php';
                var showApproveBtn = "";
                var role = "<?php echo $_SESSION['role']; ?>";
                var sess_id = "<?php echo $_SESSION['id']; ?>";

                var table = $('.report-table').DataTable();
                table.clear().draw();
                $.get(url, { id }, (response) => {
                    const rows = JSON.parse(response);
                    rows.forEach(row => {
                        showApproveBtn = (row.status == 'FOR USER') ? 'block' : 'none';

                        table.row.add($(`<tr id="${row.id}">
                                            <td>${moment(row.date_inventory).format('MMMM D, YYYY')}</td>
                                            <td>${moment(row.date_last).format('MMMM D, YYYY')}</td>
                                            <td>${row.property_code}</td>
                                            <td>${row.item_category}</td>
                                            <td>${row.sy}</td>
                                            <td>
                                                 <a class='btn btn-primary btn-sm' data-role='items' data-id="${row.id}" style="color: white;" title="View Items"><i class="bi bi-binoculars"> </i> </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-success btn-sm' data-role='approve' data-id="${row.id}" style="color: white; display: ${showApproveBtn}" title="Approve Request"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                </div>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }

            $(document).on('click', 'a[data-role=approve]', function(){
                var id = $(this).data('id');
                const formData = {
                    id: id
                };

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to approve this transaction.",
                    icon: 'warning',
                    showCancelButton: true,  // Show the Cancel button
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true      // Reverses the buttons order
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data : formData,
                            url  : 'database/inventory/approve.php',
                            type : 'POST',
                            beforeSend: function(){
                                console.log('loading');
                            },
                            complete: function(){
                                console.log('done');
                            },
                            success: function(response){
                                if ($.trim(response) === 'success') {
                                    Swal.fire('System Message', 'Data saved successfully!', 'info').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('System Message', $.trim(response), 'info');
                                }
                            }
                        });
                    }
                });
                
            });

        });
    </script>
</body>

</html>
