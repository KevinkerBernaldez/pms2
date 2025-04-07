<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Transfer Property';
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
			<h1>Transfer Property</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mt-3" title="Add Record" id="add">Add Transfer</button>
                            <div>&nbsp</div>
                            <br>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered table-hover report-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Move From</th>
                                            <th>Move To</th>
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

    <!-- ADD MODAL -->
	<?php include ('modal/transfer.php'); ?>
    <!-- END ADD MODAL -->

    <!-- EDIT MODAL -->
	<?php include ('modal/view/edit_items_transfer.php'); ?>
    <!-- END EDIT MODAL -->

    <!-- VIEW ITEMS MODAL -->
	<?php include ('modal/view/items_transfer.php'); ?>
    <!-- END VIEW ITEMS MODAL -->
    
    <!-- TRANSFER REPORT MODAL -->
	<?php include ('modal/report/transfer_report.php'); ?>
    <!-- END TRANSFER REPORT MODAL -->

	<!-- ======= Footer ======= -->
	<?php include ('layout/footer.php'); ?>
	<!-- End Footer -->

	<!-- ======= Scripts ======= -->
	<?php include ('layout/scripts.php'); ?>
    <script src="assets/js/report/transfer.js"></script>
	<!-- End Scripts -->

    <script>
	    $(document).ready(function(){
            getData();

            $(document).on('click', '#add, #close', function(){
                $('input[name="date"]').val('');
                $('input[name="others"]').val('');
                $('#transfer_location').prop('checked', false); 
                $('#turnover_pmo').prop('checked', false);
                $('select[name="department"]').prop('selectedIndex', 0);
                $('select[name="category"]').prop('selectedIndex', 0);
                $('select[name="item_id"]').empty();

                $('#item-table tbody').empty();
                $('#add-modal').modal('toggle');
            });

            $('#btnSave').click(function() {
                var date = $('input[name="date"]').val();
                var transfer_location = $('#transfer_location').is(':checked') ? "Yes" : "No";
                var turnover_pmo = $('#turnover_pmo').is(':checked') ? "Yes" : "No";
                var others = $('input[name="others"]').val();
                var department = $('select[name="department"] :selected').val();
                var user_in_charge = $('select[name="user_in_charge"] :selected').val();
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
                        status: row.find('td').eq(8).find('input').val(),
                        pr_number: row.find('td').eq(9).find('input').val()
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
                    url: 'database/transfer/submit.php',  // The URL to your PHP API endpoint
                    type: 'POST',
                    contentType: 'application/json',  // Make sure to set the content type to JSON
                    data: JSON.stringify({
                        date: date,
                        transfer_location: transfer_location,
                        turnover_pmo: turnover_pmo,
                        others: others,
                        department: department,
                        user_in_charge: user_in_charge,
                        category: category,
                        item_name: item_name,
                        data: tableData  // The array is included as part of the JSON object
                    }),
                    success: function(response) {
                        if($.trim(response.status) == 'success') {
                            Swal.fire('System Message', 'Data saved successfully!', 'info').then(() => {
                                location.reload();
                            });
                        }
                        else {
                            Swal.fire("System Message", response.message, "info");
                        }
                        console.log('Response from server:', response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });

            });

            function getData(status = null) {
                const url = 'database/transfer/get_transfer.php';
                var showApproveBtn = "";
                var showEditBtn = "";
                var showCancelBtn = "";
                var table = $('.report-table').DataTable();
                table.clear().draw();
                $.get(url, { status }, (response) => {
                    const rows = JSON.parse(response);
                    rows.forEach(row => {
                        showApproveBtn = (row.status == 'FOR USER') ? 'block' : 'none';
                        showEditBtn = (row.status == 'DISAPPROVED') ? '' : 'none';
                        showCancelBtn = (row.status == 'FOR GENERAL SERVICES') ? '' : 'none';
                        table.row.add($(`<tr id="${row.id}">
                                            <td>${moment(row.date).format('MMMM D, YYYY')}</td>
                                            <td>${row.move_from}</td>
                                            <td>${row.department}</td>
                                            <td>${row.item_category}</td>
                                            <td>
                                                 <a class='btn btn-primary btn-sm' data-role='items' data-id="${row.id}" style="color: white;" title="View Items"><i class="bi bi-binoculars"> </i> </a>
                                            </td>
                                            <td>${row.comment || ''}</td>
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : row.status === 'DISAPPROVED' ? 'danger' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class='btn btn-success btn-sm' data-role='approve' data-id="${row.id}" style="color: white; display: ${showApproveBtn}" title="Accept Items"><i class="bi bi-hand-thumbs-up"> </i> </a>
                                                    <a class='btn btn-info btn-sm' data-role='edit' data-id="${row.id}" data-disapproveid="${row.disapproved_by_id}" style="color: white; display: ${showEditBtn}" title="Edit"><i class="bi bi-pencil"> </i> </a>
                                                    <a class='btn btn-danger btn-sm' data-role='cancel' data-id="${row.id}" style="color: white; display: ${showCancelBtn}" title="Cancel"><i class="bi bi-x-circle"> </i> </a>
                                                    <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                                </div>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }

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
                            url  : 'database/transfer/cancel.php',
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
            
            $(document).on('click', 'a[data-role=approve]', function(){
                var id = $(this).data('id');
                const formData = {
                    id: id
                };

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to accept this transaction.",
                    icon: 'warning',
                    showCancelButton: true,  // Show the Cancel button
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true      // Reverses the buttons order
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data : formData,
                            url  : 'database/transfer/approve.php',
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
