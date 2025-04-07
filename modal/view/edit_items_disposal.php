<div class="modal fade" id="edit-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">View Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="text" id="disposal_id">
                        <input type="text" id="edit_id">
                        <table class="table table-bordered" id="view-table">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Property Type</th>
                                    <th>Property Code</th>
                                    <th>Brand</th>
                                    <th>Part Code / SN</th>
                                    <th>Condition</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="btnSaveEdit" class="btn btn-primary px-5 py-2">Submit</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>