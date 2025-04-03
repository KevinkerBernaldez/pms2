<div class="modal fade" id="withdrawal-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Items / Materials Withdrawal Slip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="withdrawal-form" autocomplete="off">
                    <input type="hidden" name="id">
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="user_name">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Item / Material</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="item" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Delivered to:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="delivered_to" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CV #</label><span class="text-danger">*</span>
                            <input type="number" class="form-control" name="cv_number" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Remarks</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="remarks" value="Released" required>
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