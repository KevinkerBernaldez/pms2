$(document).on('click', '.btnReport', function() {
    // Get the values of the inputs
    var department = $('select[name="department"]').val();
    var month = $('select[name="month"]').val();
    var year = $('input[name="year"]').val();

    // Check if any of the values are empty
    if (!department || !month || !year) {
        // If any field is empty, show an alert using Swal
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please select all the required fields (In-Charge, Month, and Year).',
            confirmButtonText: 'OK'
        });
    } else {
        fetchInventoryData(department, month, year);

        setTimeout(() => {
            var toPrint = document.getElementById('report-form');
            
            if ($('#report-table tbody').children().length === 0) {
                alert('No data available to generate report.');
                return;  // Stop the printing if no data is available
            }
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
    }
});

function fetchInventoryData(department, month, year) {
    const item_url = 'database/summary/get_property_inventory_department.php';

    var template = '';
    var inventory_items = [];

    $.ajaxSetup({async: false});
    $.get(item_url, { department, month, year }, (response) => {
        inventory_items = JSON.parse(response);
    });
    if (inventory_items.length == 0) {
        return;
    }
    console.log(inventory_items);
    $.ajaxSetup({async: false});

    var table = $('#report-table tbody');
    table.empty();

    // 1st row
    template += `
        <tr>
            <td colspan=8>
                <span class="txt-bold">Department: </span> ${inventory_items[0].department}
            </td>
            </tr>
        `;
    
        // add empty space
    template += `<tr><td colspan="8" style="border: none;"></td></tr>`;
    
    // 2nd row
    template += `
        <tr>
            <td class="txt-center txt-bold">Property In-charge</td>
            <td class="txt-center txt-bold">Qty</td>
            <td class="txt-center txt-bold">UoM</td>
            <td class="txt-center txt-bold">Description</td>
            <td class="txt-center txt-bold">Brand</td>
            <td class="txt-center txt-bold">Part Code</td>
            <td class="txt-center txt-bold">Model #</td>
            <td class="txt-center txt-bold">Serial #</td>
        </tr>
    `;
    
    // add empty space
    template += `<tr><td colspan="8"></td></tr>`;

    const rowHeight = 30; // Approximate height of a row in pixels (adjust as needed)
    const tableHeight = 1230; // Subtract header height
    const footerHeight = 100; // Get footer height
    const availableHeight = tableHeight - footerHeight; // Calculate available height for the table rows
    const remainingRows = Math.floor(availableHeight / rowHeight); // Calculate the required number of rows to fill the space before the footer
    let previousInCharge = '';  // Keep track of the previous "in_charge" value

    inventory_items.forEach(item => {
        // Only show "in_charge" if it's different from the previous one
        const inChargeCell = item.in_charge !== previousInCharge ? `<td class="txt-center">${item.in_charge}</td>` : `<td></td>`;
    
        template += `
            <tr>
                ${inChargeCell}
                <td class="txt-center">${item.quantity}</td>
                <td class="txt-center">${item.unit}</td>
                <td class="txt-center">${item.description}</td>
                <td class="txt-center">${item.brand}</td>
                <td class="txt-center">${item.part_code}</td>
                <td class="txt-center">${item.model_number}</td>
                <td class="txt-center">${item.serial_number}</td>
            </tr>
        `;
        
        // Update the previous "in_charge" value
        previousInCharge = item.in_charge;
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
    
    
    table.append(template);

}