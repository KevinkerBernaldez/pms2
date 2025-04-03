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
        newTab.document.write('<html><head><title>' + document.title  + '</title>');

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
    const url = 'database/inspection/fetch_inspection.php';

    var template = '';
    var titleTable = $('#title-table tbody');
    titleTable.empty();

    var table = $('#request-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { request_no }, (response) => {
        const rows = JSON.parse(response);
        if (rows.length == 0) {
            return;
        }

        const { request_no, request_type, request_type_others, date_inspected, details, inspected_by, inspected_by_signature, 
                conformed_by, conformed_by_signature, verified_by, verified_by_signature, approved_by, approved_by_signature } = rows[0];
        
        template += `
            <tr>
                <td>&nbsp;</td>
                <td width=70%>&nbsp;</td>
                <td class="txt-right">No. <u>${request_no}</u></td>
            </tr>
            <tr>
                <td colspan=3 style="padding-top: 10px; padding-bottom: 10px; font-weight: bold;">
                    <center>
                        REPAIR AND MAINTENANCE INSPECTION REPORT
                    </center>
                </td>
            </tr>
        `;

        titleTable.append(template);
 
        template = "";
        template += `
            <tr>
                <td colspan="2">
                    <h4 id="category-message">
                        <span class="category" id="construction-materials">
                            ${request_type === "Structure/Building" ? "✔ Structure/Building" : "___ Structure/Building"}
                        </span>
                        <span class="category" id="office-supplies">
                            ${request_type === "Vehicle" ? "✔ Vehicle" : "___ Vehicle"}
                        </span>
                        <span class="category" id="spareparts">
                            ${request_type === "Equipment" ? "✔ Equipment" : "___ Equipment"}
                        </span>
                        <span class="category" id="others">
                            ${request_type === "Others" ? `✔ Others` : "___ Others"}
                        </span>
                        <span class="category">
                            ${request_type === "Others" && request_type_others ? ` (Specify) <u>${request_type_others}</u>` : ""}
                        </span>
                    </h4>
                </td>
            </tr>
        `;
        // 2nd row
        template += `
            <tr>
                <td colspan=2 class="cell-text">
                    <b>Date Inspected:</b> 
                    <span class="shared-text" style="width: calc(20%);">${moment(date_inspected).format('MMMM D, YYYY')}</span>
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan="2" class="cell-text">
                    <b>Details of Findings and recommendations:</b> 
                    <span class="shared-text" style="width: calc(100%);">${details}</span>
                </td>
            </tr>
        `;
        
        // add empty space
        template += `<tr><td colspan="2">&nbsp;</td></tr>`;

        // Signatories (Inspectd by and Verified by)
        template += `
            <tr>
                <td>
                    <span class="txt-bold">Inspected by: </span>
                    <br><br>
                    <div style="margin-left: 50px;">
                        ${inspected_by != null && inspected_by_signature != null ? "<img src='uploads/signature/" + inspected_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ inspected_by || '' }</u>
                        <br>
                        Head General Services
                    </div>
                </td>
                <td>
                    <span class="txt-bold">Verified by: </span>
                    <br><br>
                    <div style="margin-left: 50px;">
                        ${verified_by != null && verified_by_signature != null ? "<img src='uploads/signature/" + verified_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ verified_by || '' }</u>
                        <br>
                        Head PMO
                    </div>
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="2">&nbsp;</td></tr>`;

        // Signatories (Conformed by and Approved by)
        template += `
            <tr>
                <td>
                    <span class="txt-bold">Conformed: </span>
                    <br><br>
                    <div style="margin-left: 50px;">
                        ${conformed_by != null && conformed_by_signature != null ? "<img src='uploads/signature/" + conformed_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ conformed_by || '' }</u>
                        <br>
                        (Requisitioner)
                    </div>
                </td>
                <td>
                    <span class="txt-bold">Approved by: </span>
                    <br><br>
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
