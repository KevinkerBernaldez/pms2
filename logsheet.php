<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Logsheet';
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
			<h1>Received and Issued Items Logsheet</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mt-3" title="Add Record" id="add">Add Logsheet</button>
                            <div>&nbsp</div>

                            <div class="row">
                                
                                <div class="col-md-3">
                                    <label>Property In-Charge </label>
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

                                <div class="col-md-3">
                                    <label>Category </label>
                                    <select class="form-select" name="category" required>
                                        <option value="Construction Materials">Construction Materials</option>
                                        <option value="Office Supplies">Office Supplies</option>
                                        <option value="Spareparts">Spareparts</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label>From Year: </label>
                                    <input type="number" class="form-control" id="fromYear" name="fromYear" min="1900" required>
                                </div>

                                <div class="col-md-2">
                                    <label>To Year: </label>
                                    <input type="number" class="form-control" id="toYear" name="toYear" min="1900" required>
                                </div>

                                <div class="col-md-2">
                                    <br>
                                    <button type="button" class="btn btn-primary btnReport">Generate Report</button>
                                </div>
                            </div>

                            <br>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>PR No.</th>
                                            <th>Category</th>
                                            <th>Date of Purchase</th>
                                            <th style="display: none;">User ID</th>
                                            <th>Widthdrawn By</th>
                                            <th>Signed?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include('database/config.php');
                                            $role = $_SESSION["role"];
                                            $session_id = $_SESSION["id"];
                                            $query = mysqli_query($connection, "SELECT l.*, u.fname, u.lname FROM `logsheet` l
                                                                                    JOIN users u ON l.user_id = u.id 
                                                                                    GROUP BY pr_no
                                                                                    ORDER BY date_entry DESC") or die(mysqli_error());
                                            while($row=mysqli_fetch_array($query)) {
                                                $id = $row['id'];
                                                $pr_no = $row['pr_no'];
                                                $date_purchase = $row['date_purchase'];
                                                $user_name = $row['fname'] . ' ' . $row['lname'];
                                                $is_signed = $row['is_signed'];
                                                $user_id = $row['user_id'];
                                        ?>
                                            <tr id="<?php echo $id; ?>">
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <?php if ($is_signed == 'No') { ?>
                                                            <a class='btn btn-info btn-sm' data-role='withdrawal' data-id="<?php echo $id; ?>" data-prno="<?php echo $pr_no; ?>" data-userid="<?php echo $user_id; ?>" data-name="<?php echo $user_name; ?>" style="color: white;" title="Create Slip"><i class="bi bi-basket"> </i> </a>
                                                        <?php } else { ?>
                                                            <a class='btn btn-warning btn-sm' data-role='generate' data-id="<?php echo $pr_no; ?>" data-userid="<?php echo $user_id; ?>" style="color: white;" title="Generate Slip"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td data-target="pr_no"><?php echo $row['pr_no']; ?></td>
                                                <td data-target="item_category"><?php echo $row['item_category']; ?></td>
                                                <td data-target="date_purchase"><?php echo date("F j, Y", strtotime($date_purchase)); ?></td>
                                                <td data-target="user_id" style="display: none;"><?php echo $user_id; ?></td>
                                                <td data-target="user_name"><?php echo $user_name; ?></td>
                                                <td data-target="status"><span class="badge bg-<?php if ($is_signed == 'Yes') echo 'success'; else echo 'danger'; ?>"><?php echo $row['is_signed']; ?></span></td>
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

    <!-- LOGSHEET REPORT MODAL -->
	<?php include ('modal/report/logsheet_report.php'); ?>
    <!-- END LOGSHEET REPORT MODAL -->

    <!-- WITHDRAWAL SLIP MODAL -->
	<?php include ('modal/report/withdrawal_slip_report.php'); ?>
    <!-- END WITHDRAWAL SLIP MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/logsheet.js"></script>
    <script src="assets/js/report/withdrawal.js"></script>
	<!-- End Scripts -->

    <script>
		document.getElementById('fromYear').max = new Date().getFullYear();
		document.getElementById('fromYear').value = new Date().getFullYear();

		document.getElementById('toYear').max = new Date().getFullYear();
		document.getElementById('toYear').value = new Date().getFullYear();

        $(document).ready(function(){
            var table = $('#example').DataTable({
                order: [[2, 'desc']],
            });

            $(document).on('click', 'a[data-role=withdrawal]', function(){
                var id = $(this).data('prno');
                var user_id = $(this).data('userid');
                var user_name = $(this).data('name');
                $('input[name="id"]').val(id);
                $('input[name="user_id"]').val(user_id);
                $('input[name="user_name"]').val(user_name);
                $('#withdrawal-modal').modal('toggle');
            });
            
            $(document).on('click', 'a[data-role=edit]', function(){
                var id = $(this).data('id');
                var row = $('#'+id);
    
                var data = {
                    pr_no: row.children('td[data-target=pr_no]').text(),
                    item_category: row.children('td[data-target=item_category]').text(),
                    date_purchase: new Date(row.children('td[data-target=date_purchase]').text()).toLocaleDateString('en-CA'),
                    quantity_received: row.children('td[data-target=quantity_received]').text(),
                    unit: row.children('td[data-target=unit]').text(),
                    description: row.children('td[data-target=description]').text(),
                    date_released: new Date(row.children('td[data-target=date_released]').text()).toLocaleDateString('en-CA'),
                    ws_no: row.children('td[data-target=ws_no]').text(),
                    quantity_released: row.children('td[data-target=quantity_released]').text(),
                    user_id: row.children('td[data-target=user_id]').text()
                };
                
                $("input[name='item_category'][value='" + data.item_category + "']").prop("checked", true);
                $('input[name="pr_no"]').val(data.pr_no);
                $('input[name="date_purchase"]').val(data.date_purchase);
                $('input[name="quantity_received"]').val(data.quantity_received);
                $('input[name="unit"]').val(data.unit);
                $('input[name="description"]').val(data.description);
                $('input[name="date_released"]').val(data.date_released);
                $('input[name="ws_no"]').val(data.ws_no);
                $('input[name="quantity_released"]').val(data.quantity_released);
                $('select[name="user_id"]').val(data.user_id).change();

                $('input[name="id"]').val(id);
                $('#add-modal').modal('toggle');
            });

            $(document).on('click', '#add, #close', function(){
                $('#logsheet-form').trigger("reset");
                $('#add-modal').modal('toggle');
            });
            
            $('#withdrawal-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'database/withdrawal/submit.php',
                    data: new FormData($(this)[0]),
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false
                })
                .done(data => {
                    if ($.trim(data) === 'success') {
                        Swal.fire('System Message', 'Data saved successfully!', 'info').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('System Message', $.trim(data), 'info');
                    }
                });

            });

            $('#btnSave').click(function() {
                var pr_no = $('input[name="pr_no"]').val();
                var date_purchase = $('input[name="date_purchase"]').val();
                var category = $("input[name='item_category']:checked").val();
                var user_id = $('select[name="user_id"] :selected').val();
                console.log(pr_no, date_purchase, category);

                var tableData = [];
                var emptyFieldFound = false; 
                $('#item-table tbody tr').each(function() {
                    var row = $(this);
                    var rowData = {
                        id: row.find('td').eq(0).text(),
                        quantity_received: row.find('td').eq(1).find('input').val(),
                        unit: row.find('td').eq(2).find('input').val(),
                        description: row.find('td').eq(3).find('input').val(),
                        date_released: row.find('td').eq(4).find('input').val(),
                        ws_no: row.find('td').eq(5).find('input').val(),
                        quantity_released: row.find('td').eq(6).find('input').val(),
                    };

                    // Check if any field in the row is empty
                    for (var key in rowData) {
                        if (rowData[key] == "") {
                            Swal.fire("System Message", "Please fill in all fields in the row!", "info");
                            emptyFieldFound = true;
                            return // Exit the loop if any field is empty
                        }
                    }
                    tableData.push(rowData);
                });

                if (emptyFieldFound) {
                    return;  
                }

                if (tableData.length === 0) {
                    Swal.fire("System Message", "Please add something!", "info");
                    return;
                }

                $.ajax({
                    url: 'database/logsheet/submit.php',  // The URL to your PHP API endpoint
                    type: 'POST',
                    contentType: 'application/json',  // Make sure to set the content type to JSON
                    data: JSON.stringify({
                        pr_no: pr_no,
                        category: category,
                        date_purchase: date_purchase,
                        user_id: user_id,
                        data: tableData  // The array is included as part of the JSON object
                    }),
                    success: function(response) {
                        const data = JSON.parse(response);
                        if($.trim(data.status) == 'success') {
                            Swal.fire('System Message', 'Data saved successfully!', 'info').then(() => {
                                location.reload();
                            });
                        }
                        else {
                            Swal.fire("System Message", data.message, "info");
                        }
                        // console.log('Response from server:', response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });

            });

        });

    </script>
</body>

</html>
