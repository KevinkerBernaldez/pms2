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
			<h1>Property Inventory</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mt-3" title="Add Record" id="add">Create Inventory Report</button>
                            <br>

                            <div class="col-md-4">
                                <label class="form-label mt-4">Property In-Charge</label><span class="text-danger">*</span>
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

    <!-- ADD MODAL -->
	<?php include ('modal/property_inventory.php'); ?>
    <!-- END ADD MODAL -->

    <!-- VIEW ITEMS MODAL -->
	<?php include ('modal/view/items_inventory.php'); ?>
    <!-- END VIEW ITEMS MODAL -->
    
    <!-- INVENTORY REPORT MODAL -->
	<?php include ('modal/report/inventory_report.php'); ?>
    <!-- END INVENTORY REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/property_inventory.js"></script>
	<!-- End Scripts -->

    <script>
	    $(document).ready(function(){
            $('select[name="user_in_charge"]').on('change', function() {
                var in_charge = $(this).val();
                getData(in_charge);
            });
            
    		$('select[name="user_in_charge"]').trigger('change');
           
            $(document).on('click', '#add, #close', function(){
                $('input[name="property_code"]').val('');
                $('input[name="date_inventory"]').val('');
                $('input[name="date_last_inventory"]').val('');
                $('input[name="sy"]').val('');
                $('select[name="in_charge"]').prop('selectedIndex', 0);
                $('select[name="category"]').prop('selectedIndex', 0);
                $('select[name="item_id"]').empty();

                $('#item-table tbody').empty();
                $('#add-modal').modal('toggle');
            });

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
                        showApproveBtn = (row.status == 'FOR USER' && row.in_charge_id == sess_id) ? 'block' : 'none';
                        showApproveBtn = (row.status == 'FOR PROPERTY CUSTODIAN' && role == 'Property Custodian') ? 'block' : 'none';

                        table.row.add($(`<tr id="${row.id}">
                                            <td>${moment(row.date_inventory).format('MMMM D, YYYY')}</td>
                                            <td>${moment(row.date_last).format('MMMM D, YYYY')}</td>
                                            <td>${row.property_code}</td>
                                            <td>${row.item_category}</td>
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
                                                    <a class='btn btn-primary btn-sm' data-role='approve' data-id="${row.id}" style="color: white; display: ${showApproveBtn}" title="Approve Request"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                    <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                </div>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }


            $('#btnSave').click(function() {
                var property_code = $('input[name="property_code"]').val();
                var date_inventory = $('input[name="date_inventory"]').val();
                var date_last_inventory = $('input[name="date_last_inventory"]').val();
                var sy = $('input[name="sy"]').val();
                var area = $('input[name="area"]').val();
                var in_charge_id = $('select[name="in_charge"] :selected').val();
                var in_charge = $('select[name="in_charge"] :selected').text();
                var department_id = $('select[name="in_charge"] :selected').data('id');
                var category = $('select[name="category"] :selected').val();
                var item_name = $('select[name="item_id"] :selected').text();

                var tableData = [];
                var emptyFieldFound = false; 
                $('#item-table tbody tr').each(function() {
                    var row = $(this);
                    var rowData = {
                        id: row.find('td').eq(0).text(),
                        quantity: row.find('td').eq(1).find('input').val(),
                        unit: row.find('td').eq(2).find('input').val(),
                        description: row.find('td').eq(3).find('input').val(),
                        brand: row.find('td').eq(4).find('input').val(),
                        part_code: row.find('td').eq(5).find('input').val(),
                        model_number: row.find('td').eq(6).find('input').val(),
                        serial_number: row.find('td').eq(7).find('input').val(),
                        status: row.find('td').eq(8).find('select').val(),
                        remarks: row.find('td').eq(9).find('input').val()
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
                    url: 'database/inventory/submit.php',  // The URL to your PHP API endpoint
                    type: 'POST',
                    contentType: 'application/json',  // Make sure to set the content type to JSON
                    data: JSON.stringify({
                        date_inventory: date_inventory,
                        date_last_inventory: date_last_inventory,
                        property_code: property_code,
                        department_id: department_id,
                        sy: sy,
                        area: area,
                        in_charge_id: in_charge_id,
                        in_charge: in_charge,
                        category: category,
                        item_name: item_name,
                        data: tableData  // The array is included as part of the JSON object
                    }),
                    success: function(response) {
                        console.log(response);
                        if ($.trim(response.status) === 'success') {
                            Swal.fire('System Message', 'Data saved successfully!', 'info').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('System Message', $.trim(data), 'info');
                        }
                        console.log('Response from server:', response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
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
