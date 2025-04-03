$(document).on('click', 'a[data-role=items]', function(){
    var id = $(this).data('id');
    
    const url = 'database/inventory/get_inventory_items.php';
   
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

$('select[name="in_charge"]').on('change', function() {
    var in_charge = $(this).val();
    if (in_charge) {
        $.get('database/inventory/get_category.php', { in_charge }, function(data) {
            var data = JSON.parse(data);

            var $select = $('select[name="category"]');
            $select.empty(); // Clear existing options
            $select.append(
                    $('<option>').val('').text('Please select')
                );

            // Populate the second select with new options
            $.each(data, function(index, item) {
                $select.append(
                    $('<option>')
                        .val(item.item_category)
                        .text(item.item_category)
                );
            });
        });
    }
});

$('select[name="category"]').on('change', function() {
    var category = $(this).val();
    var in_charge = $('select[name="in_charge"] :selected').val();

    if (category) {
        $.get('database/inventory/get_items.php', { category, in_charge }, function(data) {
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

$('#btnAdd').on('click', function() {
    var item_id = $('select[name="item_id"] :selected').val();
    var selectedOption = $('select[name="item_id"]').find('option:selected');

    var property_code = $('input[name="property_code"]').val();
    var date_inventory = $('input[name="date_inventory"]').val();
    var date_last_inventory = $('input[name="date_last_inventory"]').val();
    var sy = $('input[name="sy"]').val();
    var category = $('select[name="category"] :selected').val();
    var item_name = $('select[name="item_id"] :selected').text();

    // Validate inputs
    if (property_code == '') {
        Swal.fire("System Message", "Please select property code!", "info");
        return;
    }
    if (date_inventory == '') {
        Swal.fire("System Message", "Please input date of inventory!", "info");
        return;
    }
    if (date_last_inventory == '') {
        Swal.fire("System Message", "Please input date of last inventory!", "info");
        return;
    }
    if (sy == '') {
        Swal.fire("System Message", "Please input school year!", "info");
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
            <td><input type="number" name="quantity[]" class="form-control" min="1" value="${selectedOption.data('quantity')}" readonly></td>
            <td><input type="text" name="unit[]" class="form-control" value="${selectedOption.data('unit')}" readonly></td>
            <td><input type="text" name="description[]" class="form-control" value="${selectedOption.data('description')}" readonly></td>
            <td><input type="text" name="brand[]" class="form-control"></td>
            <td><input type="text" name="part_code[]" class="form-control"></td>
            <td><input type="text" name="model_number[]" class="form-control"></td>
            <td><input type="text" name="serial_number[]" class="form-control"></td>
            <td>
                <select name="status[]" class="form-control">
                    <option value="B">B</option>
                    <option value="F">F</option>
                    <option value="L">L</option>
                    <option value="U">U</option>
                    <option value="D">D</option>
                    <option value="G">G</option>
                </select>
            </td>
            <td><input type="text" name="remarks[]" class="form-control" values="Ok"></td>
            <td><button class="btn btn-danger btnRemove"><i class="bi bi-trash"></i></button></td>
        </tr>`;

    $('#item-table tbody').append(newRow);

});

// Delegate click event to dynamically added remove buttons
$('#item-table').on('click', '.btnRemove', function() {
    $(this).closest('tr').remove();
});


$(document).on('click', 'a[data-role=generate]', function(){
    var property_id = $(this).data('id');
    fetchInventoryData(property_id);
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
            
function fetchInventoryData(id) {
    const url = 'database/inventory/fetch_inventory.php';
    const item_url = 'database/inventory/get_inventory_items.php';

    var template = '';
    var inventory_items = [];

    $.ajaxSetup({async: false});
    $.get(item_url, { id }, (response) => {
        inventory_items = JSON.parse(response);
    });

    var table = $('#report-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { id }, (response) => {
        // console.log(response);
        const rows = JSON.parse(response);
        const { date_inventory, date_last, property_code, department, item_category, sy, area,
                in_charge, in_charge_by_signature, in_charge_date, conformed_by, conformed_by_signature } = rows[0];

        template += `
            <tr>
                <td colspan=5>
                    <span class="txt-bold">Property Code: </span> ${property_code}
                </td>
                <td colspan=2 class="txt-bold txt-center">
                    <span>Date of Inventory:</span>
                </td>
                <td colspan=2 class="txt-center">
                    ${moment(date_inventory).format('MMMM D, YYYY')}
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=5>
                    <span class="txt-bold">Property In-Charge: </span> ${in_charge || 'Awaiting user approval'}
                </td>
                <td colspan=2 class="txt-bold txt-center">
                    <span>Date of last Inventory:</span>
                </td>
                <td colspan=2 class="txt-center">
                    ${moment(date_last).format('MMMM D, YYYY')}
                </td>
            </tr>
        `;

        // 3rd row
        template += `
            <tr>
                <td colspan=3>
                    <span class="txt-bold">Department: </span> ${department}
                </td>
                <td colspan=2 class="txt-bold txt-center">
                    <span>Category</span>
                </td>
                <td colspan=2 class="txt-center">
                    ${area || ''}
                </td>
                <td colspan=2 class="txt-center">
                    <span>SY: ${sy}</span> 
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td class="txt-center txt-bold" width=5%>Qty</td>
                <td class="txt-center txt-bold" width=5%>UoM</td>
                <td class="txt-center txt-bold" width=25%>Description</td>
                <td class="txt-center txt-bold" width=8%>Brand</td>
                <td class="txt-center txt-bold" width=20%>Part Code</td>
                <td class="txt-center txt-bold" width=15%>Model #</td>
                <td class="txt-center txt-bold" width=30%>Serial #</td>
                <td class="txt-center txt-bold" width=6%>Status</td>
                <td class="txt-center txt-bold" width=10%>Remarks</td>
            </tr>
        `;
        
        // add empty space
        template += `<tr><td colspan="9"></td></tr>`;

        const rowHeight = 30; // Approximate height of a row in pixels (adjust as needed)
        const tableHeight = 830; // Subtract header height
        const footerHeight = 100; // Get footer height
        const availableHeight = tableHeight - footerHeight; // Calculate available height for the table rows
        const remainingRows = Math.floor(availableHeight / rowHeight); // Calculate the required number of rows to fill the space before the footer

        // 5th row
        inventory_items.forEach(item => {
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

        // 6th row
        template += `
            <tr>
                <td colspan="9" class="txt-bold txt-center">
                    Page 1 of 1
                </td>
            </tr>
        `;

        // 7th row
        template += `
            <tr>
                <td colspan="9" style="border: none; text-align: justify; text-indent: 50px;">
                    The above declared properties are true and correct, no more no less, based on assessment done (i.e. Property Inspection)
                    by the school property custodian on ${moment(date_inventory).format('MMMM D, YYYY')}.
                </td>
            </tr>
        `;

        // 8th row
        template += `
            <tr>
                <td colspan="9" style="border: none; text-align: justify; text-indent: 50px;">
                    I, the property in-charge assume the risk of, and agree that i shall be able of any damage, lost or malfunction 
                    due to carelessness/mishandling of the above declared school properties.
                </td>
            </tr>
        `;

        // Signatories (Legend & Property In Charge)
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    <table border="1" width="100%">
                        <tbody>
                            <tr>
                                <td colspan=2 style="border: none; font-size: 8px;">LEGEND:</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 50px; border: none;">B - Borrowed</td>
                                <td style="font-size: 8px; border: none;">F - Functional</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 50px; border: none;">L - Lost</td>
                                <td style="font-size: 8px; border: none;">D - Damage/Defective</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 50px; border: none;">U - Under Repair</td>
                                <td style="font-size: 8px; border: none;">G - Good</td>
                            </tr>

                            <tr>
                                <td colspan=2 style="font-size: 8px; border: none;">Property Number:</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 70px; border: none;">Property Code</td>
                                <td style="font-size: 8px; text-indent: 20px; border: none;">Part Code</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan=5 style="border: none;">
                    <center>
                        <div>
                            ${in_charge_date != null && in_charge_by_signature != null ? "<img src='uploads/signature/" + in_charge_by_signature + "' alt='Signature' class='signature-image'>" : "<br><br>"}
                        </div>
                    </center>

                    <div class="txt-center">
                        <u>${ in_charge || '' }</u>
                        <br>
                        <span class="txt-bold">Property In-Charge</span>
                    </div>
                </td>
            </tr>
        `;
    
        // Signatories (Property Code & Conformed by)
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    <div>
                        <table class="form-table" style="width: 100%;">
                            <tr>
                                <th>Form Code No.</th>
                                <td style="border-bottom: 0;" class="txt-bold">: FM-DPM-SMCC-PMS-01</td>
                            </tr>
                            <tr>
                                <th>Issue Status</th>
                                <td style="border-top: 0; border-bottom: 0;" class="txt-bold">: 02</td>
                            </tr>
                            <tr>
                                <th>Revision No.</th>
                                <td style="border-top: 0; border-bottom: 0;" class="txt-bold">: 00</td>
                            </tr>
                            <tr>
                                <th>Date Effective</th>
                                <td style="border-top: 0; border-bottom: 0;" class="txt-bold">: 02 April 2021</td>
                            </tr>
                            <tr>
                                <th>Approved By</th>
                                <td style="border-top: 0;" class="txt-bold">: President</td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td class="txt-right" style="border: none;">
                    <span class="txt-bold">Conformed: </span>
                </td>
                <td colspan=3 style="border: none; ">
                    <br>
                    <br>
                    <div style="margin-left: 50px;">
                        ${conformed_by != null && conformed_by_signature != null ? "<img src='uploads/signature/" + conformed_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ conformed_by || '' }</u>
                        <br>
                        <span class="txt-bold">School Property Custodian</span>
                    </div>
                </td>

            </tr>
        `;

        table.append(template);
    });

}