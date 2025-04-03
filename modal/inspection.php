<div class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Repair and Maintenance Inspection Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="inspection-form" autocomplete="off">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No.</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="request_no" readonly>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Date Inspected<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_inspected" required>
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