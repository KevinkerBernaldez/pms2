// View history items
$(document).on('click', 'a[data-role=history]', function(){
    var id = $(this).data('id');
    $('#inventory_id').val(id);
    $('#add-modal').modal('toggle');
});

$(document).on('click', 'a[data-role=items]', function(){
    var id = $(this).data('id');
    
    const url = 'database/history/get_history_records.php';

    var table = $('#view-table').DataTable();
    table.clear().draw();
    $.get(url, { id }, (response) => {
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr>
                                <td>${row.type}</td>
                                <td>${moment(row.date).format('MMMM D, YYYY')}</td>
                                <td>${row.job_order_no}</td>
                                <td>${row.problem}</td>
                                <td>${row.action_taken}</td>
                                <td>${row.date_completed}</td>
                                <td>${row.conducted_by}</td>
                            </tr>`)).draw();

        });
    });

    $('#view-modal').modal('toggle');
});

$(document).on('click', 'a[data-role=generate]', function(){
    var inventory_id = $(this).data('id');
    fetchInventoryData(inventory_id);
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
    const url = 'database/history/fetch_inventory.php';
    const item_url = 'database/history/get_inventory_items.php';

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
        const { fname, lname, part_code, description, other_details, item_category, accepted_by_signature } = rows[0];

        // 1st row
        template += `
            <tr>
                <td colspan=2>
                    <span class="txt-bold txt-center">Name of Property:</span>
                </td>
                <td colspan=4 class="txt-bold txt-center">
                    ${description}
                </td>
                <td colspan=2 class="txt-center">
                    Page 1 of 1
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=2>
                    <span class="txt-bold txt-center">Property Code:</span>
                </td>
                <td colspan=4 class="txt-bold txt-center" style="border-right: none;">
                    ${part_code || ''}
                </td>
                <td colspan=2 style="border-left: none;"></td>
            </tr>
        `;

        // 3rd row
        template += `
            <tr>
                <td colspan=2>
                    <span class="txt-bold txt-center">Property in-charge:</span>
                </td>
                <td colspan=4 class="txt-bold txt-center" style="border-right: none;">
                    ${fname} ${lname}
                </td>
                <td colspan=2 style="border-left: none;"></td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan=2>
                    <span class="txt-bold txt-center">Other detailed Information:</span>
                </td>
                <td colspan=6 class="txt-bold txt-center">
                    ${other_details}
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="8">&nbsp;</td></tr>`;
        template += `<tr><td colspan="8">&nbsp;</td></tr>`;
        
        // 5th row
        template += `<tr><td colspan="8" class="txt-bold txt-center">MAINTENANCE / REPAIR HISTORY RECORD</td></tr>`;

        // 6th row
        template += `
            <tr>
                <td class="txt-center" width=10% style="font-size: 11;">*Type (R/PM)</td>
                <td class="txt-center" width=10% style="font-size: 11;">Date</td>
                <td class="txt-center" width=10% style="font-size: 11;">Repair Job Order No.</td>
                <td class="txt-center" width=20% style="font-size: 11;">Trouble/Problem Check-up</td>
                <td class="txt-center" width=10% style="font-size: 11;">Action Taken/ Repair Results</td>
                <td class="txt-center" width=10% style="font-size: 11;">Date Completed/ Repaired/</td>
                <td class="txt-center" width=10% style="font-size: 11;">Test Conducted by</td>
                <td class="txt-center" width=10% style="font-size: 11;">Accepted by (Signature)</td>
            </tr>
        `;

        const rowHeight = 30; // Approximate height of a row in pixels (adjust as needed)
        const tableHeight = 850; // Subtract header height
        const footerHeight = 100; // Get footer height
        const availableHeight = tableHeight - footerHeight; // Calculate available height for the table rows
        const remainingRows = Math.floor(availableHeight / rowHeight); // Calculate the required number of rows to fill the space before the footer

        // 7th row
        inventory_items.forEach(item => {
            template += `
                <tr>
                    <td class="txt-center">${item.type}</td>
                    <td class="txt-center">${moment(item.date).format('MMMM D, YYYY')}</td>
                    <td class="txt-center">${item.job_order_no}</td>
                    <td class="txt-center">${item.problem}</td>
                    <td class="txt-center">${item.action_taken}</td>
                    <td class="txt-center">${moment(item.date_completed).format('MMMM D, YYYY')}</td>
                    <td class="txt-center">${item.conducted_by}</td>
                    <td class="txt-center">
                        ${item.accepted_by_date != null && accepted_by_signature != null ? "<img src='uploads/signature/" + accepted_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                    </td>
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
                </tr>
            `;
        }

        // 8th row
        template += `<tr><td colspan="8" class="txt-right" style="border: none;">* Note: Indicate the type (R-Repair) or (PM-Preventive Maintenance)</td></tr>`;
        

        table.append(template);
    });

}