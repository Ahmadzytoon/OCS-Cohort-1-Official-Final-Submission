<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Readify - Login & Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('auth/login.css') }}" rel="stylesheet">
</head>
<body>

    <div class="auth-container">
        <div class="auth-left">
            <div class="book-icon">📚</div>
            <h1>Readify</h1>
            <p>Discover your next favorite book in our extensive collection. Join thousands of readers in their literary journey.</p>
        </div>

        <div class="auth-right">
            <!-- Login Form -->
            <div id="loginForm" class="form-container active">
                <h2 class="form-title">Welcome Back</h2>
                <p class="form-subtitle">Login to access your account</p>

                <div id="loginAlert" class="alert alert-danger"></div>

                <form id="loginFormElement" onsubmit="handleLogin(event)">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-toggle">
                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('loginPassword', this)">👁️</button>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">Login</button>

                    <div class="toggle-form">
                        Don't have an account? <a onclick="showRegister()">Register here</a>
                    </div>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="form-container">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Join Readify today</p>

                <div id="registerAlert" class="alert alert-danger"></div>

                <form id="registerFormElement" onsubmit="handleRegister(event)">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="registerUsername" name="username" placeholder="Choose a username" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="registerPhone" name="phone" placeholder="Enter your phone number" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-toggle">
                            <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Create a password" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('registerPassword', this)">👁️</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-toggle">
                            <input type="password" class="form-control" id="registerPasswordConfirmation" name="password_confirmation" placeholder="Confirm your password" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('registerPasswordConfirmation', this)">👁️</button>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">Register</button>

                    <div class="toggle-form">
                        Already have an account? <a onclick="showLogin()">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
<script src="{{ asset('auth/login.js') }}"></script>
</body>
</html>