<!-- resources/views/modals/order-detail-modal.blade.php -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i> Order Details #ORD-1001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> John Doe</p>
                        <p class="mb-1"><strong>Email:</strong> john@example.com</p>
                        <p class="mb-1"><strong>Phone:</strong> +1234567890</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Order Information</h6>
                        <p class="mb-1"><strong>Order Date:</strong> 2024-01-12</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-success">Delivered</span></p>
                        <p class="mb-1"><strong>Payment:</strong> <span class="badge bg-success">Paid</span></p>
                    </div>
                </div>
                <h6 class="text-primary mb-3">Order Items</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>The Great Gatsby</td>
                            <td>$15.99</td>
                            <td>2</td>
                            <td>$31.98</td>
                        </tr>
                        <tr>
                            <td>1984</td>
                            <td>$13.99</td>
                            <td>1</td>
                            <td>$13.99</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td><strong>$45.97</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                            <td><strong class="text-danger">-$5.00</strong></td>
                        </tr>
                        <tr class="table-primary">
                            <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                            <td><strong>$40.97</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"><i class="fas fa-print me-2"></i> Print Invoice</button>
            </div>
        </div>
    </div>
</div>