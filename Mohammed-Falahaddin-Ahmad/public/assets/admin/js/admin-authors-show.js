document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button click
    document.querySelectorAll('.delete-author-btn').forEach(button => {
        button.addEventListener('click', function() {
            const authorId = this.getAttribute('data-author-id');
            const authorName = this.getAttribute('data-author-name');
            const booksCount = parseInt(this.getAttribute('data-books-count'));
            const deleteUrl = this.getAttribute('data-delete-url');
            
            let title = 'Are you sure?';
            let text = `You won't be able to revert "${authorName}"!`;
            let icon = 'warning';
            let confirmButtonText = 'Yes, delete it!';
            let showCancelButton = true;
            let confirmButtonColor = '#d33';
            
            // If author has books, show warning and disable deletion
            if (booksCount > 0) {
                title = 'Cannot Delete Author!';
                text = `This author has ${booksCount} book(s) associated with them. Please reassign or delete the books first.`;
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
                    // Create and submit delete form
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