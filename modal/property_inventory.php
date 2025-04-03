<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">For Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Property Code</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="property_code">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Date of Inventory</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="date_inventory" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date of Last Inventory</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="date_last_inventory" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">School Year</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="sy" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Area</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="area" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Property In-Charge</label><span class="text-danger">*</span>
                        <select class="form-select" name="in_charge" required>
                            <option selected value="" disabled hidden>Select personnel</option>

                            <?php 
                                require_once('database/config.php');

                                $query = "SELECT * FROM users WHERE `status` = 'Active';";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)) {
                                    $id = $row['id'];
                                    $department_id = $row['department_id'];
                                    $name = $row['fname'].' '. $row['lname'];
                            ?>
                                <option value="<?php echo $id?>" data-id="<?php echo $department_id?>"><?php echo $name?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Category</label><span class="text-danger">*</span>
                        <select class="form-select" name="category" required>
                            <option selected value="" disabled hidden>Select category</option>

                            <?php 
                                require_once('database/config.php');
                                $sess_id = $_SESSION['id'];

                                $query = "SELECT item_category FROM inventory WHERE `user_id` = '$sess_id' GROUP BY item_category;";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)) {
                                    $item_category = $row['item_category'];
                            ?>
                                <option value="<?php echo $item_category?>"><?php echo $item_category?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Item</label><span class="text-danger">*</span>
                        <select class="form-select" name="item_id" required>
                            <option selected value="" disabled hidden>Select item</option>
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
                                    <th>Brand</th>
                                    <th>Part Code</th>
                                    <th>Model #</th>
                                    <th>Serial #</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
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