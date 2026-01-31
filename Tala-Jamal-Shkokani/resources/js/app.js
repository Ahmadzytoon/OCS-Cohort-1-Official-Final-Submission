import './bootstrap';

// Standard SweetAlert Configuration for Chic & Co.
const softSwal = {
    confirmButtonColor: 'var(--color-ink-black)',
    cancelButtonColor: 'var(--color-secondary-mauve)',
    background: '#ffffff',
    color: 'var(--color-ink-black)',
    customClass: {
        popup: 'rounded-5 shadow-lg p-4 border-0',
        title: 'font-heading fw-bold fs-3',
        confirmButton: 'btn btn-primary-custom rounded-pill px-4 py-2 border-0',
        cancelButton: 'btn btn-outline-secondary rounded-pill px-4 py-2 border-0'
    },
    buttonsStyling: false
};

const getSwalData = (event) => {
    if (event.detail && typeof event.detail === 'object') {
        return Array.isArray(event.detail) ? event.detail[0] : event.detail;
    }
    return {};
};

// Global Event Listeners
window.addEventListener('swal:success', event => {
    const data = getSwalData(event);
    Swal.fire({
        ...softSwal,
        title: data.title || 'Success',
        text: data.text || '',
        icon: 'success',
        iconColor: 'var(--color-primary-blush)'
    });
});

window.addEventListener('swal:error', event => {
    const data = getSwalData(event);
    Swal.fire({
        ...softSwal,
        title: data.title || 'Error',
        text: data.text || 'Something went wrong.',
        icon: 'error',
        iconColor: 'var(--color-ink-black)'
    });
});

window.addEventListener('swal:auth-prompt', event => {
    Swal.fire({
        ...softSwal,
        title: 'Exclusive Access',
        text: 'To curate your final selection and secure your order, please sign in or join our archive.',
        icon: 'info',
        iconColor: 'var(--color-primary-blush)',
        showCancelButton: true,
        confirmButtonText: 'Sign In',
        cancelButtonText: 'Register',
        showCloseButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/login";
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = "/register";
        }
    });
});

window.addEventListener('open-cart', event => {
    const sidebar = document.getElementById('cartSidebar');
    if (sidebar) {
        const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
        bsOffcanvas.show();
    }
});

// UI Cleanup Routine
document.addEventListener('livewire:navigated', cleanupUIState);
document.addEventListener('hidden.bs.offcanvas', cleanupUIState);
document.addEventListener('hidden.bs.modal', cleanupUIState);

function cleanupUIState() {
    setTimeout(() => {
        const activeOffcanvas = document.querySelector('.offcanvas.show');
        const activeModal = document.querySelector('.modal.show');
        if (!activeOffcanvas && !activeModal) {
            document.querySelectorAll('.offcanvas-backdrop, .modal-backdrop').forEach(el => el.remove());
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.body.classList.remove('modal-open', 'offcanvas-open', 'overflow-hidden');
        }
    }, 350);
}

// Navbar Scroll Effect
window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (navbar && window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else if (navbar) {
        navbar.classList.remove('scrolled');
    }
});

// Notification System
window.addEventListener('show-toast', event => {
    const data = event.detail.length ? event.detail[0] : event.detail;
    showToast(data.message, data.type);
});

function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    const baseClasses = 'toast show d-flex align-items-center border-0 shadow-lg rounded-4 mb-3 animate-fade-up';
    const bgClass = type === 'success' ? 'bg-white text-dark' : 'bg-dark text-white';
    const icon = type === 'success' ? '<i class="fa-solid fa-heart text-danger fs-5"></i>' : '<i class="fa-solid fa-info-circle fs-5"></i>';
    const borderColor = type === 'success' ? 'border-left: 4px solid var(--color-primary-blush);' : 'border-left: 4px solid #fff;';

    toast.className = `${baseClasses} ${bgClass}`;
    toast.style.cssText = `min-width: 300px; ${borderColor} pointer-events: auto;`;
    toast.innerHTML = `
        <div class="toast-body d-flex align-items-center w-100 py-3 px-4">
            <div class="me-3">${icon}</div>
            <div class="fw-bold extra-small text-uppercase ls-1">${message}</div>
            <button type="button" class="btn-close ms-auto me-0" data-bs-dismiss="toast" aria-label="Close" style="filter: ${type === 'success' ? 'none' : 'invert(1)'}"></button>
        </div>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('fade');
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// Global confirm dialog
document.addEventListener('livewire:init', () => {
    Livewire.on('trigger-confirm', (data) => {
        const swalData = Array.isArray(data) ? data[0] : data;
        Swal.fire({
            ...softSwal,
            title: swalData.title || 'Are you sure?',
            text: swalData.text || '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: swalData.confirmButtonText || 'Confirm',
            cancelButtonText: swalData.cancelButtonText || 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch(swalData.method, swalData.params || {});
            }
        });
    });
});

// Expose legacy helpers if needed
window.triggerReviewModal = function (productName) {
    Swal.fire({
        ...softSwal,
        title: 'Review ' + productName,
        html: `
            <div class="mb-3 text-start">
                <label class="small text-muted mb-2 d-block text-uppercase ls-1">Your Rating</label>
                <div class="d-flex gap-2 mb-4 fs-3 justify-content-center" id="star-rating">
                    <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(1)"></i>
                    <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(2)"></i>
                    <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(3)"></i>
                    <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(4)"></i>
                    <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(5)"></i>
                </div>
                <textarea id="review-text" class="form-control bg-light border-0 rounded-4 p-3" rows="3" placeholder="Share your experience..."></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Submit Review',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ ...softSwal, title: 'Thank You!', text: 'Your review has been shared.', icon: 'success' });
        }
    });
};

window.setRating = function (val) {
    const stars = document.querySelectorAll('#star-rating i');
    stars.forEach((star, index) => {
        if (index < val) {
            star.classList.replace('fa-regular', 'fa-solid');
            star.classList.add('text-warning');
        } else {
            star.classList.replace('fa-solid', 'fa-regular');
            star.classList.remove('text-warning');
        }
    });
};

window.confirmLogout = function (formId) {
    Swal.fire({
        ...softSwal,
        title: 'Depart Curiosity?',
        text: 'Are you sure you wish to end your curated session?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Leave',
        cancelButtonText: 'Stay',
    }).then((result) => {
        if (result.isConfirmed) {
            if (formId) {
                document.getElementById(formId).submit();
            } else {
                const form = document.querySelector('form[action*="logout"]');
                if (form) form.submit();
            }
        }
    });
};
