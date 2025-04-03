<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">History Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="history-form" autocomplete="off">
                    <input type="hidden" id="inventory_id" name="inventory_id">

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Other details</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="other_details" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Type (R/PM)</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="type" require>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date</label><span class="text-danger">*</span>
                            <input type="date" class="form-control" name="date" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Job Order Number</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="job_order_no" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Trouble/Problem Check-up</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="problem" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Action Taken/ Repair Results</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="action_taken" require>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Date Completed</label><span class="text-danger">*</span>
                            <input type="date" class="form-control" name="date_completed" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Test Conducted by</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="conducted_by" required>
                        </div>
                    </div>
                    

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="btnSave" class="btn btn-primary px-5 py-2">Submit</button>
                    </div>
                </form>
            </div>
            
            
            <!-- <div class="row mb-3">
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> -->

        </div>
    </div>
</div>