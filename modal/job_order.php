<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Job Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="job-order-form" autocomplete="off">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">No.</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="request_no" readonly>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Date</label><span class="text-danger">*</span>
                            <input type="date" class="form-control" name="date_repair" required>
                        </div>

                        <div class="col-md-4">
                            <label>
                                <input type="checkbox" name="maintenanceOptions" value="Maintenance" onclick="updateRepairType()">
                                Maintenance
                            </label><br>

                            <label>
                                <input type="checkbox" name="maintenanceOptions" value="Repair" onclick="updateRepairType()">
                                Repair
                            </label><br>

                            <label>
                                <input type="checkbox" name="maintenanceOptions" value="Replacement" onclick="updateRepairType()">
                                Replacement
                            </label>
                        </div>
                        <input type="hidden" class="form-control" id="repairType" name="repair_type" required>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Technician Name</label><span class="text-danger">*</span>
                            <select class="form-select" name="technician" required onchange="updateTechName()">
                                <option selected value="" disabled hidden>Select technician / personnel</option>

                                <?php 
                                    require_once('database/config.php');
                                    $query = "SELECT * FROM technicians WHERE `status` = 'Active';";
                                    $result = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_array($result)) {
                                        $id = $row['id'];
                                        $name = $row['fname'] . ' ' . $row['lname'];
                                ?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option>
                                <?php } ?>
                            </select>

                            <input type="hidden" class="form-control" id="techName" name="tech_name" required>

                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department / Section / Office</label><span class="text-danger">*</span>
                            <select class="form-select" name="department" required>
                                <option selected value="" disabled hidden>Select department</option>

                                <?php 
                                    require_once('database/config.php');
                                    $query = "SELECT * FROM departments WHERE `status` = 'Active';";
                                    $result = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_array($result)) {
                                        $id = $row['id'];
                                        $department = $row['department'];
                                ?>
                                    <option value="<?php echo $id?>"><?php echo $department?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Transaction</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="transaction" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="remarks" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-2">Submit</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>