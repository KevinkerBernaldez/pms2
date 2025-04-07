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
                );
            });
        });
    }
});

// Add item to the table
$('#btnAdd').on('click', function() {
    var item_id = $('select[name="item_id"] :selected').val();
    var selectedOption = $('select[name="item_id"]').find('option:selected');

    var date = $('input[name="date"]').val();
    var category = $('select[name="category"] :selected').val();
    var item_name = $('select[name="item_id"] :selected').text();
    var fileInput = $('input[type="file"]')[0];  // Get the file input element
    var file = fileInput.files[0];  // Get the first file (if any)

    // Validate inputs
    if (date == '') {
        Swal.fire('System Message', "Please select date!", 'info');
        return;
    }
    if (category == '') {
        Swal.fire('System Message', "Please select category!", 'info');
        return;
    }
    if (item_id == '') {
        Swal.fire('System Message', "Please select item!", 'info');
        return;
    }
    if (!file) {
        Swal.fire('System Message', "Please attach a file!", 'info');
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
        Swal.fire('System Message', "Data already exist!", 'info');
        return;
    }

    // Create a new row and append it to the table
    var newRow = `
        <tr>
            <td style="display: none;">${selectedOption.data('id')}</td>
            <td><input type="number" name="quantity[]" class="form-control" min="1" value="${selectedOption.data('quantity')}"></td>
            <td><input type="text" name="unit[]" class="form-control" value="${selectedOption.data('unit')}" readonly></td>
            <td><input type="text" name="description[]" class="form-control" value="${selectedOption.data('description')}" readonly></td>
            <td><input type="text" name="property_code[]" class="form-control"></td>
            <td><input type="text" name="brand[]" class="form-control"></td>
            <td><input type="text" name="part_code[]" class="form-control"></td>
            <td><input type="text" name="condition[]" class="form-control"></td>
            <td><button class="btn btn-danger btnRemove"><i class="bi bi-trash"></i></button></td>
        </tr>`;

    $('#item-table tbody').append(newRow);

});

// Delegate click event to dynamically added remove buttons
$('#item-table').on('click', '.btnRemove', function() {
    $(this).closest('tr').remove();
});

// View disposal items
$(document).on('click', 'a[data-role=items]', function(){
    var id = $(this).data('id');
    var status = $(this).data('status');
    var userrole = $(this).data('userrole');
    const url = 'database/disposal/get_disposal_items.php';
   
    var table = $('#view-table').DataTable();
    table.clear().draw();
    $.get(url, { id }, (response) => {
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr>
                                <td>${row.id}</td>
                                <td>${row.quantity}</td>
                                <td>${row.unit}</td>
                                <td>${row.description}</td>
                                <td>${row.property_code}</td>
                                <td>${row.brand}</td>
                                <td>${row.part_code}</td>
                                <td>${row.conditioned}</td>
                                <td><input type="text" name="remarks[]" class="form-control" value="${row.remarks}" /></td>
                            </tr>`)).draw();

        });
    });

    var btn = document.getElementById('btnSaveRemarks');
  
    if (userrole == 'Property Custodian' && status == 'FOR PROPERTY CUSTODIAN') {
      btn.style.display = 'block'; // Show the button
    }
    else {
        btn.style.display = 'none'; // Hide the button
    }

    $('#view-modal').modal('toggle');
});

// Add item to the table
$('#btnSaveRemarks').on('click', function() {
    var tableData = [];

    $('#view-table tbody tr').each(function() {
        var row = $(this);
        var rowData = {
            id: row.find('td').eq(0).text(),
            remark: row.find('td').eq(8).find('input').val()
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

    var formData = new FormData();
    formData.append('data', JSON.stringify(tableData)); // Send the tableData as a string

    $.ajax({
        url: 'database/disposal/submit_remarks.php', 
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

// Edit disposal items
$(document).on('click', 'a[data-role=edit]', function(){
    var id = $(this).data('id');
    var disapproved_by_id = $(this).data('disapproveid');

    const url = 'database/disposal/get_disposal_items.php';
   
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
                                <td><input type="text" name="property_code[]" class="form-control" value="${row.property_code}"></td>
                                <td><input type="text" name="brand[]" class="form-control" value="${row.brand}"></td>
                                <td><input type="text" name="part_code[]" class="form-control" value="${row.part_code}"></td>
                                <td><input type="text" name="condition[]" class="form-control" value="${row.conditioned}"></td>
                            </tr>`)).draw();

        });
    });

    
    $('#disposal_id').val(id);
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
    var disposal_id = $('#disposal_id').val();
    var disapprove_id = $('#edit_id').val();

    var formData = new FormData();
    formData.append('data', JSON.stringify(tableData)); 
    formData.append('disposal_id', disposal_id);
    formData.append('disapprove_id', disapprove_id);

    $.ajax({
        url: 'database/disposal/submit_edit.php', 
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

// Generate disposal report
$(document).on('click', 'a[data-role=generate]', function(){
    var disposal_id = $(this).data('id');
    fetchDisposalData(disposal_id);
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
            
function fetchDisposalData(id) {
    const url = 'database/disposal/fetch_disposal.php';
    const item_url = 'database/disposal/get_disposal_items.php';

    var template = '';
    var disposal_items = [];

    $.ajaxSetup({async: false});
    $.get(item_url, { id }, (response) => {
        disposal_items = JSON.parse(response);
    });

    var table = $('#report-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { id }, (response) => {
        // console.log(response);
        const rows = JSON.parse(response);
        const { date, department, item_category, prepared_by, prepared_by_signature, checked_by, checked_by_signature, 
                noted_by, noted_by_signature, approved_by, approved_by_signature } = rows[0];

        template += `
            <tr>
                <td colspan=5>
                    <span class="txt-bold">Property In-Charge: </span> ${prepared_by}
                </td>
                <td class="txt-center txt-bold">Date:</td>
                <td colspan=2 class="txt-center">
                    <span>${moment(date).format('MMMM D, YYYY')}</span>
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=5>
                    <span class="txt-bold">Department: </span> ${department}
                </td>
                <td class="txt-center txt-bold">Category:</td>
                <td colspan=2 class="txt-center">
                    <span>${item_category}</span>
                </td>
            </tr>
        `;

        // 3rd row
        template += `
            <tr>
                <td class="txt-center txt-bold" width=5%>Qty</td>
                <td class="txt-center txt-bold" width=5%>UoM</td>
                <td class="txt-center txt-bold" width=20%>Property Type</td>
                <td class="txt-center txt-bold" width=10%>Property Code</td>
                <td class="txt-center txt-bold" width=10%>Brand</td>
                <td class="txt-center txt-bold" width=20%>Part Code / <br> Serial Number</td>
                <td class="txt-center txt-bold" width=10%>Condition</td>
                <td class="txt-center txt-bold" width=10%>Remarks</td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="8">&nbsp;</td></tr>`;

        // 4th row
        disposal_items.forEach(item => {
            template += `
                <tr>
                    <td class="txt-center">${item.quantity}</td>
                    <td class="txt-center">${item.unit}</td>
                    <td class="txt-center">${item.description}</td>
                    <td class="txt-center">${item.property_code}</td>
                    <td class="txt-center">${item.brand}</td>
                    <td class="txt-center">${item.part_code}</td>
                    <td class="txt-center">${item.conditioned}</td>
                    <td class="txt-center">${item.remarks || ''}</td>
                </tr>
            `;
        });

        const rowHeight = 30; // Approximate height of a row in pixels (adjust as needed)
        const tableHeight = 820; // Subtract header height
        const footerHeight = 5; // Get footer height
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
                </tr>
            `;
        }

        // 5th row
        template += `
            <tr>
                <td class="txt-bold">Note:</td>
                <td colspan=7></td>
            </tr>
        `;
        
        // 6th row
        template += `
            <tr>
                <td></td>
                <td colspan=7 class="txt-center txt-bold">
                    This Property Listed above are No Longer useful in this establishment, Thus subject for disposal.
                </td>
            </tr>
        `;

        // 7th row
        template += `
            <tr style="border: none;">
                <td style="border: 0;"></td>
                <td colspan=7 style="border: 0;">
                    <small>Please attached supporting documents from authorized person/technician/mechanic (Incident Report / Computer Technician Report)</small>
                </td>
            </tr>
        `;

        // Signatories (Prepared by and Checked by)
        template += `
            <tr>
                <td colspan=5 style="border: none;">
                    <br>
                    <span class="txt-bold">Prepared by: </span>
                    <br>
                    <div style="margin-left: 50px;">
                        ${prepared_by != null && prepared_by_signature != null ? "<img src='uploads/signature/" + prepared_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ prepared_by || '' }</u>
                        <br>
                        Property In-Charge
                    </div>
                </td>
                <td colspan=3 style="border: none; ">
                    <br>
                    <span class="txt-bold">Checked by: </span>
                    <br>
                    <div style="margin-left: 50px;">
                        ${checked_by != null && checked_by_signature != null ? "<img src='uploads/signature/" + checked_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ checked_by || '' }</u>
                        <br>
                        Property Custodian
                    </div>
                </td>
            </tr>
        `;
    
        // Signatories (Noted by and Approved by)
        template += `
            <tr>
                <td colspan=5 style="border: none; ">
                    <br>
                    <span class="txt-bold">Noted by: </span>
                    <br>
                    <div style="margin-left: 50px;">
                        ${noted_by != null && noted_by_signature != null ? "<img src='uploads/signature/" + noted_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ noted_by || '' }</u>
                        <br>
                        PMO Head
                    </div>
                </td>
                <td colspan=3 style="border: none; ">
                    <br>
                    <span class="txt-bold">Approved by: </span>
                    <br>
                    <div style="margin-left: 50px;">
                        ${approved_by != null && approved_by_signature != null ? "<img src='uploads/signature/" + approved_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ approved_by || '' }</u>
                        <br>
                        VP-Admin
                    </div>
                </td>
            </tr>
        `;

        table.append(template);
    });

}