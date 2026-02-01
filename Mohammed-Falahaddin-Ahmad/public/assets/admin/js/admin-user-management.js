/**
 * User Management Module
 * Handles all user management functionality including:
 * - SweetAlert2 notifications
 * - User actions (block/restore)
 * - Form validation and submission
 * - Search and filtering
 */
const UserManagement = (function() {
    'use strict';

    // Private variables
    let config = {
        searchInput: null,
        statusFilter: null,
        clearSearchBtn: null,
        resetFiltersBtn: null,
        rows: []
    };

    // Initialize the module
    function init() {
        // Cache DOM elements
        cacheElements();
        
        // Initialize event listeners
        initEventListeners();
        
        // Show session messages if any
        showSessionMessages();
        
        // Show validation errors if any
        showValidationErrors();
    }

    // Cache DOM elements for better performance
    function cacheElements() {
        config.searchInput = document.getElementById('searchUsers');
        config.statusFilter = document.getElementById('filterStatus');
        config.clearSearchBtn = document.getElementById('clearSearch');
        config.resetFiltersBtn = document.getElementById('resetFilters');
        config.rows = Array.from(document.querySelectorAll('#usersTableBody tr'));
    }

    // Initialize all event listeners
    function initEventListeners() {
        // Search functionality
        if (config.searchInput) {
            config.searchInput.addEventListener('input', handleSearch);
        }

        // Status filter
        if (config.statusFilter) {
            config.statusFilter.addEventListener('change', handleFilter);
        }

        // Clear search button
        if (config.clearSearchBtn) {
            config.clearSearchBtn.addEventListener('click', clearSearch);
        }

        // Reset filters button
        if (config.resetFiltersBtn) {
            config.resetFiltersBtn.addEventListener('click', resetFilters);
        }

        // Restore user buttons
        document.querySelectorAll('.restore-user-btn').forEach(btn => {
            btn.addEventListener('click', handleRestoreUser);
        });

        // Block user buttons
        document.querySelectorAll('.block-user-btn').forEach(btn => {
            btn.addEventListener('click', handleBlockUser);
        });

        // Toggle password visibility
        const togglePasswordBtn = document.getElementById('togglePassword');
        if (togglePasswordBtn) {
            togglePasswordBtn.addEventListener('click', togglePasswordVisibility);
        }
    }

    // ========================================
    // SEARCH & FILTER FUNCTIONS
    // ========================================

    function handleSearch(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        
        // Show/hide clear button
        if (config.clearSearchBtn) {
            config.clearSearchBtn.style.display = searchTerm ? 'block' : 'none';
        }

        filterTable();
    }

    function handleFilter() {
        filterTable();
    }

    function filterTable() {
        const searchTerm = config.searchInput ? config.searchInput.value.toLowerCase().trim() : '';
        const statusFilter = config.statusFilter ? config.statusFilter.value : 'all';

        config.rows.forEach(row => {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            const phone = row.dataset.phone || '';
            const status = row.dataset.status || 'active';

            // Check search match
            const searchMatch = searchTerm === '' || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                phone.includes(searchTerm);

            // Check status match
            let statusMatch = true;
            if (statusFilter === 'active') {
                statusMatch = status === 'active';
            } else if (statusFilter === 'blocked') {
                statusMatch = status === 'blocked';
            }

            // Show/hide row
            row.style.display = (searchMatch && statusMatch) ? '' : 'none';
        });

        // Update empty state
        updateEmptyState();
    }

    function clearSearch() {
        if (config.searchInput) {
            config.searchInput.value = '';
            config.searchInput.focus();
        }
        if (config.clearSearchBtn) {
            config.clearSearchBtn.style.display = 'none';
        }
        filterTable();
    }

    function resetFilters() {
        if (config.searchInput) config.searchInput.value = '';
        if (config.statusFilter) config.statusFilter.value = 'all';
        if (config.clearSearchBtn) config.clearSearchBtn.style.display = 'none';
        filterTable();
    }

    function updateEmptyState() {
        const visibleRows = config.rows.filter(row => row.style.display !== 'none');
        const emptyState = document.querySelector('.empty-state');
        
        if (emptyState && visibleRows.length === 0) {
            emptyState.closest('tr').style.display = '';
        } else if (emptyState) {
            emptyState.closest('tr').style.display = 'none';
        }
    }

    // ========================================
    // SWEET ALERT NOTIFICATIONS
    // ========================================

    function showSessionMessages() {
        // Success message
        const successEl = document.getElementById('session-success');
        if (successEl && successEl.dataset.message) {
            showSuccess(successEl.dataset.message);
        }

        // Error message
        const errorEl = document.getElementById('session-error');
        if (errorEl && errorEl.dataset.message) {
            showError(errorEl.dataset.message);
        }

        // Warning message
        const warningEl = document.getElementById('session-warning');
        if (warningEl && warningEl.dataset.message) {
            showWarning(warningEl.dataset.message);
        }
    }

    function showValidationErrors() {
        const validationErrors = document.getElementById('validation-errors');
        if (validationErrors && validationErrors.innerHTML.trim()) {
            const errors = Array.from(validationErrors.children).map(el => el.textContent);
            
            showError('Validation Failed', errors.join('<br>'));
            
            // Auto-open modal if there are validation errors
            const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
            modal.show();
        }
    }

    function showSuccess(title, text = '') {
        Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'colored-toast'
            },
            background: '#d4edda',
            iconColor: '#155724'
        });
    }

    function showError(title, text = '') {
        Swal.fire({
            icon: 'error',
            title: title,
            html: text,
            timer: 5000,
            showConfirmButton: true,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'colored-toast'
            },
            background: '#f8d7da',
            iconColor: '#721c24'
        });
    }

    function showWarning(title, text = '') {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            timer: 4000,
            showConfirmButton: true,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'colored-toast'
            },
            background: '#fff3cd',
            iconColor: '#856404'
        });
    }

    function showLoading(title = 'Loading...') {
        Swal.fire({
            title: title,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function closeLoading() {
        Swal.close();
    }

    // ========================================
    // USER ACTION HANDLERS
    // ========================================

    function handleRestoreUser(e) {
        const btn = e.currentTarget;
        const userId = btn.dataset.id;
        const userName = btn.dataset.name;

        Swal.fire({
            title: 'Restore User?',
            html: `
                <p>Are you sure you want to restore <strong>${escapeHtml(userName)}</strong>?</p>
                <p class="text-muted small mt-2">This user will be able to access the system again.</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check me-2"></i>Yes, Restore!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
            reverseButtons: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                restoreUser(userId);
            }
        });
    }

    function handleBlockUser(e) {
        const btn = e.currentTarget;
        const userId = btn.dataset.id;
        const userName = btn.dataset.name;

        Swal.fire({
            title: 'Block User?',
            html: `
                <p>Are you sure you want to block <strong>${escapeHtml(userName)}</strong>?</p>
                <p class="text-muted small mt-2">This user will lose access to the system.</p>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-ban me-2"></i>Yes, Block!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
            reverseButtons: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                blockUser(userId);
            }
        });
    }

    function restoreUser(userId) {
        showLoading('Restoring user...');
        
        const form = document.getElementById('restoreUserForm');
        form.action = `/admin/users/${userId}/restore`;
        form.submit();
    }

    function blockUser(userId) {
        showLoading('Blocking user...');
        
        const form = document.getElementById('blockUserForm');
        form.action = `/admin/users/${userId}`;
        form.submit();
    }

    // ========================================
    // FORM SUBMISSION
    // ========================================

    function submitUserForm() {
        const name = document.getElementById('display-name')?.value.trim();
        const email = document.getElementById('display-email')?.value.trim();
        const phone = document.getElementById('display-phone')?.value.trim();
        const password = document.getElementById('display-password')?.value;

        // Basic validation
        if (!name) {
            showError('Validation Error', 'Please enter a name');
            return;
        }

        if (!email) {
            showError('Validation Error', 'Please enter an email address');
            return;
        }

        if (!password || password.length < 6) {
            showError('Validation Error', 'Password must be at least 6 characters');
            return;
        }

        // Show confirmation
        Swal.fire({
            title: 'Add New User?',
            html: `
                <div class="text-start">
                    <p><strong><i class="fas fa-user me-2"></i>Name:</strong> ${escapeHtml(name)}</p>
                    <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> ${escapeHtml(email)}</p>
                    ${phone ? `<p><strong><i class="fas fa-phone me-2"></i>Phone:</strong> ${escapeHtml(phone)}</p>` : ''}
                    <p class="text-muted small mt-3">This user will be able to access the admin panel.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-plus me-2"></i>Yes, Add User!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
            reverseButtons: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading('Adding user...');
                
                // Copy values to hidden form
                document.getElementById('modal-name').value = name;
                document.getElementById('modal-email').value = email;
                document.getElementById('modal-phone').value = phone;
                document.getElementById('modal-password').value = password;
                
                // Submit form
                document.getElementById('addUserForm').submit();
            }
        });
    }

    // ========================================
    // UTILITY FUNCTIONS
    // ========================================

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('display-password');
        const toggleBtn = document.getElementById('togglePassword');
        const icon = toggleBtn.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Public API
    return {
        init: init,
        submitUserForm: submitUserForm
    };

})();

// Export for global use
window.UserManagement = UserManagement;