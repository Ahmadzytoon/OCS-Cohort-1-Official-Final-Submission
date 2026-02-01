document.addEventListener('DOMContentLoaded', function () {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        console.error('CSRF token not found. Make sure <meta name="csrf-token" content="{{ csrf_token() }}"> is in your layout.');
        return;
    }

    // Handle wishlist toggle
    document.querySelectorAll('.wishlist-toggle').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const bookId = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const icon = this.querySelector('i');

            let url, method;
            if (action === 'add') {
                url = `/wishlist/add/${bookId}`;
                method = 'POST';
            } else {
                url = `/wishlist/remove/${bookId}`;
                method = 'DELETE';
            }

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle icon and action
                    if (action === 'add') {
                        // Update ALL buttons for this book
                        document.querySelectorAll(`.wishlist-toggle[data-id="${bookId}"]`).forEach(btn => {
                            const btnIcon = btn.querySelector('i');
                            btnIcon.className = 'fas fa-heart';
                            btn.setAttribute('data-action', 'remove');
                            btn.classList.add('text-danger');
                        });
                        
                        // Update count
                        const countBadge = document.getElementById('wishlist-count');
                        if (countBadge) {
                            let count = parseInt(countBadge.innerText) || 0;
                            count++;
                            countBadge.innerText = count;
                            countBadge.style.display = 'flex'; // Ensure it's visible
                        } else {
                             // Create if doesn't exist
                             const wrapper = document.getElementById('wishlist-link');
                             if(wrapper) {
                                let span = document.createElement('span');
                                span.id = 'wishlist-count';
                                span.className = 'number';
                                span.innerText = '1';
                                wrapper.appendChild(span);
                             }
                        }
                    } else {
                        // Update ALL buttons for this book
                        document.querySelectorAll(`.wishlist-toggle[data-id="${bookId}"]`).forEach(btn => {
                            const btnIcon = btn.querySelector('i');
                            btnIcon.className = 'far fa-heart';
                            btn.setAttribute('data-action', 'add');
                            btn.classList.remove('text-danger');
                        });
                        
                        // Update count
                        const countBadge = document.getElementById('wishlist-count');
                        if (countBadge) {
                            let count = parseInt(countBadge.innerText) || 0;
                            if (count > 0) count--;
                            countBadge.innerText = count;
                            if (count === 0) countBadge.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Wishlist error:', error);
            });
        });
    });
});