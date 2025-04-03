$(document).on('click', 'a[data-role=generate]', function(){
    var pr_no = $(this).data('id');
    
    fetchWithdrawalData(pr_no);
    setTimeout(() => {
        // $('#report-modal').modal('toggle');
        let css = `
            @media print {
                @page {
                    size: A4 portrait;  /* Ensure page size is A4 in portrait orientation */
                }
            }
        `;

        var toPrint = document.getElementById('slip-form');
        var newTab = window.open('', '_blank');
        newTab.document.write('<html><head><title>' + document.title  + '</title>');

        // Link to an external CSS file
        newTab.document.write('<link rel="stylesheet" type="text/css" href="assets/css/report.css?v=' + new Date().getTime() + '">');
        newTab.document.write('<style>' + css + '</style>');

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

function fetchWithdrawalData(pr_no) {
    const url = 'database/withdrawal/get_withdrawal.php';

    var template = '';
    var tableHead = $('#withdrawal-table thead');
    tableHead.empty();
    var table = $('#withdrawal-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { pr_no }, (response) => {
        const rows = JSON.parse(response);

        const { item, delivered_to, date, cv, pr_no, ws_no, remarks, quantity_released, unit, description,
                prepared_by, prepared_by_signature, received_by, received_by_signature, received_date } = rows[0];

        let template = `
            <tr>
                <td colspan=2 width="20%" class="cell-title">Item / Material</td>
                <td colspan=2 class="txt-center">${ item }</td>
                <td width="10%" class="cell-title">WS. No:</td>
                <td width="20%" class="txt-center">${ ws_no }</td>
            </tr>
            <tr>
                <td colspan=2 class="cell-title">Delivered to:</td>
                <td colspan=2 class="txt-center">${ delivered_to }</td>
                <td class="cell-title">Date:</td>
                <td class="txt-center">${ moment(date).format('MMMM D, YYYY') }</td>
            </tr>
            <tr>
                <td colspan=2 class="cell-title">PR No.</td>
                <td colspan=2 class="txt-center">${ pr_no }</td>
                <td class="cell-title">CV #:</td>
                <td class="txt-center">${ cv }</td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="6">&nbsp;</td></tr>`;

        template += `
            <tr>
                <td class="cell-title">Quantity</td>
                <td class="cell-title">Unit</td>
                <td colspan=3 class="cell-title">Particular</td>
                <td class="cell-title">Remarks</td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="6">&nbsp;</td></tr>`;

        if (rows.length === 0) {
            // If no rows are found, display a "No records found" message
            template += `<tr><td colspan="6" class="txt-center">No records found</td></tr>`;
        } else {
            rows.forEach(row => {
                const { quantity_released, unit, description, remarks } = row;

                // Add the actual rows with data
                template += `<tr>`;
                template += `<td class="txt-center">${quantity_released}</td>`;
                template += `<td class="txt-center">${unit}</td>`;
                template += `<td colspan="3" class="txt-center">${description}</td>`;
                template += `<td class="txt-center">${remarks}</td>`;
                template += `</tr>`;
            });
        }

        // Dynamically add empty rows to fill the remaining height
        const tableHeight = table[0].clientHeight; // Get the current height of the table
        const pageHeight = 800; // Set the height limit (for example, 800px is the max height of the page or container)
        const rowHeight = 25; // The height of each row (you might need to adjust this based on your design)
        const remainingRows = Math.floor((pageHeight - tableHeight) / rowHeight); // Calculate how many rows can fit in the remaining space

        // Add empty rows to fill the remaining space
        for (let i = 0; i < remainingRows; i++) {
            template += `
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td colspan=2></td>
                    <td></td>
                    <td></td>
                </tr>
            `;
        }

        // Check if the number of rows is less than 30, and add more rows
        template += `
            <tr>
                <td colspan=3 style="border: none;">
                    <br>
                    <span class="txt-bold">Prepared by: </span>
                    <br>
                    <div style="margin-left: 50px;">
                        ${prepared_by != null && prepared_by_signature != null ? "<img src='uploads/signature/" + prepared_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <br>
                        <u>${ prepared_by || '' }</u>
                        <br>
                        Property In-Charge
                    </div>
                </td>
                <td style="border: none;"></td>
                <td colspan=3 style="border: none;">
                    <br>
                    <span class="txt-bold" style="margin-right: 120px;">Received by: </span>
                    <br>
                    <div style="margin-left: 50px;">
                        ${received_date != null && received_by_signature != null ? "<img src='uploads/signature/" + received_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <br>
                        <u>${ received_by || '' }</u>
                        <br>
                        Requestor / End User
                    </div>
                </td>
            </tr>
        `;

        table.append(template);

    });

}