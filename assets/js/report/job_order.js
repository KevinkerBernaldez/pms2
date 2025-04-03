
$(document).on('click', 'a[data-role=generate]', function(){
    var request_no = $(this).data('id');
    fetchInspectionData(request_no);
    setTimeout(() => {
        var toPrint = document.getElementById('report-form');
        
        if ($('#request-table tbody').children().length === 0) {
            alert('No data available to generate report.');
            return;  // Stop the printing if no data is available
        }

        var newTab = window.open('', '_blank');
        newTab.document.write('<html><head><title>' + document.title + '</title>');

        // Link to an external CSS file
        newTab.document.write('<link rel="stylesheet" type="text/css" href="assets/css/request_report.css?v=' + new Date().getTime() + '">');

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
            
function fetchInspectionData(request_no) {
    const url = 'database/job_order/fetch_job_order.php';

    var template = '';
    var titleTable = $('#title-table tbody');
    titleTable.empty();

    // var tableHead = $('#request-table thead');
    // tableHead.empty();
    var table = $('#request-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { request_no }, (response) => {
        const rows = JSON.parse(response);
        if (rows.length == 0) {
            return;
        }
        const { request_no, repair_type, date_repair, department, transaction, remarks, technician_by, technician_by_signature, 
                verified_by, verified_by_signature, approved_by, approved_by_signature } = rows[0];
        
        template += `
            <tr>
                <td colspan=3 style="padding-top: 10px; padding-bottom: 10px; font-weight: bold;">
                    <center>
                        JOB ORDER
                    </center>
                </td>
            </tr>
            <tr>
                <td >Number: <u>${request_no}</u></td>
                <td>&nbsp;</td>
                <td width=70%>&nbsp;</td>
            </tr>
        `;

        titleTable.append(template);
 
        template = "";
        template += `
            <tr>
                <td colspan="3" style="padding-left: 150px;">
                    <h4 id="category-message">
                        <span class="category" id="maintenance">
                            ${repair_type.split(', ').includes("Maintenance") ? "__<u>✔</u>__ Maintenance" : "____ Maintenance"}
                        </span>
                        <br>
                        <span class="category" id="repair">
                            ${repair_type.split(', ').includes("Repair") ? "__<u>✔</u>__ Repair" : "_____ Repair"}
                        </span>
                        <br>
                        <span class="category" id="replacement">
                            ${repair_type.split(', ').includes("Replacement") ? "__<u>✔</u>__ Replacement" : "_____ Replacement"}
                        </span>
                    </h4>
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan="3" class="cell-text">
                    <b>Date:</b> 
                    <span class="shared-text" style="width: calc(20%);">${moment(date_repair).format('MMMM D, YYYY')}</span>
                </td>
            </tr>
        `;

        // 3rd row
        template += `
            <tr>
                <td colspan="3" class="cell-text">
                    <b>Name:</b> 
                    <span class="shared-text">${technician_by}</span>
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan="3" class="cell-text">
                    <b>Job location / Department:</b> 
                    <span class="shared-text" style="width: calc(70%);">${department}</span>
                </td>
            </tr>
        `;
        
        // 5th row
        template += `
            <tr>
                <td colspan="3" class="cell-text">
                    <b>Transaction:</b> 
                    <span class="shared-text" style="width: calc(100%);">${transaction}</span>
                </td>
            </tr>
        `;
        
        // 6th row
        template += `
            <tr>
                <td colspan="3" class="cell-text">
                    <b>Remarks:</b> 
                    <span class="shared-text" style="width: calc(100%);">${remarks}</span>
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="2">&nbsp;</td></tr>`;

        // Signatories (Inspectd by and Verified by)
        template += `
            <tr>
                <td>
                    <div>
                        ${technician_by != null && technician_by_signature != null ? "<img src='uploads/signature/" + technician_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ technician_by || '' }</u>
                        <br>
                        Head General Services
                    </div>
                </td>
                <td class="txt-right" width="40%">
                    <span class="txt-bold">Inspected/Verified by: </span>
                </td>
                <td>
                    ${verified_by != null && verified_by_signature != null ? "<img src='uploads/signature/" + verified_by_signature + "' alt='Signature' class='signature-image'>" : ""}
                    <u>${ verified_by || '' }</u>
                    <br>
                    Head, General Services
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="2">&nbsp;</td></tr>`;

        // Signatories (Conformed by and Approved by)
        template += `
            <tr>
                <td>
                    <table class="form-table" style="width: 100%;">
                        <tr>
                            <th>Form Code No.</th>
                            <td class="txt-bold">: FM-DPM-SMCC-HOR-01</td>
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
                            <td style="border-top: 0; border-bottom: 0;" class="txt-bold">: 27 January 2025</td>
                        </tr>
                        <tr>
                            <th>Approved By</th>
                            <td style="border-top: 0;" class="txt-bold">: President</td>
                        </tr>
                    </table>
                </td>
                <td class="txt-right">
                    <span class="txt-bold">Recommend Approval: </span>
                </td>
                <td>
                    ${approved_by != null && approved_by_signature != null ? "<img src='uploads/signature/" + approved_by_signature + "' alt='Signature' class='signature-image'>" : ""}
                    <u>${ approved_by || '' }</u>
                    <br>
                    PMO
                </td>
            </tr>
        `;

        table.append(template);
    });

}