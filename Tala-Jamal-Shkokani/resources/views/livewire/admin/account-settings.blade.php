<div>
    <div class="animate-fade-in">
        <!-- Header -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Account Settings
                    </h1>
                    <p class="text-muted small mb-0">Manage your administrative profile and session preferences.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Information Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-5">
                            <div class="profile-avatar-large me-4">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold" style="font-family: 'Playfair Display', serif;">
                                    {{ auth()->user()->name }}
                                </h3>
                                <p class="text-muted mb-0 small text-uppercase ls-1">{{ ucfirst(auth()->user()->role) }}
                                    Account</p>
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <h5 class="mb-4 text-uppercase small fw-bold ls-1 opacity-50">Profile Details</h5>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase ls-1 opacity-75">Display
                                    Name</label>
                                <div class="bg-light p-3 rounded-3">
                                    <i class="fa-solid fa-user me-2 opacity-50"></i>{{ $name }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase ls-1 opacity-75">Email
                                    Address</label>
                                <div class="bg-light p-3 rounded-3">
                                    <i class="fa-solid fa-envelope me-2 opacity-50"></i>{{ $email }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase ls-1 opacity-75">Access
                                    Level</label>
                                <div class="bg-light p-3 rounded-3">
                                    <span class="badge bg-dark text-white px-3 py-2">
                                        <i class="fa-solid fa-shield-alt me-2"></i>{{ strtoupper($role) }} PRIVILEGES
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase ls-1 opacity-75">Member
                                    Since</label>
                                <div class="bg-light p-3 rounded-3">
                                    <i
                                        class="fa-solid fa-calendar me-2 opacity-50"></i>{{ auth()->user()->created_at->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 24px;">
                    <div class="card-body p-4">
                        <h5 class="mb-4 text-uppercase small fw-bold ls-1 opacity-50">Quick Actions</h5>

                        <a href="{{ route('admin.dashboard') }}"
                            class="btn btn-light w-100 mb-3 rounded-pill py-3 text-start">
                            <i class="fa-solid fa-house me-3"></i>
                            <span class="fw-600">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="btn btn-light w-100 mb-3 rounded-pill py-3 text-start">
                            <i class="fa-solid fa-user-group me-3"></i>
                            <span class="fw-600">Manage Users</span>
                        </a>

                        <a href="{{ route('admin.products.index') }}"
                            class="btn btn-light w-100 mb-3 rounded-pill py-3 text-start">
                            <i class="fa-solid fa-bag-shopping me-3"></i>
                            <span class="fw-600">Manage Products</span>
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-light w-100 mb-3 rounded-pill py-3 text-start">
                            <i class="fa-solid fa-store me-3"></i>
                            <span class="fw-600">View Storefront</span>
                        </a>
                    </div>
                </div>

                <!-- Session Management Card -->
                <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                    <div class="card-body p-4">
                        <h5 class="mb-4 text-uppercase small fw-bold ls-1 opacity-50">Session Management</h5>

                        <div class="alert alert-light border-0 rounded-4 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-circle-check text-success me-3 fs-5"></i>
                                <div class="small">
                                    <div class="fw-bold">Active Session</div>
                                    <div class="text-muted extra-small">Logged in as administrator</div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 fw-bold">
                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                                Sign Out Securely
                            </button>
                        </form>

                        <p class="text-muted text-center small mt-3 mb-0">
                            You'll be redirected to the login page
                        </p>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-light" style="border-radius: 24px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fa-solid fa-shield-halved text-primary me-3 fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Security Notice</h6>
                                <p class="text-muted small mb-0">
                                    Always ensure you're accessing the admin panel from a secure connection.
                                    Never share your administrator credentials with anyone. If you notice any
                                    suspicious activity, sign out immediately and contact system support.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-avatar-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--color-primary-blush), var(--color-dusty-rose));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 2rem;
            font-family: 'Playfair Display', serif;
            box-shadow: 0 10px 30px rgba(246, 166, 178, 0.3);
        }

        .extra-small {
            font-size: 0.7rem;
        }

        .ls-1 {
            letter-spacing: 1.5px;
        }

        .fw-600 {
            font-weight: 600;
        }

        .text-primary {
            color: #F6A6B2 !important;
        }

        .btn-light {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-light:hover {
            background-color: rgba(246, 166, 178, 0.1);
            border-color: #F6A6B2;
            transform: translateX(5px);
        }

        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>