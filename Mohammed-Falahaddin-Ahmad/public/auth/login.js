document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    function showRegister() {
        document.getElementById('loginForm').classList.remove('active');
        document.getElementById('registerForm').classList.add('active');
        hideAlerts();
    }

    function showLogin() {
        document.getElementById('registerForm').classList.remove('active');
        document.getElementById('loginForm').classList.add('active');
        hideAlerts();
    }

    function togglePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        if (field.type === 'password') {
            field.type = 'text';
            btn.textContent = '🙈';
        } else {
            field.type = 'password';
            btn.textContent = '👁️';
        }
    }

    function showAlert(elementId, message, type = 'danger') {
        const alert = document.getElementById(elementId);
        alert.className = `alert alert-${type} show`;
        alert.textContent = message;
        setTimeout(() => {
            alert.classList.remove('show');
        }, 5000);
    }

    function hideAlerts() {
        document.getElementById('loginAlert').classList.remove('show');
        document.getElementById('registerAlert').classList.remove('show');
    }

    async function handleLogin(e) {
        e.preventDefault();
        
        const formData = new FormData(document.getElementById('loginFormElement'));

        const email = formData.get('email');
        const password = formData.get('password');

        if (!email || !password) {
            showAlert('loginAlert', 'Please fill in all fields');
            return;
        }

        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showAlert('loginAlert', data.message, 'success');
                
                // Get redirect URL from query parameter
                const urlParams = new URLSearchParams(window.location.search);
                const redirectUrl = urlParams.get('redirect');
                
                setTimeout(() => {
                    window.location.href = redirectUrl || data.redirect;
                }, 1500);
            } else {
                showAlert('loginAlert', data.message);
            }
        } catch (error) {
            showAlert('loginAlert', 'An error occurred. Please try again.');
            console.error('Login error:', error);
        }
    }

    async function handleRegister(e) {
        e.preventDefault();
        
        const formData = new FormData(document.getElementById('registerFormElement'));

        const username = formData.get('username');
        const email = formData.get('email');
        const phone = formData.get('phone');
        const password = formData.get('password');
        const passwordConfirmation = formData.get('password_confirmation');

        if (!username || !email || !phone || !password || !passwordConfirmation) {
            showAlert('registerAlert', 'Please fill in all fields');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showAlert('registerAlert', 'Please enter a valid email address');
            return;
        }

        if (password.length < 6) {
            showAlert('registerAlert', 'Password must be at least 6 characters long');
            return;
        }

        if (password !== passwordConfirmation) {
            showAlert('registerAlert', 'Passwords do not match');
            return;
        }

        try {
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showAlert('registerAlert', data.message, 'success');
                setTimeout(() => {
                    showLogin();
                    document.getElementById('loginEmail').value = email;
                }, 1500);
            } else {
                showAlert('registerAlert', data.message);
            }
        } catch (error) {
            showAlert('registerAlert', 'An error occurred. Please try again.');
            console.error('Registration error:', error);
        }
    }

    // Attach event listeners
    window.showRegister = showRegister;
    window.showLogin = showLogin;
    window.togglePassword = togglePassword;
    window.handleLogin = handleLogin;
    window.handleRegister = handleRegister;
});