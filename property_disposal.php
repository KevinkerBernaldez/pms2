<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$title = 'Property Disposal';
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
			<h1>Property Disposal</h1>
		</div><!-- End Page Title -->

		<section class="section dashboard">
			<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mt-3" title="Add Record" id="add">Add Disposal</button>
                            <div>&nbsp</div>
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
	<?php include ('modal/disposal.php'); ?>
    <!-- END ADD MODAL -->

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
            getData();

            $(document).on('click', '#add, #close', function(){
                $('input[name="date"]').val('');
                $('select[name="category"]').prop('selectedIndex', 0);
                $('select[name="item_id"]').empty();

                $('#item-table tbody').empty();
                $('#add-modal').modal('toggle');
            });

            $('#btnSave').click(function() {
                var date = $('input[name="date"]').val();
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
                        property_code: row.find('td').eq(4).find('input').val(),
                        brand: row.find('td').eq(5).find('input').val(),
                        part_code: row.find('td').eq(6).find('input').val(),
                        conditioned: row.find('td').eq(7).find('input').val()
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

                // Create a new FormData object
                var formData = new FormData();

                // Append the JSON data as key-value pairs
                formData.append('date', date);
                formData.append('category', category);
                formData.append('item_name', item_name);
                formData.append('data', JSON.stringify(tableData)); // Send the tableData as a string

                // Append the file(s) you want to upload (replace 'fileInput' with the actual file input ID)
                var fileInput = document.getElementById('fileInput');  // Get the file input element by ID
                var file = fileInput ? fileInput.files[0] : null; 
                formData.append('file', file);

                $.ajax({
                    url: 'database/disposal/submit.php', 
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false, 
                    contentType: false, 
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
                const url = 'database/disposal/get_disposal.php';
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
                                            <td>
                                                <span class="badge bg-${row.status === 'APPROVED' ? 'success' : 'info'}">
                                                    ${row.status}
                                                </span>
                                            </td>
                                            <td>
                                                <a class='btn btn-warning btn-sm' data-role='generate' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="bi bi-file-earmark-ruled"> </i> </a>
                                            </td>
                                        </tr>`)).draw();
                    });
                });
                table.order([0, 'desc']).draw();
            }
            
        });
    </script>
</body>

</html>
