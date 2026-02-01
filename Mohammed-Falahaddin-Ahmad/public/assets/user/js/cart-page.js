document.addEventListener('DOMContentLoaded', function() {
    // Coupon removal with confirmation
    const removeCouponBtn = document.getElementById('remove-coupon-btn');
    const removeCouponForm = document.getElementById('remove-coupon-form');
    
    if (removeCouponBtn && removeCouponForm) {
        removeCouponBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to remove this coupon?')) {
                removeCouponForm.submit();
            }
        });
    }

    // Optional: Add subtle hover effects for cart actions
    document.querySelectorAll('.btn-outline-secondary, .btn-link').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Optional: Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });
});