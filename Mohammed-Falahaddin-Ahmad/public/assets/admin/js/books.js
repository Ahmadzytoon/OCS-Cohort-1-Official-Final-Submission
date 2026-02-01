document.addEventListener('DOMContentLoaded', function () {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Existing filter functionality
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
    
    search.addEventListener('input', filterBooks);
    category.addEventListener('change', filterBooks);
    stock.addEventListener('change', filterBooks);
    
    // DISCOUNT MODAL HANDLING
    const discountForm = document.getElementById('discountForm');
    const modalTitle = document.getElementById('discountModalLabel');
    
    // Handle Add/Edit Discount button clicks
    document.querySelectorAll('.add-discount-btn, .edit-discount-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.getAttribute('data-book-id');
            const discountUrl = this.getAttribute('data-discount-url');
            const isEdit = this.classList.contains('edit-discount-btn');
            
            // Reset form and set mode
            discountForm.reset();
            modalTitle.textContent = isEdit ? 'Edit Discount' : 'Add Discount';
            discountForm.action = discountUrl;
            document.getElementById('book_id').value = bookId;
            
            // Pre-fill if editing
            if (isEdit) {
                document.getElementById('discount_type').value = this.getAttribute('data-discount-type');
                document.getElementById('discount_amount').value = this.getAttribute('data-discount-amount');
                const validUntil = this.getAttribute('data-valid-until');
                if (validUntil) document.getElementById('valid_until').value = validUntil;
            }
        });
    });
    
    // Handle Remove Discount button clicks
    document.querySelectorAll('.remove-discount-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.getAttribute('data-book-id');
            const bookTitle = this.getAttribute('data-book-title');
            const deleteUrl = this.getAttribute('data-delete-url');
            
            Swal.fire({
                title: 'Remove Discount?',
                text: `Are you sure you want to remove the discount from "${bookTitle}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff7b6b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('removeDiscountForm');
                    form.action = deleteUrl;
                    form.submit();
                }
            });
        });
    });
    
    // Handle Delete Book button clicks
    document.querySelectorAll('.delete-book-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bookTitle = this.getAttribute('data-book-title');
            const deleteUrl = this.getAttribute('data-delete-url');
            
            Swal.fire({
                title: 'Delete Book?',
                text: `Are you sure you want to delete "${bookTitle}"? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
    
    // Auto-close alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });
});