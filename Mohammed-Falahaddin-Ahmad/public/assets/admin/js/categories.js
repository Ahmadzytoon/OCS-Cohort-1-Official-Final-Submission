document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss success alert after 3 seconds
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('show');
            successAlert.classList.add('fade');
            setTimeout(() => successAlert.remove(), 150);
        }, 3000);
    }

    // Handle delete button click
    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            const categoryName = this.getAttribute('data-category-name');
            const booksCount = parseInt(this.getAttribute('data-books-count'));
            const deleteUrl = this.getAttribute('data-delete-url');
            
            let title = 'Are you sure?';
            let text = `You won't be able to revert "${categoryName}"!`;
            let icon = 'warning';
            let confirmButtonText = 'Yes, delete it!';
            let showCancelButton = true;
            let confirmButtonColor = '#d33';
            
            if (booksCount > 0) {
                title = 'Cannot Delete Category!';
                text = `This category has ${booksCount} book(s) associated with it. Please reassign or delete the books first.`;
                icon = 'error';
                confirmButtonText = 'OK';
                showCancelButton = false;
                confirmButtonColor = '#3085d6';
            }
            
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: showCancelButton,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#3085d6',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed && booksCount === 0) {
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
});