<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Property Disposal Approval';
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
			<h1>Property Disposal Approval</h1>
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
                                <table id="example" class="table table-striped table-bordered table-hover disposable-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Department</th>
                                            <th>Category</th>
                                            <th>Items</th>
                                            <th>Comment</th>
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
	<?php include ('modal/view/items_disposal.php'); ?>
    <!-- END VIEW ITEMS MODAL -->

    <!-- DISPOSAL REPORT MODAL -->
    <?php include ('modal/report/disposal_report.php'); ?>
    <!-- END DISPOSAL REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/disposal.js"></script>
	<!-- End Scripts -->

    <script>
	    $(document).ready(function(){
            $('select[name="status"]').on('change', function() {
                var status = $(this).val();
                getData(status);
            });

    		$('select[name="status"]').trigger('change');
          
            function getData(status = null) {
                const url = 'database/disposal/for_approval.php';
                var showApproveBtn = (status == 'Pending') ? 'block' : 'none';
                const role = '<?php echo $_SESSION['role']; ?>';
               
                var table = $('.disposable-table').DataTable();
                table.clear().draw();
                $.get(url, { status }, (response) => {
                    const rows = JSON.parse(response);

                    rows.forEach(row => {
                        table.row.add($(`<tr id="${row.id}">
                                            <td>${moment(row.date).format('MMMM D, YYYY')}</td>
                                            <td>${row.department}</td>
                                            <td>${row.item_category}</td>
                                            <td>
                                                <a class='btn btn-primary btn-sm' data-role='items' data-userrole="${role}" data-status="${row.status}" data-id="${row.id}" style="color: white;" title="View Items"><i class="bi bi-binoculars"> </i> </a>
                                            </td>
                                            <td>${row.comment || '-'}</td>
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-success btn-sm' data-role='approve' data-id="${row.id}" style="color: white; display: ${showApproveBtn}" title="Approve Request"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                    <a class='btn btn-danger btn-sm' data-role='disapprove' data-id="${row.id}" style="color: white; display: ${showApproveBtn}" title="Disapprove Request"><i class="bi bi-hand-thumbs-down"> </i> </a>
                                                    <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                    <a class='btn btn-info btn-sm' data-role='open-pdf' data-id="${row.id}" href="uploads/incident_report/${row.file}" target="_blank" style="color: white;" title="Open File">
                                                        <i class="bi bi-file-earmark-pdf"> </i>
                                                    </a>
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
                            url  : 'database/disposal/approve.php',
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
            
            $(document).on('click', 'a[data-role=disapprove]', function() {
                var id = $(this).data('id');
                var email = $(this).data('email');  // Optional if email is needed
                const formData = { id: id, email: email };

                // Show SweetAlert2 input prompt for feedback
                Swal.fire({
                    title: "Feedback / Remarks",
                    text: "Please enter reason for disapproval:",
                    input: 'textarea',  // Using a textarea for multi-line input
                    showCancelButton: true,
                    inputPlaceholder: "Write something",
                    preConfirm: (inputValue) => {
                        // Check if the input is empty and prevent proceeding if it is
                        if (!inputValue) {
                            Swal.showValidationMessage("You need to write something!");
                            return false;
                        }
                        return inputValue;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user entered a reason, prepare the form data
                        formData.input_value = result.value;

                        // Show the loading state
                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Disapproving transaction...',
                            icon: 'info',
                            allowOutsideClick: false, // Prevent clicking outside to close
                            didOpen: () => {
                                Swal.showLoading(); // Show the loading spinner
                            }
                        });

                        // Send the disapproval request via $.post()
                        $.post('database/disposal/disapprove.php', formData, (response) => {
                            console.log(response);
                            if ($.trim(response) === 'success') {
                                Swal.fire({
                                    title: 'System Message',
                                    text: "The transaction has been disapproved successfully.",
                                    icon: 'success',
                                    confirmButtonText: "Okay"
                                }).then(() => location.reload()); // Reload the page after success
                            } else {
                                Swal.fire('Error', 'There was a problem disapproving the transaction.', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>
