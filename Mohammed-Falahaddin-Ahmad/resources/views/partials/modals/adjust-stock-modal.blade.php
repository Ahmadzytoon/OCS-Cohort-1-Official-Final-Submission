<!-- resources/views/modals/adjust-stock-modal.blade.php -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-boxes me-2"></i> Adjust Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Select Book *</label>
                        <select class="form-select" required>
                            <option value="">Choose a book</option>
                            <option>The Great Gatsby</option>
                            <option>1984</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adjustment Type *</label>
                        <select class="form-select" required>
                            <option>Add Stock</option>
                            <option>Remove Stock</option>
                            <option>Set Stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity *</label>
                        <input type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="2" placeholder="Enter reason for stock adjustment"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Update Stock</button>
            </div>
        </div>
    </div>
</div>