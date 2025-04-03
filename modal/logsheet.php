<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Received and Issued Logsheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id">
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="d-inline me-3">
                            <input type="radio" name="item_category" value="Construction Materials" required>
                            <label for="option1">Construction Materials</label>
                        </div>
                        <div class="d-inline me-3">
                            <input type="radio" name="item_category" value="Office Supplies" required>
                            <label for="option2">Office Supplies</label>
                        </div>
                        <div class="d-inline me-3">
                            <input type="radio" name="item_category" value="Spareparts" required>
                            <label for="option3">Spareparts</label>
                        </div>
                        <div class="d-inline">
                            <input type="radio" name="item_category" value="Others" required>
                            <label for="option4">Others</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">PR No.</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="pr_no" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date of Purchase<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_purchase" required>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Withdrawn By</label><span class="text-danger">*</span>
                        <select class="form-select" name="user_id" required>
                            <option selected value="" disabled hidden>Select staff</option>

                            <?php 
                                require_once('database/config.php');
                                $query = "SELECT * FROM users WHERE `status` = 'Active';";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)) {
                                    $id = $row['id'];
                                    $fname = $row['fname'];
                                    $lname = $row['lname'];
                            ?>
                                <option value="<?php echo $id?>"><?php echo $lname.', '.$fname?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <br>
                        <button type="button" class="btn btn-primary font-weight-bold" id="btnAdd"> Add</button>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="item-table">
                            <thead>
                                <tr class="text-center">
                                    <th style="display: none;">No.</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Description</th>
                                    <th>Date Released</th>
                                    <th>WS No.</th>
                                    <th>Qty Released</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" id="btnSave" class="btn btn-primary px-5 py-2">Submit</button>
                </div>
            </div>
            
        </div>
    </div>
</div>