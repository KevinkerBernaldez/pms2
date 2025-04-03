$(document).on('click', '.btnReport', function() {
    // Get the values of the inputs
    var in_charge = $('select[name="user_in_charge"]').val();
    var month = $('select[name="month"]').val();
    var year = $('input[name="year"]').val();

    // Check if any of the values are empty
    if (!in_charge || !month || !year) {
        // If any field is empty, show an alert using Swal
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please select all the required fields (In-Charge, Month, and Year).',
            confirmButtonText: 'OK'
        });
    } else {
        // If all values are present, proceed with your desired action (e.g., call a function)
        // For example, you can call your `getData` function
        fetchInventoryData(in_charge, month, year);

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

function fetchInventoryData(in_charge, month, year) {
    const url = 'database/summary/fetch_inventory.php';
    const item_url = 'database/summary/get_inventory_items.php';
    const count_url = 'database/summary/get_inventory_item_count.php';

    var template = '';
    var inventory_items = [];
    var count_items = [];

    $.ajaxSetup({async: false});
    $.get(item_url, { in_charge, month, year }, (response) => {
        inventory_items = JSON.parse(response);
    });

    console.log(inventory_items);

    $.ajaxSetup({async: false});
    $.get(count_url, { in_charge, month, year }, (response) => {
        count_items = JSON.parse(response);
    });

    var table = $('#report-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { in_charge, month, year }, (response) => {
        const rows = JSON.parse(response);
        if (rows.length == 0) {
            return;
        }
        const { date_inventory, date_last, property_code, department, item_category, sy, in_charge } = rows[0];

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
                    <span class="txt-bold">Property In-Charge: </span> ${in_charge}
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
                    ${item_category}
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

        // add empty space
        template += `<tr><td colspan="9" style="border: none;">&nbsp;</td></tr>`;

        // Signatories (Legend & Property In Charge)
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    <table border="1" width="100%">
                        <tbody>
                            <tr>
                                <td colspan=2 style="border: none; font-size: 8px;">TOTAL:</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 30px; border: none;">B - Borrowed = ${ count_items[0].count_B }</td>
                                <td style="font-size: 8px; border: none;">F - Functional =  ${ count_items[0].count_F }</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 30px; border: none;">L - Lost =  ${ count_items[0].count_L }</td>
                                <td style="font-size: 8px; border: none;">D - Damage/Defective =  ${ count_items[0].count_D }</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8px; text-indent: 30px; border: none;">U - Under Repair =  ${ count_items[0].count_U }</td>
                                <td style="font-size: 8px; border: none;">G - Good =  ${ count_items[0].count_G }</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan=5 style="border: none;">
                </td>
            </tr>
        `;


        table.append(template);
    });

}