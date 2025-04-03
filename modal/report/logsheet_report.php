<div id="report-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="report-form">
                <button class="btnPrint" style="background-color: #007BFF; color: white; padding: 15px 25px; border: none; border-radius: 5px; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#0056b3'" 
                    onmouseout="this.style.backgroundColor='#007BFF'" onclick="window.print()">PRINT
                </button>
                
                <div class="header">
                    <img src="assets/img/smcc-logo.png" alt="College Logo" class="logo">
                    <div class="header-content">
                        <h2>Saint Michael College of Caraga</h2>
                        <p>Brgy. 4, Nasipit, Agusan del Norte, Philippines</p>
                        <p>District 8, Brgy. Triangulo, Nasipit, Agusan del Norte, Philippines</p>
                        <p>Tel. Nos. +63 085 343-5231, 283-3113 | Fax: +63 085 898-0892</p>
                        <p><a href="http://www.smccnasipit.edu.ph">www.smccnasipit.edu.ph</a></p>
                        <h5>Period: <span id="periodText"></span></h5>
                        <h5>Property Management Office</h5>
                        <h5>RECEIVED AND ISSUED ITEMS LOGSHEET</h5>
                    </div>
                </div>

                <center>
                    <h4 class="category-message">
                        <span class="category" id="construction-materials">___ Construction Materials</span>
                        <span class="category" id="office-supplies">___ Office Supplies</span>
                        <span class="category" id="spareparts">___ Spareparts</span>
                        <span class="category" id="others">___ Others</span>
                    </h4>
                </center>
                
                <table id="report-table">
                    <thead></thead>
                    <tbody></tbody>
                </table>

                <!-- Footer with image -->
                <footer>
                    <table class="form-table">
                        <tr>
                            <th>Form Code No.</th>
                            <td>FM-DPM-SMCC-RII-01</td>
                        </tr>
                        <tr>
                            <th>Issue Status</th>
                            <td style="border-top: 0; border-bottom: 0;">02</td>
                        </tr>
                        <tr>
                            <th>Revision No.</th>
                            <td style="border-top: 0; border-bottom: 0;">00</td>
                        </tr>
                        <tr>
                            <th>Date Effective</th>
                            <td style="border-top: 0; border-bottom: 0;">02 April 2021</td>
                        </tr>
                        <tr>
                            <th>Approved By</th>
                            <td style="border-top: 0;">President</td>
                        </tr>
                    </table>
                    <img src="assets/img/footer.png" alt="Footer Image">
                </footer>
                
            </div>
        </div>
    </div>
</div> 