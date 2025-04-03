<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Repair and Maintenance Request Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="request-form" autocomplete="off">
                    <input type="hidden" name="id">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="d-inline me-3">
                                <input type="radio" name="request_type" value="Structure/Building" required id="structure" onclick="toggleOtherInput()">
                                <label for="structure">Structure/Building</label>
                            </div>
                            <div class="d-inline me-3">
                                <input type="radio" name="request_type" value="Vehicle" required id="vehicle" onclick="toggleOtherInput()">
                                <label for="vehicle">Vehicle</label>
                            </div>
                            <div class="d-inline me-3">
                                <input type="radio" name="request_type" value="Equipment" required id="equipment" onclick="toggleOtherInput()">
                                <label for="equipment">Equipment</label>
                            </div>
                            <div class="d-inline">
                                <input type="radio" name="request_type" value="Others" required id="others" onclick="toggleOtherInput()">
                                <label for="others">Others</label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="text" id="otherInput" name="request_type_others" class="form-control" placeholder="Please specify" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Department Requested</label><span class="text-danger">*</span>
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
                        <div class="col-md-2">
                            <label class="form-label">Date Requested<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_requested" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Location</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="location" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Details of Request</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="details" required>
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