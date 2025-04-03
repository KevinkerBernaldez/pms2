// Add item to the table
$('#btnAdd').on('click', function() {
    var item_id = $('input[name="item_category"]:checked').val();
    var selectedOption = $('select[name="item_category"]').find('option:selected');

    var pr_no = $('input[name="pr_no"]').val();
    var date_purchase = $('input[name="date_purchase"]').val();
    
    // Validate inputs
    if (pr_no == '') {
        Swal.fire('System Message', "Please input PR Number!", 'info');
        return;
    }
    if (date_purchase == '') {
        Swal.fire('System Message', "Please select date purchase!", 'info');
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
        var description = currentRow.find('td').eq(3).find('input').val();

    });

    // Create a new row and append it to the table
    var newRow = `
        <tr>
            <td style="display: none;">${selectedOption.data('id')}</td>
            <td><input type="number" name="quantity_received[]" min="1" class="form-control"></td>
            <td><input type="text" name="unit[]" class="form-control"></td>
            <td><input type="text" name="description[]" class="form-control"></td>
            <td><input type="date" name="date_released[]" class="form-control"></td>
            <td><input type="text" name="ws_no[]" class="form-control"></td>
            <td><input type="number" name="quantity_released[]" min="1" class="form-control"></td>
            <td><button class="btn btn-danger btnRemove"><i class="bi bi-trash"></i></button></td>
        </tr>`;

    $('#item-table tbody').append(newRow);

});

// Delegate click event to dynamically added remove buttons
$('#item-table').on('click', '.btnRemove', function() {
    $(this).closest('tr').remove();
});

$('.btnReport').click(function(event) {
    event.preventDefault(); // Prevent form submission

    // Get the values from the form fields
    var category = $('select[name="category"]').val();
    var user_in_charge = $('select[name="user_in_charge"]').val();
    var fromYear = $('#fromYear').val();
    var toYear = $('#toYear').val();

    // Check if all fields are filled out
    if (!category || !fromYear || !toYear || !user_in_charge) {
        alert('Please fill in all fields.');
        return;
    }

    // Ensure that the "To Year" is not less than "From Year"
    if (parseInt(toYear) < parseInt(fromYear)) {
        alert('The "To Year" must not be less than the "From Year".');
        return;
    }

    $('#periodText').text(fromYear + ' - ' + toYear);
    // Remove any checkmarks and reset all underlines
    document.querySelectorAll('.category').forEach(span => {
        // Reset text and remove checkmark if any
        span.innerHTML = span.innerHTML.replace('✔️ ', '').replace('<u>', '').replace('</u>', '');
        span.style.textDecoration = '';  // Reset text decoration (underline)
    });

    // Add checkmark to the selected category and remove underline
    if (category === 'Construction Materials') {
        let element = document.getElementById('construction-materials');
        element.innerHTML = '✔️ ' + element.innerHTML.replace('___ ', '');  // Add checkmark
        element.style.textDecoration = 'none';  // Remove the underline
    } else if (category === 'Office Supplies') {
        let element = document.getElementById('office-supplies');
        element.innerHTML = '✔️ ' + element.innerHTML.replace('___ ', '');  // Add checkmark
        element.style.textDecoration = 'none';  // Remove the underline
    } else if (category === 'Spareparts') {
        let element = document.getElementById('spareparts');
        element.innerHTML = '✔️ ' + element.innerHTML.replace('___ ', '');  // Add checkmark
        element.style.textDecoration = 'none';  // Remove the underline
    } else if (category === 'Others') {
        let element = document.getElementById('others');
        element.innerHTML = '✔️ ' + element.innerHTML.replace('___ ', '');  // Add checkmark
        element.style.textDecoration = 'none';  // Remove the underline
    }

    fetchLogsheetData(user_in_charge, category, fromYear, toYear);

    setTimeout(() => {
        // $('#report-modal').modal('toggle');
        let css = `
            @media print {
                @page {
                    size: A4 landscape;  /* Ensure page size is A4 in landscape orientation */
                }
            }
        `;
        
        var toPrint = document.getElementById('report-form');
        var newTab = window.open('', '_blank');
        newTab.document.write('<html><head><title>' + document.title  + '</title>');
        newTab.document.write('<style>' + css + '</style>');

        // Link to an external CSS file
        newTab.document.write('<link rel="stylesheet" type="text/css" href="assets/css/report.css?v=' + new Date().getTime() + '">');

        newTab.document.write('</head><body>');
        newTab.document.write(toPrint.innerHTML);
        newTab.document.write('</body></html>');

        newTab.document.close(); // necessary for IE >= 10
        // Wait for the CSS and other resources to fully load before printing
        newTab.onload = function() {
            newTab.print();
        };
    
        // Focus on the new tab
        newTab.focus();
    }, 500); // Delay of 500 milliseconds (0.5 seconds)

});


function fetchLogsheetData(user_in_charge, category, fromYear, toYear) {
    const url = 'database/logsheet/get_logsheet.php';

    var template = '';
    var table = $('#report-table thead');
    table.empty();

    var tableBody = $('#report-table tbody');
    tableBody.empty();
    template += `
            <tr>
                <th width="8%">PR No.</th>
                <th width="10%">Date of Purchase</th>
                <th>QTY</th>
                <th>UNIT</th>
                <th width="36%">Description</th>
                <th>Date Released</th>
                <th>WS No.</th>
                <th width="6%">QTY RELEASED</th>
                <th>WITHDRAWN BY <br> <small>(Signature Over Printed Name)</small></th>
            </tr>
        `;

    $.ajaxSetup({async: false});
    $.get(url, { user_in_charge, category, fromYear, toYear }, (response) => {
        console.log(response);
        const rows = JSON.parse(response);
        const rowHeight = 30; // Approximate height of a row in pixels (adjust as needed)
        const tableHeight = window.innerHeight - document.querySelector('thead').offsetHeight; // Subtract header height
        const footerHeight = 130; // Get footer height
        const availableHeight = tableHeight - footerHeight; // Calculate available height for the table rows
        const requiredRows = Math.floor(availableHeight / rowHeight); // Calculate the required number of rows to fill the space before the footer
        
        if (rows.length === 0) {
            // If no rows are found, display a "No records found" message
            template += `<tr><td colspan="9" class="text-center">No records found</td></tr>`;
        } else {
            rows.forEach(row => {
                console.log(row);
                const { pr_no, date_purchase, quantity_received, unit, description, date_released, ws_no, quantity_released, fname, lname, signature, received_date } = row;

                template += `<tr>`;
                template += `<td>${pr_no}</td>`;
                template += `<td>${date_purchase}</td>`;
                template += `<td>${quantity_received}</td>`;
                template += `<td>${unit}</td>`;
                template += `<td>${description}</td>`;
                template += `<td>${date_released}</td>`;
                template += `<td>${ws_no}</td>`;
                template += `<td>${quantity_released}</td>`;
                template += `<td>
                                <center>
                                    ${received_date != null && signature != null ? "<img src='uploads/signature/" + signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                                    <br>
                                    ${fname} ${lname}
                                </center>
                            </td>`;
                template += `</tr>`;
            });
        }


        // If there are fewer rows than required, add empty rows to fill the page
        const remainingRows = requiredRows - rows.length;
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
            `; // Add an empty row
        }
        
        table.append(template);
    });
    
}