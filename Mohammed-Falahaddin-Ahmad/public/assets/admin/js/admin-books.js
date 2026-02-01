/**
 * Book Management Page JavaScript
 * Handles: Filtering, Discount Management, SweetAlert Integration
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ========================================
    // INITIALIZE TOOLTIPS
    // ========================================
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // ========================================
    // SWEETALERT2 CONFIGURATION
    // ========================================
    const Swal = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary me-2',
            cancelButton: 'btn btn-secondary',
            input: 'form-control'
        },
        buttonsStyling: false,
        confirmButtonText: 'Yes, confirm',
        cancelButtonText: 'Cancel'
    });

    // ========================================
    // SHOW SUCCESS ALERT
    // ========================================
    window.showSuccessAlert = function(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    };

    // ========================================
    // SHOW ERROR ALERT
    // ========================================
    window.showErrorAlert = function(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            toast: true,
            position: 'top-end',
            timer: 5000,
            showConfirmButton: false,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    };

    // ========================================
    // BOOK FILTERING FUNCTIONALITY
    // ========================================
    const search = document.getElementById('searchBooks');
    const category = document.getElementById('filterCategory');
    const stock = document.getElementById('filterStock');
    const rows = document.querySelectorAll('#booksTableBody tr');

    function filterBooks() {
        const s = search.value.toLowerCase();
        const c = category.value;
        const st = stock.value;
        
        rows.forEach(row => {
            if (!row.dataset.title) return;
            
            const title = row.dataset.title;
            const isbn = row.dataset.isbn;
            const author = row.dataset.author;
            const cat = row.dataset.category;
            const stockType = row.dataset.stock;
            
            const matchSearch = title.includes(s) || isbn.includes(s) || author.includes(s);
            const matchCategory = c === '' || c === cat;
            const matchStock = st === '' || st === stockType;
            
            row.style.display = (matchSearch && matchCategory && matchStock) ? '' : 'none';
        });
    }
    
    // Event listeners for filters
    if (search) search.addEventListener('input', filterBooks);
    if (category) category.addEventListener('change', filterBooks);
    if (stock) stock.addEventListener('change', filterBooks);

    // ========================================
// DISCOUNT MODAL HANDLING
// ========================================
const discountForm = document.getElementById('discountForm');
const modalTitle = document.getElementById('discountModalLabel');
const discountModalElement = document.getElementById('discountModal');

// Handle Add/Edit Discount button clicks
document.querySelectorAll('.add-discount-btn, .edit-discount-btn').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.getAttribute('data-book-id');
        const isEdit = this.classList.contains('edit-discount-btn');
        
        // Reset form and set mode
        if (discountForm) {
            discountForm.reset();
            modalTitle.textContent = isEdit ? 'Edit Discount' : 'Add Discount';
            discountForm.action = `/admin/books/${bookId}/discount`;
            document.getElementById('book_id').value = bookId;
            
            // Pre-fill if editing
            if (isEdit) {
                document.getElementById('discount_type').value = this.getAttribute('data-discount-type');
                document.getElementById('discount_amount').value = this.getAttribute('data-discount-amount');
                const validUntil = this.getAttribute('data-valid-until');
                if (validUntil) document.getElementById('valid_until').value = validUntil;
            }
        }
    });
});

// ========================================
// REMOVE DISCOUNT HANDLER
// ========================================
document.querySelectorAll('.remove-discount-btn').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.getAttribute('data-book-id');
        const bookTitle = this.getAttribute('data-book-title');
        
        Swal.fire({
            title: 'Remove Discount?',
            text: `Are you sure you want to remove the discount from "${bookTitle}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form programmatically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/books/${bookId}/discount`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                // Add DELETE method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});

// ========================================
// DELETE BOOK HANDLER
// ========================================
document.querySelectorAll('.delete-book-btn').forEach(button => {
    button.addEventListener('click', function() {
        const bookTitle = this.getAttribute('data-book-title');
        const deleteUrl = this.getAttribute('data-delete-url');
        
        Swal.fire({
            title: 'Delete Book?',
            html: `Are you sure you want to delete <strong>"${bookTitle}"</strong>?<br><small class="text-muted">This action cannot be undone.</small>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit delete form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                // Add DELETE method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});

// ========================================
// DISCOUNT FORM SUBMISSION
// ========================================
if (discountForm) {
    discountForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default submission
        
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...';
        
        // Submit form using fetch API for better feedback
        const formData = new FormData(this);
        const url = this.action;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessAlert(data.message || 'Discount applied successfully!');
                // Reload page after 1 second
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showErrorAlert(data.message || 'Failed to apply discount');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Apply Discount';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorAlert('An error occurred. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Apply Discount';
        });
    });
}
    // ========================================
    // AUTO-CLOSE ALERTS (Bootstrap)
    // ========================================
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });

    // ========================================
    // TABLE ROW HOVER EFFECTS
    // ========================================
    document.querySelectorAll('#booksTableBody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    // ========================================
    // KEYBOARD SHORTCUTS
    // ========================================
    document.addEventListener('keydown', function(e) {
        // Ctrl + F to focus search
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            if (search) search.focus();
        }
    });

    console.log('Book Management JS loaded successfully');
});