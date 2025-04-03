<div class="modal fade" id="feedback-modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Feedback Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="feedback-form" autocomplete="off">
                    <input type="hidden" name="request_no">
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Name of Office</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="office" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Position</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="position" required>
                        </div>
                    </div>

                    <p>Service Rendered: Pls. Select the appropriate space provided</p>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="d-inline me-3">
                                <input type="radio" name="service_type" value="Air Condition Unit" required id="aircon" onclick="toggleOtherInput1()">
                                <label for="aircon">Air-condition Unit Repair / Maintenance</label>
                            </div>
                            <div class="d-inline me-3">
                                <input type="radio" name="service_type" value="Light Bulb" required id="bulb" onclick="toggleOtherInput1()">
                                <label for="bulb">Light Bulb Replacement</label>
                            </div>
                            <div class="d-inline me-3">
                                <input type="radio" name="service_type" value="Ceiling Fan" required id="fan" onclick="toggleOtherInput1()">
                                <label for="fan">Ceiling Fan Repair / Maintenance</label>
                            </div>
                            <div class="d-inline">
                                <input type="radio" name="service_type" value="Others" required id="service-others" onclick="toggleOtherInput1()">
                                <label for="service-others">Others please specify</label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="text" id="service_type_others" name="service_type_others" class="form-control" placeholder="Please specify" readonly>
                        </div>
                    </div>

                    <p>Job Factors</p>

                    <!-- Job Factor 1 -->
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="qualityRating">1. The quality of work meets the standard</label>
                            <div id="qualityRating" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_one" value="3" required>
                                <label class="form-check-label" for="rating3">
                                    3 - Very Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_one" value="2" required>
                                <label class="form-check-label" for="rating2">
                                    2 - Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_one" value="1" required>
                                <label class="form-check-label" for="rating1">
                                    1 - Not Satisfactory
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Job Factor 2 -->
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="qualityRating">2. Able to complete the task as scheduled</label>
                            <div id="qualityRating" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_two" value="3" required>
                                <label class="form-check-label" for="rating3">
                                    3 - Very Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_two" value="2" required>
                                <label class="form-check-label" for="rating2">
                                    2 - Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_two" value="1" required>
                                <label class="form-check-label" for="rating1">
                                    1 - Not Satisfactory
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Job Factor 3 -->
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="qualityRating">3. Prompt in taking action</label>
                            <div id="qualityRating" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_three" value="3" required>
                                <label class="form-check-label" for="rating3">
                                    3 - Very Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_three" value="2" required>
                                <label class="form-check-label" for="rating2">
                                    2 - Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_three" value="1" required>
                                <label class="form-check-label" for="rating1">
                                    1 - Not Satisfactory
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Job Factor 4 -->
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="qualityRating">4. Condition of the item repaired/ replaced</label>
                            <div id="qualityRating" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_four" value="3" required>
                                <label class="form-check-label" for="rating3">
                                    3 - Very Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_four" value="2" required>
                                <label class="form-check-label" for="rating2">
                                    2 - Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_four" value="1" required>
                                <label class="form-check-label" for="rating1">
                                    1 - Not Satisfactory
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Job Factor 5 -->
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="qualityRating">5. Overall service rendered</label>
                            <div id="qualityRating" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_five" value="3" required>
                                <label class="form-check-label" for="rating3">
                                    3 - Very Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_five" value="2" required>
                                <label class="form-check-label" for="rating2">
                                    2 - Satisfactory
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jf_five" value="1" required>
                                <label class="form-check-label" for="rating1">
                                    1 - Not Satisfactory
                                </label>
                            </div>
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