<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">For Disposal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="form-label">Date</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="col-md-4">
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
                    
                    <div class="col-md-5">
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

                <!-- Row for Report -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Upload Incident Report</label><span class="text-danger">*</span>
                        <input type="file" accept="application/pdf" name="file" class="form-control" id="fileInput" required>
                        <small>Note: Please upload your report <code>PDF</code> file type.</small>
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
                                    <th>Property Type</th>
                                    <th>Property Code</th>
                                    <th>Brand</th>
                                    <th>Part Code / SN</th>
                                    <th>Condition</th>
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