<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Department';
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
			<h1>Department</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item">Library</a></li>
					<li class="breadcrumb-item active">Department</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mt-3" title="Add Record" id="add">Add Department</button>
                            <div>&nbsp</div>

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Date Entry</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include('database/config.php');

                                            $query=mysqli_query($connection, "SELECT * FROM `departments` ORDER BY date_entry DESC")or die(mysqli_error());
                                            while($row=mysqli_fetch_array($query)) {
                                                $department_id = $row['id'];
                                                $department = $row['department'];
                                                $status = $row['status'];
                                                $date_entry = $row['date_entry'];
                                        ?>
                                            <tr id="<?php echo $department_id; ?>">
                                                <td data-target="department"><?php echo $department; ?></td>
                                                <td><?php echo date("F j, Y", strtotime($date_entry)); ?></td>
                                                <td data-target="status"><span class="badge bg-<?php if ($status == 'Active') echo 'success'; else echo 'danger'; ?>"><?php echo $status; ?></span></td>
                                                <td>
                                                    <div class="pt-0">
                                                        <a class='btn btn-primary btn-sm' data-role='edit' data-id="<?php echo $department_id; ?>" style="color: white;" title="Update Record"><i class="bi bi-pencil"> </i> </a>
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
    <div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Department Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="department-form" class="row g-3" autocomplete="off">
                        <input type="hidden" name="id">
                        <div class="col-12">
                            <label class="form-label">Department Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="department" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status<span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2">Submit</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- END ADD MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
	<!-- End Scripts -->

    <script>
        $(document).ready(function(){
            var table = $('#example').DataTable({
                order: [[1, 'desc']],
            });
        
            $(document).on('click', 'a[data-role=edit]', function(){
                var id = $(this).data('id');
                var department = $('#'+id).children('td[data-target=department]').text();
                var status = $('#'+id).children('td[data-target=status]').text();

                $('input[name="department"]').val(department);
                $('select[name="status"]').val(status).change();
                $('input[name="id"]').val(id);
                $('#add-modal').modal('toggle');
            });

            $(document).on('click', '#add, #close', function(){
                $('#department-form').trigger("reset");
                $('#add-modal').modal('toggle');
            });

            $('#department-form').submit(function(e){
                e.preventDefault();
                
                $.ajax({
                    url: 'database/department/submit.php',
                    data: new FormData($(this)[0]),
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false
                })
                .done(data => {
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
