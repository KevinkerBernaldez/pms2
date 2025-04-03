<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Job Order';
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
			<h1>Job Order</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Request No.</th>
                                            <th>Type</th>
                                            <th>Department</th>
                                            <th>Date Requested</th>
                                            <th>Location</th>
                                            <th>Details</th>
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

    <!-- ADD MODAL -->
	<?php include ('modal/job_order.php'); ?>

    <!-- END ADD MODAL -->

    <!-- JOB ORDER REPORT MODAL -->
	<?php include ('modal/report/job_order_report.php'); ?>
    <!-- END JOB ORDER REPORT MODAL -->
    
    <!-- FEEDBACK REPORT MODAL -->
	<?php include ('modal/report/feedback_report.php'); ?>
    <!-- END FEEDBACK REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/job_order.js"></script>
    <script src="assets/js/report/feedback.js"></script>
	<!-- End Scripts -->

    <script>
        function updateRepairType() {
            // Get all selected checkboxes
            const selectedOptions = Array.from(document.querySelectorAll('input[name="maintenanceOptions"]:checked'))
                                        .map(checkbox => checkbox.value);
            
            // Join selected options with commas
            document.getElementById('repairType').value = selectedOptions.join(', ');
        }

        function updateTechName() {
            // Get the selected option from the dropdown
            const selectedOption = document.querySelector('select[name="technician"] option:checked');
    
            // Get the text content of the selected option (the technician's name)
            const technicianName = selectedOption ? selectedOption.textContent : '';
            
            // Set the technician name in the text input
            document.getElementById('techName').value = technicianName;
        }
        
	    $(document).ready(function(){
            getData();

            $(document).on('click', 'a[data-role=job_order]', function(){
                var id = $(this).data('id');

                $('input[name="request_no"]').val(id);
                $('#add-modal').modal('toggle');
            });

            function getData(status = null) {
                const url = 'database/job_order/get_job_order.php';
                var showApproveBtn = "";
                var showCreateBtn = "";
                var role = '<?php echo $_SESSION['role']; ?>';
               
                var table = $('.table').DataTable();
                table.clear().draw();
                $.get(url, { status }, (response) => {
                    const rows = JSON.parse(response);
                    rows.forEach(row => {
                        showApproveBtn = (row.status == 'FOR PMO') ? 'block' : 'none';
                        showCreateBtn = (row.with_job_order === 'No' && role === 'General Services') ? 'block' : 'none';

                        table.row.add($(`<tr id="${row.id}">
                                            <td>${row.request_no}</td>
                                            <td>${row.request_type}</td>
                                            <td>${row.department}</td>
                                            <td>${moment(row.date_requested).format('MMMM D, YYYY')}</td>
                                            <td>${row.location}</td>
                                            <td>${row.details}</td>
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-primary btn-sm' data-role='job_order' data-id="${row.request_no}" style="color: white; display: ${showCreateBtn}" title="Create Job Order"><i class="bi bi-file-plus"> </i> </a>
                                                    <a class='btn btn-success btn-sm' data-role='approve' data-id="${row.request_no}" style="color: white; display: ${showApproveBtn}" title="Approve Request"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                    <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.request_no}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                    <a class='btn btn-secondary btn-sm' data-role='feedback' data-id="${row.request_no}" style="color: white; " title="Generate Feedback"><i class="bi bi-rss"> </i> </a>
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
                            url  : 'database/job_order/approve.php',
                            type : 'POST',
                            beforeSend: function(){
                                console.log('loading');
                            },
                            complete: function(){
                                console.log('done');
                            },
                            success: function(response){
                                if ($.trim(response) === 'success') {
                                    Swal.fire('System Message', 'Data saved successfully!', 'success').then(() => {
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

            $('#job-order-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'database/job_order/submit.php',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                })
                .done(function(data) {
                    if ($.trim(data) === 'success') {
                        Swal.fire('System Message', 'Data saved successfully!', 'success').then(() => {
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
