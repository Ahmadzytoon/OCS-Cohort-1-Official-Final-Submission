# Design System Implementation Guide

## Overview

This guide provides step-by-step instructions for implementing the new unified design system across all Cleanova application pages.

## Quick Start

### Step 1: Update Layout Files

#### Seeker Layout (`resources/views/seeker/layouts/app.blade.php`)

Replace the current CSS includes with:

```html
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cleanova')</title>
    
    <!-- Bootstrap (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Design System CSS -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seeker.css') }}">
    
    @livewireStyles
</head>

<body class="seeker-body">
    @include('seeker.partials.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('seeker.partials.footer')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
```

#### Provider Layout (`resources/views/provider/layouts/app.blade.php`)

```html
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cleanova Provider')</title>
    
    <!-- Bootstrap (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Design System CSS -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/provider.css') }}">
    
    @livewireStyles
</head>

<body>
    <div class="provider-layout">
        @include('provider.partials.sidebar')
        
        <main class="provider-main">
            @include('provider.partials.topbar')
            
            <div class="provider-content">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
```

#### Admin Layout (`resources/views/admin/layout/master.blade.php`)

```html
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cleanova Admin')</title>
    
    <!-- Bootstrap (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Design System CSS -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="admin-layout">
        @include('admin.layout.sidebar')
        
        <main class="admin-main">
            @include('admin.layout.topbar')
            
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
```

### Step 2: Update Component Examples

#### Navbar Component (`resources/views/seeker/partials/navbar.blade.php`)

```html
<nav class="seeker-navbar" id="mainNavbar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center w-100">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="brand-logo">C</div>
                <span>Cleanova</span>
            </a>
            
            <!-- Navigation Links -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
                <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">
                    Services
                </a>
                <a href="{{ route('providers') }}" class="nav-link {{ request()->routeIs('providers') ? 'active' : '' }}">
                    Providers
                </a>
                
                @auth
                    <a href="{{ route('seeker.dashboard') }}" class="nav-link {{ request()->routeIs('seeker.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-ghost btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <div class="avatar avatar-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('seeker.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('seeker.bookings') }}">My Bookings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                @endauth
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="btn btn-ghost btn-sm d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Mobile navigation items -->
    </div>
</div>

<script>
// Add scrolled class to navbar on scroll
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
</script>
```

#### Provider Sidebar (`resources/views/provider/partials/sidebar.blade.php`)

```html
<aside class="provider-sidebar" id="providerSidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="sidebar-logo">C</div>
        <span class="sidebar-brand-text">Cleanova</span>
    </div>
    
    <!-- Navigation -->
    <nav class="sidebar-nav">
        <a href="{{ route('provider.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('provider.bookings') }}" class="sidebar-nav-item {{ request()->routeIs('provider.bookings') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-calendar-check"></i>
            <span>Bookings</span>
        </a>
        
        <a href="{{ route('provider.services') }}" class="sidebar-nav-item {{ request()->routeIs('provider.services') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-briefcase"></i>
            <span>Services</span>
        </a>
        
        <a href="{{ route('provider.availability') }}" class="sidebar-nav-item {{ request()->routeIs('provider.availability') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-clock"></i>
            <span>Availability</span>
        </a>
        
        <a href="{{ route('provider.reviews') }}" class="sidebar-nav-item {{ request()->routeIs('provider.reviews') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-star"></i>
            <span>Reviews</span>
        </a>
        
        <a href="{{ route('provider.earnings') }}" class="sidebar-nav-item {{ request()->routeIs('provider.earnings') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-wallet2"></i>
            <span>Earnings</span>
        </a>
        
        <a href="{{ route('provider.profile') }}" class="sidebar-nav-item {{ request()->routeIs('provider.profile') ? 'active' : '' }}">
            <i class="sidebar-nav-icon bi bi-person"></i>
            <span>Profile</span>
        </a>
    </nav>
    
    <!-- User Section -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
```

#### Admin Sidebar (`resources/views/admin/layout/sidebar.blade.php`)

```html
<aside class="admin-sidebar" id="adminSidebar">
    <!-- Brand -->
    <div class="admin-sidebar-brand">
        <div class="admin-logo">C</div>
        <span class="admin-brand-text">Admin Panel</span>
    </div>
    
    <!-- Navigation -->
    <nav class="admin-sidebar-nav">
        <!-- Main Section -->
        <div class="admin-nav-section">
            <h4 class="admin-nav-section-title">Main</h4>
            <div class="admin-nav-items">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-speedometer2"></i>
                    <span class="admin-nav-text">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.analytics') }}" class="admin-nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-graph-up"></i>
                    <span class="admin-nav-text">Analytics</span>
                </a>
            </div>
        </div>
        
        <!-- Management Section -->
        <div class="admin-nav-section">
            <h4 class="admin-nav-section-title">Management</h4>
            <div class="admin-nav-items">
                <a href="{{ route('admin.customers') }}" class="admin-nav-item {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-people"></i>
                    <span class="admin-nav-text">Customers</span>
                </a>
                
                <a href="{{ route('admin.providers') }}" class="admin-nav-item {{ request()->routeIs('admin.providers') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-briefcase"></i>
                    <span class="admin-nav-text">Providers</span>
                </a>
                
                <a href="{{ route('admin.bookings') }}" class="admin-nav-item {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-calendar-check"></i>
                    <span class="admin-nav-text">Bookings</span>
                </a>
                
                <a href="{{ route('admin.payments') }}" class="admin-nav-item {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-credit-card"></i>
                    <span class="admin-nav-text">Payments</span>
                </a>
            </div>
        </div>
        
        <!-- Settings Section -->
        <div class="admin-nav-section">
            <h4 class="admin-nav-section-title">Settings</h4>
            <div class="admin-nav-items">
                <a href="{{ route('admin.settings') }}" class="admin-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="admin-nav-icon bi bi-gear"></i>
                    <span class="admin-nav-text">Settings</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Sidebar Toggle -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="bi bi-chevron-left"></i>
    </button>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    sidebar.classList.toggle('collapsed');
}
</script>
```

### Step 3: Update Page Examples

#### Dashboard Stats (Provider/Admin)

```html
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-card-trend positive">
                <i class="bi bi-arrow-up"></i> 12%
            </div>
        </div>
        <div class="stat-card-value">{{ $activeBookings }}</div>
        <div class="stat-card-label">Active Bookings</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stat-card-trend positive">
                <i class="bi bi-arrow-up"></i> 8%
            </div>
        </div>
        <div class="stat-card-value">${{ number_format($earnings, 2) }}</div>
        <div class="stat-card-label">Total Earnings</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="bi bi-star"></i>
            </div>
            <div class="stat-card-trend positive">
                <i class="bi bi-arrow-up"></i> 0.2
            </div>
        </div>
        <div class="stat-card-value">{{ $rating }}</div>
        <div class="stat-card-label">Average Rating</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-card-trend positive">
                <i class="bi bi-arrow-up"></i> 5
            </div>
        </div>
        <div class="stat-card-value">{{ $completedJobs }}</div>
        <div class="stat-card-label">Completed Jobs</div>
    </div>
</div>
```

#### Data Table Example

```html
<div class="data-table-wrapper">
    <div class="data-table-header">
        <h2 class="data-table-title">Recent Bookings</h2>
        <div class="data-table-actions">
            <input type="search" class="form-control form-control-sm" placeholder="Search...">
            <button class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add New
            </button>
        </div>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>#{{ $booking->id }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm">
                            {{ substr($booking->customer->name, 0, 1) }}
                        </div>
                        <span>{{ $booking->customer->name }}</span>
                    </div>
                </td>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->date->format('M d, Y') }}</td>
                <td>
                    @if($booking->status === 'confirmed')
                        <span class="badge badge-success">Confirmed</span>
                    @elseif($booking->status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($booking->status === 'completed')
                        <span class="badge badge-info">Completed</span>
                    @else
                        <span class="badge badge-danger">Cancelled</span>
                    @endif
                </td>
                <td>${{ number_format($booking->amount, 2) }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-ghost btn-xs">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-ghost btn-xs">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="data-table-footer">
        <div>Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries</div>
        <div>
            {{ $bookings->links() }}
        </div>
    </div>
</div>
```

#### Login Page Example

```html
@extends('layouts.guest')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <!-- Visual Side -->
            <div class="auth-visual">
                <div class="auth-visual-content">
                    <div class="auth-visual-logo">C</div>
                    <h1 class="auth-visual-title">Welcome Back to Cleanova</h1>
                    <p class="auth-visual-description">
                        Sign in to access your account and manage your services.
                    </p>
                    
                    <ul class="auth-visual-features">
                        <li class="auth-visual-feature">
                            <div class="auth-visual-feature-icon">
                                <i class="bi bi-check"></i>
                            </div>
                            <span>Manage bookings easily</span>
                        </li>
                        <li class="auth-visual-feature">
                            <div class="auth-visual-feature-icon">
                                <i class="bi bi-check"></i>
                            </div>
                            <span>Track your earnings</span>
                        </li>
                        <li class="auth-visual-feature">
                            <div class="auth-visual-feature-icon">
                                <i class="bi bi-check"></i>
                            </div>
                            <span>Connect with clients</span>
                        </li>
                    </ul>
                </div>
                
                <div class="auth-visual-footer">
                    © 2026 Cleanova. All rights reserved.
                </div>
            </div>
            
            <!-- Form Side -->
            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h2 class="auth-form-title">Sign In</h2>
                    <p class="auth-form-subtitle">Enter your credentials to continue</p>
                </div>
                
                @if(session('status'))
                <div class="auth-alert auth-alert-success">
                    <i class="auth-alert-icon bi bi-check-circle"></i>
                    <div class="auth-alert-content">
                        <div class="auth-alert-message">{{ session('status') }}</div>
                    </div>
                </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf
                    
                    <!-- Email -->
                    <div class="auth-form-group">
                        <label for="email" class="auth-form-label">Email Address</label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            class="auth-form-input @error('email') error @enderror" 
                            value="{{ old('email') }}" 
                            placeholder="you@example.com"
                            required 
                            autofocus
                        >
                        @error('email')
                        <span class="auth-form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-form-label">Password</label>
                        <div class="auth-password-group">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                class="auth-form-input auth-password-input @error('password') error @enderror" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="auth-password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <span class="auth-form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="auth-form-options">
                        <div class="auth-checkbox-group">
                            <input type="checkbox" name="remember" id="remember" class="auth-checkbox">
                            <label for="remember" class="auth-checkbox-label">Remember me</label>
                        </div>
                        
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-forgot-link">
                            Forgot password?
                        </a>
                        @endif
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="auth-submit-btn">
                        Sign In
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="auth-footer">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="auth-footer-link">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}
</script>
@endsection
```

## Testing Checklist

After implementing the design system, test the following:

- [ ] All CSS files are properly loaded
- [ ] Colors match the design system palette
- [ ] Typography is consistent across pages
- [ ] Buttons have proper hover and active states
- [ ] Forms have proper focus states
- [ ] Cards have hover effects
- [ ] Navigation is working correctly
- [ ] Responsive design works on mobile
- [ ] Animations are smooth
- [ ] No console errors
- [ ] Cross-browser compatibility

## Troubleshooting

### Issue: Styles not applying

**Solution**: Clear Laravel cache and browser cache
```bash
php artisan cache:clear
php artisan view:clear
```

### Issue: Old styles conflicting

**Solution**: Remove old CSS file references from layouts

### Issue: Bootstrap conflicts

**Solution**: Ensure design system CSS is loaded after Bootstrap

## Next Steps

1. Update all existing pages to use new design system classes
2. Test thoroughly on all browsers and devices
3. Gather user feedback
4. Make iterative improvements
5. Document any custom components created

## Support

For questions or issues, refer to DESIGN_SYSTEM.md or contact the development team.
