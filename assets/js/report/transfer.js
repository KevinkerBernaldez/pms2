$('select[name="department"]').on('change', function() {
    var department = $(this).val();
    if (department) {
        $.get('database/transfer/get_personnel.php', { department }, function(data) {
            var data = JSON.parse(data);

            var $select = $('select[name="user_in_charge"]');
            $select.empty(); // Clear existing options
            $select.append(
                    $('<option>').val('').text('Please select')
                );

            // Populate the second select with new options
            $.each(data, function(index, item) {
                $select.append(
                    $('<option>')
                        .val(item.id)
                        .text(item.fname + ' ' + item.lname)
                );
            });
        });
    }
});

$('select[name="category"]').on('change', function() {
    var category = $(this).val();
    if (category) {
        $.get('database/disposal/get_items.php', { category }, function(data) {
            var data = JSON.parse(data);

            var $select = $('select[name="item_id"]');
            $select.empty(); // Clear existing options
            $select.append(
                    $('<option>').val('').text('Please select')
                );

            // Populate the second select with new options
            $.each(data, function(index, item) {
                $select.append(
                    $('<option>')
                        .val(item.id)
                        .text(item.description)
                        .attr('data-id', item.id)
                        .attr('data-quantity', item.quantity)
                        .attr('data-unit', item.unit)
                        .attr('data-description', item.description)
                        .attr('data-prnumber', item.pr_no)
                );
            });
        });
    }
});

$('#btnAdd').on('click', function() {
    var item_id = $('select[name="item_id"] :selected').val();
    var selectedOption = $('select[name="item_id"]').find('option:selected');

    var date = $('input[name="date"]').val();
    var department = $('select[name="department"] :selected').val();
    var category = $('select[name="category"] :selected').val();
    var item_name = $('select[name="item_id"] :selected').text();

    // Validate inputs
    if (date == '') {
        Swal.fire("System Message", "Please select date!", "info");
        return;
    }
    if (department == '') {
        Swal.fire("System Message", "Please select department!", "info");
        return;
    }
    if (category == '') {
        Swal.fire("System Message", "Please select category!", "info");
        return;
    }
    if (item_id == '') {
        Swal.fire("System Message", "Please select item!", "info");
        return;
    }
    
    // // Check if the row already exists
    var rowExists = false;
    $('#item-table tbody tr').each(function() {
        var currentRow = $(this);
        var property_type = currentRow.find('td').eq(3).find('input').val();

        if (item_name === property_type) {
            rowExists = true;
            return false; // Break the loop
        }
    });

    if (rowExists) {
        Swal.fire("System Message", "Data already exist!", "info");
        return;
    }

    // Create a new row and append it to the table
    var newRow = `
        <tr>
            <td style="display: none;">${selectedOption.data('id')}</td>
            <td><input type="number" name="quantity[]" class="form-control" min="1" value="${selectedOption.data('quantity')}"></td>
            <td><input type="text" name="unit[]" class="form-control" value="${selectedOption.data('unit')}" readonly></td>
            <td><input type="text" name="description[]" class="form-control" value="${selectedOption.data('description')}" readonly></td>
            <td><input type="text" name="brand[]" class="form-control"></td>
            <td><input type="text" name="part_code[]" class="form-control"></td>
            <td><input type="text" name="model_number[]" class="form-control"></td>
            <td><input type="text" name="serial_number[]" class="form-control"></td>
            <td><input type="text" name="status[]" class="form-control"></td>
            <td style="display: none;"><input type="text" name="pr_number[]" class="form-control" value="${selectedOption.data('prnumber')}" readonly></td>
            <td><button class="btn btn-danger btnRemove"><i class="bi bi-trash"></i></button></td>
        </tr>`;

    $('#item-table tbody').append(newRow);

});

// Delegate click event to dynamically added remove buttons
$('#item-table').on('click', '.btnRemove', function() {
    $(this).closest('tr').remove();
});

$(document).on('click', 'a[data-role=items]', function(){
    var id = $(this).data('id');
    
    const url = 'database/transfer/get_transfer_items.php';
   
    var table = $('#view-table').DataTable();
    table.clear().draw();
    $.get(url, { id }, (response) => {
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr>
                                <td>${row.quantity}</td>
                                <td>${row.unit}</td>
                                <td>${row.description}</td>
                                <td>${row.brand}</td>
                                <td>${row.part_code}</td>
                                <td>${row.model_number}</td>
                                <td>${row.serial_number}</td>
                                <td>${row.status}</td>
                                <td>${row.remarks || ''}</td>
                            </tr>`)).draw();

        });
    });

    $('#view-modal').modal('toggle');
});

// Edit disposal items
$(document).on('click', 'a[data-role=edit]', function(){
    var id = $(this).data('id');
    var disapproved_by_id = $(this).data('disapproveid');

    const url = 'database/transfer/get_transfer_items.php';
   
    var table = $('#view-table').DataTable();
    table.clear().draw();
    $.get(url, { id }, (response) => {
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr>
                                <td name="id[]">${row.id}</td>
                                <td><input type="number" name="quantity[]" class="form-control" min="1" value="${row.quantity}"></td>
                                <td><input type="text" name="unit[]" class="form-control" value="${row.unit}"></td>
                                <td><input type="text" name="description[]" class="form-control" value="${row.description}"></td>
                                <td><input type="text" name="brand[]" class="form-control" value="${row.brand}"></td>
                                <td><input type="text" name="part_code[]" class="form-control" value="${row.part_code}"></td>
                                <td><input type="text" name="model_number[]" class="form-control" value="${row.model_number}"></td>
                                <td><input type="text" name="serial_number[]" class="form-control" value="${row.serial_number}"></td>
                                <td><input type="text" name="status[]" class="form-control" value="${row.status}"></td>
                            </tr>`)).draw();

        });
    });

    
    $('#transfer_id').val(id);
    $('#edit_id').val(disapproved_by_id);
    $('#edit-modal').modal('toggle');
});

// Add edit item to disposal table
$('#btnSaveEdit').on('click', function() {
    var tableData = [];

    $('#view-table tbody tr').each(function() {
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
            status: row.find('td').eq(8).find('input').val()
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
    var transfer_id = $('#transfer_id').val();
    var disapprove_id = $('#edit_id').val();

    var formData = new FormData();
    formData.append('data', JSON.stringify(tableData)); 
    formData.append('transfer_id', transfer_id);
    formData.append('disapprove_id', disapprove_id);

    $.ajax({
        url: 'database/transfer/submit_edit.php', 
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

$(document).on('click', 'a[data-role=generate]', function(){
    var transfer_id = $(this).data('id');
    fetchTransferData(transfer_id);
    setTimeout(() => {
        var toPrint = document.getElementById('report-form');
        var newTab = window.open('', '_blank');
        newTab.document.write('<html><head><title>' + document.title + '</title>');

        // Link to an external CSS file
        newTab.document.write('<link rel="stylesheet" type="text/css" href="assets/css/property_report.css?v=' + new Date().getTime() + '">');

        newTab.document.write('</head><body>');
        newTab.document.write(toPrint.innerHTML);
        newTab.document.write('</body></html>');

        newTab.document.close();
        // Wait for the CSS and other resources to fully load before printing
        newTab.onload = function() {
            newTab.print();
        };
    
        // Focus on the new tab
        newTab.focus();
    }, 500); // Delay of 500 milliseconds (0.5 seconds)

});

function fetchTransferData(id) {
    const url = 'database/transfer/fetch_transfer.php';
    const item_url = 'database/transfer/get_transfer_items.php';

    var template = '';
    var transfer_items = [];

    $.ajaxSetup({async: false});
    $.get(item_url, { id }, (response) => {
        transfer_items = JSON.parse(response);
    });

    var table = $('#report-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { id }, (response) => {
        // console.log(response);
        const rows = JSON.parse(response);
        const { date, move_from, department, item_category, is_transfer, is_turnover, others, prepared_by, prepared_by_signature, checked_by, checked_by_signature, 
                accepted_by, accepted_by_signature, endorsed_by, endorsed_by_signature, recommending_by, recommending_by_signature, approved_by, approved_by_signature } = rows[0];

        template += `
            <tr>
                <td colspan=5>
                    <span class="txt-bold">Property In-Charge: </span> ${prepared_by}
                </td>
                <td colspan=4>
                    <span class="txt-bold">Date:</span> ${moment(date).format('MMMM D, YYYY')}
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=9>
                    <span class="txt-bold">Move From: </span> ${move_from}
                </td>
            </tr>
        `;

        // 3rd row
        template += `
            <tr>
                <td colspan=9>
                    <span class="txt-bold">Move To: </span> ${department}
                </td>
            </tr>
        `;
        
        // 4th row
        template += `
            <tr>
                <td colspan=9>
                    <span class="txt-bold">Transfer to another Location / Office: </span> 
                    (${is_transfer == 'Yes' ? '✔' : '&nbsp;'})
                </td>
            </tr>
        `;

        // 5th row
        template += `
            <tr>
                <td colspan=9>
                    <span class="txt-bold">Turn-over to PMO: </span> 
                    (${is_turnover == 'Yes' ? '✔' : '&nbsp;'})
                </td>
            </tr>
        `;

        // 6th row
        template += `
            <tr>
                <td colspan=9>
                    <span class="txt-bold">Others, please specify: </span> 
                    ${others ? `${others}` : '&nbsp;'}
                </td>
            </tr>
        `;

        // 7th row
        template += `
            <tr>
                <td class="txt-center txt-bold" width=5%>Qty</td>
                <td class="txt-center txt-bold" width=10%>UoM</td>
                <td class="txt-center txt-bold" width=20%>Description</td>
                <td class="txt-center txt-bold" width=10%>Brand</td>
                <td class="txt-center txt-bold" width=20%>Part Code</td>
                <td class="txt-center txt-bold" width=10%>Model #</td>
                <td class="txt-center txt-bold" width=10%>Serial #</td>
                <td class="txt-center txt-bold" width=10%>Status</td>
                <td class="txt-center txt-bold" width=10%>Remarks</td>
            </tr>
        `;
        
        // add empty space
        template += `<tr><td colspan="9">&nbsp;</td></tr>`;

        // 8th row
        transfer_items.forEach(item => {
            template += `
                <tr>
                    <td class="txt-center">${item.quantity}</td>
                    <td class="txt-center">${item.unit}</td>
                    <td class="txt-center">${item.description}</td>
                    <td class="txt-center">${item.brand}</td>
                    <td class="txt-center">${item.part_code}</td>
                    <td class="txt-center">${item.model_number}</td>
                    <td class="txt-center">${item.serial_number}</td>
                    <td class="txt-center">${item.status}</td>
                    <td class="txt-center">${item.remarks || ''}</td>
                </tr>
            `;
        });

        const rowHeight = 30; // Approximate height of a row in pixels (adjust as needed)
        const tableHeight = window.innerHeight - document.querySelector('thead').offsetHeight + 220; // Subtract header height
        const footerHeight = 100; // Get footer height
        const availableHeight = tableHeight - footerHeight; // Calculate available height for the table rows
        const remainingRows = Math.floor(availableHeight / rowHeight); // Calculate the required number of rows to fill the space before the footer

        // Add empty rows to fill the remaining space
        for (let i = 0; i < remainingRows; i++) {
            template += `
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            `;
        }

        // Signatories (Prepared by, Checked by & Accepted by)
        template += `
            <tr>
                <td colspan=3 style="border: none;">
                    <center>
                        ${prepared_by != null && prepared_by_signature != null ? "<img src='uploads/signature/" + prepared_by_signature + "' alt='Signature' class='signature-image'>" : "<br><br>"}
                    </center>
                    <div class="txt-center txt-bold">
                        <u>${ prepared_by || '' }</u>
                        <br>
                        Prepared by:
                        <br>
                        Property In-Charge
                    </div>
                </td>
                <td colspan=3 style="border: none;">
                    <center>
                        ${checked_by != null && checked_by_signature != null ? "<img src='uploads/signature/" + checked_by_signature + "' alt='Signature' class='signature-image'>" : "<br><br>"}
                    </center>
                    <div class="txt-center txt-bold">
                        <u>${ checked_by || '' }</u>
                        <br>
                        Checked & verified by:
                        <br>
                        Authorized Person/Technician/Mechanic
                    </div>
                </td>
                <td colspan=3 style="border: none; ">
                    <center>
                        ${accepted_by != null && accepted_by_signature != null ? "<img src='uploads/signature/" + accepted_by_signature + "' alt='Signature' class='signature-image'>" : "<br><br>"}
                    </center>
                    <div class="txt-center txt-bold">
                        <u>${ accepted_by || '' }</u>
                        <br>
                        Name & Signature of Person
                        <br>
                        Accepting Equipment/Facility
                    </div>
                </td>
            </tr>
        `;
    
        // Signatories (Endorsed by and Recommending Approval)
        template += `
            <tr>
                <td colspan=2 style="border: none;">
                    <span class="txt-bold">Endorsed by: </span>
                </td> 
                <td colspan=2 style="border: none;">
                    <br>
                    <br>
                    <div style="margin-left: 50px;">
                        ${endorsed_by != null && endorsed_by_signature != null ? "<img src='uploads/signature/" + endorsed_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ endorsed_by || '' }</u>
                        <br>
                        Property Custodian
                    </div>
                </td>
                <td colspan=2 style="border: none;" class="txt-right">
                    <span class="txt-bold">Recommending Approval: </span>
                </td> 
                <td colspan=3 style="border: none; ">
                    <br>
                    <br>
                    <div style="margin-left: 50px;">
                        ${recommending_by != null && recommending_by_signature != null ? "<img src='uploads/signature/" + recommending_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ recommending_by || '' }</u>
                        <br>
                        <span class="txt-bold">PMO Head</span>
                    </div>
                </td>

            </tr>
        `;

        // Signatories (Approved by)
        template += `
        <tr>
            <td colspan=4 style="border: none;" class="txt-right">
                <span class="txt-bold">Approved by: </span>
            </td> 
            <td colspan=3 style="border: none; ">
                <br>
                <br>
                <div style="margin-left: 50px;">
                    ${approved_by != null && approved_by_signature != null ? "<img src='uploads/signature/" + approved_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                    <u>${ approved_by || '' }</u>
                    <br>
                    <span class="txt-bold">VP - Administrative Affairs</span>
                </div>
            </td>
        </tr>
    `;

        table.append(template);
    });

}