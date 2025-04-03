$(document).on('click', 'a[data-role=generate]', function(){
    var request_no = $(this).data('id');
    if (request_no) {

        fetchRequestData(request_no);
        setTimeout(() => {
            var toPrint = document.getElementById('report-form');
            var newTab = window.open('', '_blank');
            
            // Write the initial HTML structure
            newTab.document.write('<html><head><title>' + document.title + '</title>');
        
            // Link to the external CSS file
            newTab.document.write('<link rel="stylesheet" type="text/css" href="assets/css/request_report.css?v=' + new Date().getTime() + '">');
            newTab.document.write('</head><body>');
            newTab.document.write(toPrint.innerHTML);
            newTab.document.write('</body></html>');
            
            // Close the document to apply changes
            newTab.document.close();
            
            // Wait for the CSS and other resources to fully load before printing
            newTab.onload = function() {
                newTab.print();
            };
        
            // Focus on the new tab
            newTab.focus();
        }, 500); // Delay of 500 milliseconds (0.5 seconds)
        
    }
    else {
        alert('Form not yet created!');
    }

});
            
function fetchRequestData(request_no) {
    const url = 'database/request/fetch_request.php';

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
        const { request_no, request_type, request_type_others, department, date_requested, location, date_action, details, requested_by, 
            requested_by_signature, endorsed_by, endorsed_by_signature, recommend_by, recommend_by_signature, approved_by, approved_by_signature } = rows[0];
        
        template += `
            <tr>
                <td>&nbsp;</td>
                <td width=70%>&nbsp;</td>
                <td class="txt-right">No. <u>${request_no}</u></td>
            </tr>
            <tr>
                <td colspan=3 style="padding-top: 10px; padding-bottom: 10px; font-weight: bold;">
                    <center>
                        REPAIR AND MAINTENANCE REQUEST FORM
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
                <td class="cell-text">
                    <b>Department Requested:</b> 
                    <span class="shared-text" style="width: calc(45%);">${department}</span>
                </td>
                <td class="cell-text">
                    <b>Date Requested:</b> 
                    <span class="shared-text" style="width: calc(55%);">${moment(date_requested).format('MMMM D, YYYY')}</span>
                </td>
            </tr>
        `;

        // 3rd row
        template += `
            <tr>
                <td class="cell-text">
                    <b>Location:</b> 
                    <span class="shared-text" style="width: calc(75%);">${location}</span>
                </td>
                <td class="cell-text">
                    <b>Date of Action:</b> 
                    <span class="shared-text" style="width: calc(60%);">${moment(date_action).format('MMMM D, YYYY')}</span>
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan="2" class="cell-text">
                    <b>Details of Request:</b> 
                    <span class="shared-text" style="width: calc(100%);">${details}</span>
                </td>
            </tr>
        `;
        
        // add empty space
        template += `<tr><td colspan="2">&nbsp;</td></tr>`;

        // Signatories (Requested by and Endorsed by)
        template += `
            <tr>
                <td>
                    <span class="txt-bold">Requested by: </span>
                    <br><br><br>
                    <div style="margin-left: 50px;">
                        ${requested_by != null && requested_by_signature != null ? "<img src='uploads/signature/" + requested_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ requested_by || '' }</u>
                        <br>
                        Signature over printer name
                    </div>
                </td>
                <td>
                    <span class="txt-bold">Endorsed by: </span>
                    <br><br><br>
                    <div style="margin-left: 50px;">
                        ${endorsed_by != null && endorsed_by_signature != null ? "<img src='uploads/signature/" + endorsed_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ endorsed_by || '' }</u>
                        <br>
                        Property Custodian
                    </div>
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="2">&nbsp;</td></tr>`;

        // Signatories (Recommending by and Approved by)
        template += `
            <tr>
                <td>
                    <span class="txt-bold">Recommending Approval: </span>
                    <br><br><br>
                    <div style="margin-left: 50px;">
                        ${recommend_by != null && recommend_by_signature != null ? "<img src='uploads/signature/" + recommend_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ recommend_by || '' }</u>
                        <br>
                        PMO
                    </div>
                </td>
                <td>
                    <span class="txt-bold">Approved by: </span>
                    <br><br><br>
                    <div style="margin-left: 50px;">
                        ${approved_by != null && approved_by_signature != null ? "<img src='uploads/signature/" + approved_by_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <u>${ approved_by || '' }</u>
                        <br>
                        Vice President for Administrative Affairs
                    </div>
                </td>
            </tr>
        `;

        table.append(template);
    });

}
