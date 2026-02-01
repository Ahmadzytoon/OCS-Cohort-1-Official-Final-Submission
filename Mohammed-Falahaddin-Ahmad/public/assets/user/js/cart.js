document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Handle Add to Cart
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart-btn')) {
            e.preventDefault();
            const button = e.target.closest('.add-to-cart-btn');
            
            if(button.hasAttribute('disabled')) return;

            const bookId = button.getAttribute('data-id');
            const url = `/cart/add/${bookId}`;

            // Add loading effect
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.style.pointerEvents = 'none';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.message) {
                   // Update ALL cart count badges (desktop, mobile, sticky)
                   const countBadges = document.querySelectorAll('.cart-icon .number');
                   
                   countBadges.forEach(badge => {
                       let count = parseInt(badge.innerText) || 0;
                       count++;
                       badge.innerText = count;
                       badge.style.display = 'flex'; // Ensure visible using flex to center text
                   });

                   // If no badges found (rare case if hidden/removed), try to find wrappers and append
                   if (countBadges.length === 0) {
                       const wrappers = document.querySelectorAll('.cart-icon');
                       wrappers.forEach(wrapper => {
                           let span = document.createElement('span');
                           span.className = 'number';
                           span.innerText = '1';
                           span.style.display = 'flex';
                           // detailed styling usually handled by class, but ensure basic visibility
                           wrapper.appendChild(span);
                       });
                   }
                   
                   // Restore button
                   button.innerHTML = '<i class="fa-solid fa-check"></i> Added';
                   setTimeout(() => {
                       button.innerHTML = originalText;
                       button.style.pointerEvents = 'auto';
                   }, 2000);
                } else {
                    alert('Failed to add to cart: ' + (data.message || 'Unknown error'));
                    button.innerHTML = originalText;
                    button.style.pointerEvents = 'auto';
                }
            })
            .catch(error => {
                console.error('Cart error:', error);
                button.innerHTML = originalText;
                button.style.pointerEvents = 'auto';
            });
        }
    });
});
