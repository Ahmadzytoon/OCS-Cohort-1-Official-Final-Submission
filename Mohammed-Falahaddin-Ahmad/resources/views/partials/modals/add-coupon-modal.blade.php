<!-- resources/views/modals/add-coupon-modal.blade.php -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-tags me-2"></i> Add Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Code *</label>
                            <input type="text" class="form-control" placeholder="e.g., SAVE20" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type *</label>
                            <select class="form-select" required>
                                <option>Percentage</option>
                                <option>Fixed Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Value *</label>
                            <input type="number" step="0.01" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Minimum Order Amount</label>
                            <input type="number" step="0.01" class="form-control" placeholder="0.00">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usage Limit</label>
                            <input type="number" class="form-control" placeholder="Unlimited">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date *</label>
                            <input type="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="couponActive" checked>
                            <label class="form-check-label" for="couponActive">Active</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Coupon</button>
            </div>
        </div>
    </div>
</div>