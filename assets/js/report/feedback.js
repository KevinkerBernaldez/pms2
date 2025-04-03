$(document).on('click', 'a[data-role=feedback]', function(){
    var request_no = $(this).data('id');
    fetchFeedbackData(request_no);
    setTimeout(() => {
        var toPrint = document.getElementById('feedback-form');

        if ($('#feedback-table tbody').children().length === 0) {
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
            
function fetchFeedbackData(request_no) {
    const url = 'database/job_order/fetch_feedback.php';

    var template = '';

    var table = $('#feedback-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { request_no }, (response) => {
        const rows = JSON.parse(response);
        if (rows.length == 0) {
            return;
        }
        const { request_no, office, date, position, service, service_others, jf_one, jf_two, jf_three, jf_four, jf_five, average_rate,
                remarks, personnel, personnel_signature } = rows[0];
        
        // Request No
        template += `
            <tr>
                <td colspan="5">
                    <b>No:</b> 
                    <span"><u>${request_no}</u></span>
                </td>
            </tr>
            `;

        // Name of office and date
        template += `
            <tr>
                <td colspan="2">
                    <b>Name of Office:</b> 
                    <span class="shared-text" style="width: calc(45%);">${office}</span>
                </td>
                <td colspan="3" class="cell-text">
                    <b>Date:</b> 
                    <span class="shared-text" style="width: calc(55%);">${moment(date).format('MMMM D, YYYY')}</span>
                </td>
            </tr>
        `;

        // Name of personnel and position
        template += `
            <tr>
                <td colspan="2">
                    <b>Name of Persoonel:</b> 
                    <span class="shared-text" style="width: calc(45%);">${personnel}</span>
                </td>
                <td colspan="3" class="cell-text">
                    <b>Position:</b> 
                    <span class="shared-text" style="width: calc(55%);">${position}</span>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        `;

        // Service rendered
        template += `
            <tr>
                <td colspan="5" class="txt-bold border-top-right-left" style="padding-top: 10px; padding-left: 5px; padding-right: 5px;">
                    Service Rendered: Pls. Check the appropriate space provided:
                </td>
            </tr>
        `;

        template += `
            <tr>
                <td colspan="2" class="txt-bold border-left" style="padding-left: 5px;">
                    ${service === "Air Condition Unit" ? "__<u>✔</u>__ Air-condition Unit Repair/ Maintenance" : "_____ Air-condition Unit Repair/ Maintenance"}
                </td>
                <td colspan="3" class="txt-bold txt-right border-right" style="padding-right: 5px;">
                    ${service === "Ceiling Fan" ? "__<u>✔</u>__ Ceiling Fan Repair/ Maintenance" : "_____ Ceiling Fan Repair/ Maintenance"}
                </td>
            </tr>
        `;

        template += `
            <tr >
                <td colspan="2" class="txt-bold border-bottom-left" style="padding-bottom: 10px; padding-left: 5px;">
                    ${service === "Light Bulb" ? "__<u>✔</u>__ Light Bulb Replacement" : "_____ Light Bulb Replacement"}
                </td>
                <td colspan="3" class="txt-bold txt-right border-right-bottom" style="padding-bottom: 10px; padding-right: 5px;">
                    
                    ${service === "Others" && service_others ? `Others please specify: <u>${service_others}</u>` : "Others please specify:  __________________"}
                </td>
            </tr>
        `;

        // Instructions
        template += `
            <tr>
                <td colspan="5" class="txt-bold">
                    Instruction: Read each statement below and using the scale below, check the column that corresponds to your answers.
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="5">&nbsp;</td></tr>`;

        // Rate scale
        template += `
            <tr>
                <td colspan="5" class="txt-bold">
                    <span>3 - Very Satisfactory</span>
                    <span style="padding-left: 100px;">2 - Satisfactory</span>
                    <span style="padding-left: 100px;">1 - Not Satisfactory</span>
                </td>
            </tr>
        `;
        
        // add empty space
        template += `<tr><td colspan="5">&nbsp;</td></tr>`;

        // Header
        template += `
            <tr>
                <td colspan=2 class="txt-bold txt-center border-all">
                    Job Factors
                </td>
                <td class="txt-bold txt-center border-all">
                    3
                </td>
                <td class="txt-bold txt-center border-all">
                    2
                </td>
                <td class="txt-bold txt-center border-all">
                    1
                </td>
            </tr>   
        `;

        // Job factor one
        template += `
            <tr>
                <td colspan=2 class="txt-bold border-all">
                    1. The Quality of work meets the standard.
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_one == "3" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_one == "2" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_one == "1" ? "✔" : ""}
                </td>
            </tr>   
        `;

        // Job factor two
        template += `
            <tr>
                <td colspan=2 class="txt-bold border-all">
                    2. Able to complete the task as schedule.
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_two == "3" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_two == "2" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_two == "1" ? "✔" : ""}
                </td>
            </tr>   
        `;

        // Job factor three
        template += `
            <tr>
                <td colspan=2 class="txt-bold border-all">
                    3. Prompt in taking action.
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_three == "3" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_three == "2" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_three == "1" ? "✔" : ""}
                </td>
            </tr>   
        `;

        // Job factor four
        template += `
            <tr>
                <td colspan=2 class="txt-bold border-all">
                    4. Condition of the item repaired/ replaced.
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_four == "3" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_four == "2" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_four == "1" ? "✔" : ""}
                </td>
            </tr>   
        `;

        // Job factor five
        template += `
            <tr>
                <td colspan=2 class="txt-bold border-all">
                    5. Overall service rendered.
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_five == "3" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_five == "2" ? "✔" : ""}
                </td>
                <td class="txt-bold txt-center border-all">
                    ${jf_five == "1" ? "✔" : ""}
                </td>
            </tr>   
        `;

        template += `<tr>
                        <td class="txt-bold border-all">TOTAL</td>
                        <td colspan=4 class="txt-bold txt-center border-all">
                            ${average_rate}
                        </td>
                    </tr>`;

        // add empty space
        template += `<tr><td colspan="5">&nbsp;</td></tr>`;

        // Remarks
        template += `
            <tr>
                <td colspan="5" class="cell-text">
                    <b>Remarks:</b> 
                    <span class="shared-text" style="width: calc(100%);">${remarks}</span>
                </td>
            </tr>
        `;

        // add empty space
        template += `<tr><td colspan="5">&nbsp;</td></tr>`;

        // Signatory
        template += `
            <tr>
                <td>
                    <br>
                    <div>
                        ${personnel != null && personnel_signature != null ? "<img src='uploads/signature/" + personnel_signature + "' alt='Signature' class='signature-image'>" : "<br>"}
                        <br>
                        <u>${ personnel || '' }</u>
                        <br>
                        (Requisitioner Signature over printed name)
                    </div>
                </td>
            </tr>
        `;

        table.append(template);
    });

}
