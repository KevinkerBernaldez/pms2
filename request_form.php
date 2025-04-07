<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Request Form';
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
			<h1>Repair and Maintenance Request Form</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mt-3" title="Add Record" id="add">Add Request Form</button>
                            <div>&nbsp</div>

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
                                            <th>Date of Action</th>
                                            <th>Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include('database/config.php');
                                            $session_id = $_SESSION["id"];
                                            $query = mysqli_query($connection, "SELECT rf.*, d.department FROM `request_form` rf
                                                                                    JOIN departments d ON rf.department = d.id  
                                                                                    WHERE requested_by_id = '$session_id' ORDER BY date_entry DESC") or die(mysqli_error());
                                            while($row=mysqli_fetch_array($query)) {
                                                $id = $row['id'];
                                                $date_requested = $row['date_requested'];
                                                $date_action = $row['date_action'];
                                                $status = $row['status'];
                                        ?>
                                            <tr id="<?php echo $id; ?>">
                                                <td data-target="request_no"><?php echo $row['request_no']; ?></td>
                                                <td data-target="request_type"><?php echo $row['request_type']; ?></td>
                                                <td data-target="department"><?php echo $row['department']; ?></td>
                                                <td><?php echo date("F j, Y", strtotime($date_requested)); ?></td>
                                                <td data-target="location"><?php echo $row['location']; ?></td>
                                                <td><?php echo $date_action ? date("F j, Y", strtotime($date_action)) : "N/A"; ?></td>
                                                <td data-target="details"><?php echo $row['details']; ?></td>
                                                <td data-target="status"><span class="badge bg-<?php if ($status == 'APPROVED') echo 'success'; else echo 'info'; ?>"><?php echo $status; ?></span></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a class='btn btn-warning btn-sm' data-role='generate' data-id="<?php echo $row['request_no']; ?>" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                        <?php if ($row['status'] == 'FOR PROPERTY CUSTODIAN'): ?>
                                                            <a class='btn btn-danger btn-sm' data-role='cancel' data-id="<?php echo $row['id']; ?>" style="color: white;" title="Cancel"><i class="bi bi-x-circle"> </i> </a>
                                                        <?php endif; ?>
                                                        <?php if ($row['is_feedback'] == 'No'): ?>
                                                            <a class='btn btn-primary btn-sm' data-role='feedback' data-id="<?php echo $row['request_no']; ?>" style="color: white; " title="Create Feedback"><i class="bi bi-file-plus"> </i> </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

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

    <!-- ADD MODAL -->
	<?php include ('modal/request_form.php'); ?>
    <!-- END ADD MODAL -->

    <!-- FEEDBACK MODAL -->
	<?php include ('modal/feedback.php'); ?>
    <!-- END FEEDBACK MODAL -->

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
        function toggleOtherInput() {
            const otherInput = document.getElementById('otherInput');
            const othersRadio = document.getElementById('others');
            
            if (othersRadio.checked) {
                otherInput.readOnly = false;  // Make input editable when 'Others' is selected
                otherInput.value = '';        // Clear the input when 'Others' is selected
            } else {
                otherInput.readOnly = true;   // Make input readonly for other selections
                otherInput.value = '';        // Clear input value if not 'Others'
            }
        }

        function toggleOtherInput1() {
            const otherInput = document.getElementById('service_type_others');
            const othersRadio = document.getElementById('service-others');
            
            if (othersRadio.checked) {
                otherInput.readOnly = false;  // Make input editable when 'Others' is selected
                otherInput.value = '';        // Clear the input when 'Others' is selected
            } else {
                otherInput.readOnly = true;   // Make input readonly for other selections
                otherInput.value = '';        // Clear input value if not 'Others'
            }
        }

	    $(document).ready(function(){
            var table = $('#example').DataTable({
                order: [[0, 'desc']],
            });

            $(document).on('click', 'a[data-role=cancel]', function(){
                var id = $(this).data('id');
                const formData = {
                    id: id
                };

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to cancel this transaction.",
                    icon: 'warning',
                    showCancelButton: true,  // Show the Cancel button
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true      // Reverses the buttons order
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data : formData,
                            url  : 'database/request/cancel.php',
                            type : 'POST',
                            beforeSend: function(){
                                console.log('loading');
                            },
                            complete: function(){
                                console.log('done');
                            },
                            success: function(response){
                                if ($.trim(response) === 'success') {
                                    Swal.fire('System Message', 'Cancelled successfully!', 'success').then(() => {
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

            $(document).on('click', 'a[data-role=feedback]', function(){
                var id = $(this).data('id');

                $('input[name="request_no"]').val(id);
                $('#feedback-modal').modal('toggle');
            });
                
            $(document).on('click', '#add, #close', function(){
                $('#request-form').trigger("reset");
                $('#add-modal').modal('toggle');
            });

            $('#feedback-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'database/request/submit_feedback.php',
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

            $('#request-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'database/request/submit.php',
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
