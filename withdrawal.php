<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Withdrawal';
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
			<h1>Withdrawal</h1>
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
                                            <th>PR No.</th>
                                            <th>Item</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include('database/config.php');
                                            $role = $_SESSION["role"];
                                            $session_id = $_SESSION["id"];
                                            $query = mysqli_query($connection, "SELECT * FROM `withdrawal` w
                                                                                WHERE received_by_id = '$session_id'
                                                                                    ORDER BY date_entry DESC") or die(mysqli_error());
                                            while($row=mysqli_fetch_array($query)) {
                                                $id = $row['id'];
                                                $pr_no = $row['pr_no'];
                                                $item = $row['item'];
                                                $date = $row['date'];
                                                $received_date = $row['received_date'];
                                        ?>
                                            <tr id="<?php echo $id; ?>">
                                                <td data-target="pr_no"><?php echo $row['pr_no']; ?></td>
                                                <td data-target="item"><?php echo $row['item']; ?></td>
                                                <td data-target="date"><?php echo date("F j, Y", strtotime($date)); ?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <?php if (!$received_date) { ?>
                                                            <a class='btn btn-success btn-sm' data-role='approve' data-id="<?php echo $id; ?>" style="color: white;" title="Accept Request"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                        <?php } ?>
                                                        <a class='btn btn-warning btn-sm' data-role='generate' data-id="<?php echo $pr_no; ?>" data-userid="<?php echo $user_id; ?>" style="color: white;" title="Generate Slip"><i class="bi bi-file-earmark-ruled"> </i> </a>
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
	<?php include ('modal/logsheet.php'); ?>
    <!-- END ADD MODAL -->

    <!-- WITHDRAWAL MODAL -->
	<?php include ('modal/withdrawal.php'); ?>
    <!-- END WITHDRAWAL MODAL -->

    <!-- WITHDRAWAL SLIP MODAL -->
	<?php include ('modal/report/withdrawal_slip_report.php'); ?>
    <!-- END WITHDRAWAL SLIP MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/withdrawal.js"></script>
	<!-- End Scripts -->

    <script>
        $(document).ready(function(){
            var table = $('#example').DataTable({
                order: [[2, 'desc']],
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
                            url  : 'database/withdrawal/received.php',
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
