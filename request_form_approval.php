<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Request Form Approval';
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
			<h1>Repair and Maintenance Request Form Approval</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label>Status </label>
                                    <select class="form-select" name="status" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                </div>
                            </div>

                            <br>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover request-table">
                                    <thead>
                                        <tr>
                                            <th>Request No.</th>
                                            <th>Type</th>
                                            <th>Department</th>
                                            <th>Date Requested</th>
                                            <th>Location</th>
                                            <th>Date of Action</th>
                                            <th>Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
			</div>
		</section>

	</main><!-- End #main -->
    
    <!-- REQUEST REPORT MODAL -->
	<?php include ('modal/report/request_report.php'); ?>
    <!-- END REQUEST REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/request_form.js"></script>
	<!-- End Scripts -->

    <script>
       
	    $(document).ready(function(){
            $('select[name="status"]').on('change', function() {
                var status = $(this).val();
                getData(status);
            });

    		$('select[name="status"]').trigger('change');
          
            function getData(status = null) {
                const url = 'database/request/for_approval.php';
                var showApproveBtn = (status == 'Pending') ? 'block' : 'none';
               
                var table = $('.request-table').DataTable();
                table.clear().draw();
                $.get(url, { status }, (response) => {
                    const rows = JSON.parse(response);
                    rows.forEach(row => {
                        table.row.add($(`<tr id="${row.id}">
                                            <td>${row.request_no ?? '-'}</td>
                                            <td>${row.request_type}</td>
                                            <td>${row.department}</td>
                                            <td>${moment(row.date_requested).format('MMMM D, YYYY')}</td>
                                            <td>${row.location}</td>
                                            <td>${row.date_action ? moment(row.date_action).format('MMMM D, YYYY') : '-'}</td>
                                            <td>${row.details}</td>
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-success btn-sm' data-role='approve' data-id="${row.id}" style="color: white; display: ${showApproveBtn}" title="Approve Request"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                    <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.request_no}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                </div>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }
            
            $(document).on('click', 'a[data-role=approve]', function(){
                var id = $(this).data('id');
                var role = '<?php echo $_SESSION['role']; ?>';
                // Assuming `role` is available and stores the user's role (e.g., 'Property Custodian' or something else)
                if (role === 'Property Custodian') {
                    // Show the SweetAlert with input fields for Property Custodians
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to approve this transaction. Please provide the request number and the date of action.",
                        icon: 'warning',
                        showCancelButton: true,  // Show the Cancel button
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,    // Reverses the buttons order
                        html: `
                            <input id="swal-input-request-no" class="swal2-input" placeholder="Enter Request No." autocomplete="off">
                            <input id="swal-input-date-action" class="swal2-input" placeholder="Enter Date of Action" type="date">
                        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            const requestNo = document.getElementById('swal-input-request-no').value;
                            const dateAction = document.getElementById('swal-input-date-action').value;

                            // Validate input fields
                            if (!requestNo || !dateAction) {
                                Swal.showValidationMessage('Please fill out both fields!');
                                return false;
                            }

                            return { requestNo, dateAction };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const { requestNo, dateAction } = result.value;  // Capture the user input

                            // Append the new fields to formData
                            var formData = new FormData();
                            formData.append("id", id);
                            formData.append("requestNo", requestNo);
                            formData.append("dateAction", dateAction);

                            $.ajax({
                                data: formData,  // Include the updated formData object
                                url: 'database/request/approve.php',
                                type: 'POST',
                                processData: false,  // Don't process the data (necessary for FormData)
                                contentType: false,  // Don't set content-type (also necessary for FormData)
                                beforeSend: function() {
                                    // console.log('loading');
                                },
                                complete: function() {
                                    // console.log('done');
                                },
                                success: function(response) {
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
                } else {
                    const formData = {
                        id: id
                    };
                    // For other roles, just show the confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to approve this transaction.",
                        icon: 'warning',
                        showCancelButton: true,  // Show the Cancel button
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true  // Reverses the buttons order
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                data: formData,  // Send formData as is (without the additional fields)
                                url: 'database/request/approve.php',
                                type: 'POST',
                                beforeSend: function() {
                                    console.log('loading');
                                },
                                complete: function() {
                                    console.log('done');
                                },
                                success: function(response) {
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
                }


            });

            
        });
    </script>
</body>

</html>
