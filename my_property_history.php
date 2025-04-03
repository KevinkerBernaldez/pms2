<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Inventory History';
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
			<h1>Inventory History</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
            var user_id = '<?php echo $_SESSION['id']; ?>';
            getData(user_id);
            
            function getData(id = null) {
                const url = 'database/inventory/get_inventory_by_id.php';
                var showApproveBtn = "";
               
                var table = $('.inventory-table').DataTable();
                table.clear().draw();
                $.get(url, { id }, (response) => {
                    const rows = JSON.parse(response);

                    rows.forEach(row => {
                        showApproveBtn = (row.history_status == 'FOR ACCEPTANCE') ? 'block' : 'none';
                
                        table.row.add($(`<tr id="${row.id}">
                                            <td>${row.item_category}</td>
                                            <td>${row.pr_no}</td>
                                            <td>${row.description}</td>
                                            <td>${row.quantity}</td>
                                            <td>${row.unit}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-success btn-sm' data-role='approve' data-id="${row.history_id}" style="color: white; display: ${showApproveBtn}" title="Accept"><i class="bi bi-hand-thumbs-up"> </i> </a>
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
                            url  : 'database/history/approve.php',
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
