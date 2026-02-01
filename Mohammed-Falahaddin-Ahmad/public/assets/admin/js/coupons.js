document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('show');
            successAlert.classList.add('fade');
            setTimeout(() => successAlert.remove(), 150);
        }, 3000);
    }
    // Handle Delete Coupon button clicks
    document.querySelectorAll('.delete-coupon-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const couponCode = this.getAttribute('data-coupon-code');
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Delete Coupon?',
                text: `Are you sure you want to delete the coupon code "${couponCode}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});