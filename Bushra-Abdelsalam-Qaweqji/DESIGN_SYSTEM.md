# Cleanova Design System Documentation

## Overview

This design system provides a comprehensive, unified UI/UX framework for the Cleanova service marketplace application. It ensures visual consistency, modern aesthetics, and excellent user experience across all user roles (Customer/Seeker, Service Provider, and Admin).

## Design Philosophy

- **Consistency**: Unified color palette, typography, and spacing across all interfaces
- **Modern**: Contemporary design with glassmorphism, smooth animations, and premium aesthetics
- **Accessible**: WCAG-compliant color contrasts and keyboard navigation support
- **Responsive**: Mobile-first approach with breakpoints for all screen sizes
- **Performance**: Optimized CSS with minimal redundancy

## File Structure

```
public/css/
├── design-system.css  # Core design tokens and base components
├── seeker.css         # Customer/Seeker interface styles
├── provider.css       # Service Provider dashboard styles
├── admin.css          # Admin dashboard styles
└── auth.css           # Authentication pages styles
```

## How to Use

### 1. Include CSS Files in Your Blade Templates

#### For Seeker/Customer Pages:
```html
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/seeker.css') }}">
```

#### For Provider Dashboard:
```html
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/provider.css') }}">
```

#### For Admin Dashboard:
```html
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
```

#### For Authentication Pages:
```html
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
```

## Design Tokens (CSS Custom Properties)

### Color Palette

#### Primary Colors (Blue/Navy)
```css
--primary-900: #0a1829  /* Darkest - Headers, emphasis */
--primary-800: #0f2854  /* Dark - Primary text */
--primary-700: #1c4d8d  /* Main brand color */
--primary-600: #2563a8
--primary-500: #4988c4  /* Interactive elements */
--primary-400: #6ba3d6
--primary-300: #8fbde5
--primary-200: #bde8f5  /* Light backgrounds */
--primary-100: #cfeafd  /* Very light backgrounds */
--primary-50: #f3fbff   /* Subtle backgrounds */
```

#### Neutral Colors (Grays)
```css
--neutral-900: #091426  /* Primary text */
--neutral-800: #1e293b
--neutral-700: #334155  /* Secondary text */
--neutral-600: #475569
--neutral-500: #64748b  /* Muted text */
--neutral-400: #94a3b8  /* Placeholder text */
--neutral-300: #cbd5e1  /* Borders */
--neutral-200: #e2e8f0  /* Light borders */
--neutral-100: #f1f5f9  /* Backgrounds */
--neutral-50: #f8fafc   /* Light backgrounds */
```

#### Semantic Colors
```css
/* Success (Green) */
--success-600: #16a34a
--success-500: #22c55e
--success-100: #dcfce7

/* Warning (Orange/Yellow) */
--warning-600: #d97706
--warning-500: #f59e0b
--warning-100: #fef3c7

/* Danger (Red) */
--danger-600: #dc2626
--danger-500: #ef4444
--danger-100: #fee2e2

/* Info (Light Blue) */
--info-600: #0284c7
--info-500: #0ea5e9
--info-100: #e0f2fe
```

### Typography

#### Font Family
```css
--font-sans: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif
```

#### Font Sizes
```css
--font-size-xs: 0.75rem    /* 12px */
--font-size-sm: 0.875rem   /* 14px */
--font-size-base: 1rem     /* 16px */
--font-size-lg: 1.125rem   /* 18px */
--font-size-xl: 1.25rem    /* 20px */
--font-size-2xl: 1.5rem    /* 24px */
--font-size-3xl: 1.875rem  /* 30px */
--font-size-4xl: 2.25rem   /* 36px */
--font-size-5xl: 3rem      /* 48px */
```

#### Font Weights
```css
--font-weight-normal: 400
--font-weight-medium: 500
--font-weight-semibold: 600
--font-weight-bold: 700
--font-weight-extrabold: 800
--font-weight-black: 900
```

### Spacing Scale
```css
--space-1: 0.25rem   /* 4px */
--space-2: 0.5rem    /* 8px */
--space-3: 0.75rem   /* 12px */
--space-4: 1rem      /* 16px */
--space-5: 1.25rem   /* 20px */
--space-6: 1.5rem    /* 24px */
--space-8: 2rem      /* 32px */
--space-10: 2.5rem   /* 40px */
--space-12: 3rem     /* 48px */
--space-16: 4rem     /* 64px */
--space-20: 5rem     /* 80px */
--space-24: 6rem     /* 96px */
```

### Border Radius
```css
--radius-sm: 0.375rem    /* 6px */
--radius-base: 0.5rem    /* 8px */
--radius-md: 0.75rem     /* 12px */
--radius-lg: 1rem        /* 16px */
--radius-xl: 1.25rem     /* 20px */
--radius-2xl: 1.5rem     /* 24px */
--radius-full: 9999px    /* Fully rounded */
```

### Shadows
```css
--shadow-sm: Subtle shadow
--shadow-base: Default shadow
--shadow-md: Medium shadow
--shadow-lg: Large shadow
--shadow-xl: Extra large shadow
--shadow-2xl: Maximum shadow
--shadow-primary-sm: Small shadow with primary color tint
--shadow-primary-md: Medium shadow with primary color tint
--shadow-primary-lg: Large shadow with primary color tint
```

## Component Classes

### Buttons

#### Basic Usage
```html
<button class="btn btn-primary btn-md">Primary Button</button>
<button class="btn btn-secondary btn-md">Secondary Button</button>
<button class="btn btn-outline btn-md">Outline Button</button>
<button class="btn btn-ghost btn-md">Ghost Button</button>
```

#### Sizes
- `.btn-xs` - Extra small
- `.btn-sm` - Small
- `.btn-md` - Medium (default)
- `.btn-lg` - Large

#### Variants
- `.btn-primary` - Primary action (gradient blue)
- `.btn-secondary` - Secondary action (gray)
- `.btn-outline` - Outlined button
- `.btn-ghost` - Transparent button
- `.btn-success` - Success action (green)
- `.btn-danger` - Danger action (red)
- `.btn-warning` - Warning action (orange)

### Cards

#### Basic Card
```html
<div class="card">
    <div class="card-header">
        <h3>Card Title</h3>
    </div>
    <div class="card-body">
        <p>Card content goes here</p>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary btn-sm">Action</button>
    </div>
</div>
```

#### Card Variants
- `.card-hover` - Adds hover effect (lift and shadow)
- `.card-elevated` - Stronger shadow
- `.card-flat` - No shadow, just border
- `.card-gradient` - Gradient background

### Forms

#### Form Group
```html
<div class="form-group">
    <label class="form-label">Email Address</label>
    <input type="email" class="form-control" placeholder="Enter email">
    <span class="form-help">We'll never share your email</span>
</div>
```

#### Form Elements
- `.form-label` - Form field label
- `.form-control` - Text input, email, password, etc.
- `.form-select` - Select dropdown
- `.form-textarea` - Textarea
- `.form-error` - Error message
- `.form-help` - Help text

### Badges

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-danger">Danger</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-neutral">Neutral</span>
```

### Avatars

```html
<div class="avatar avatar-md">
    <img src="user.jpg" alt="User">
</div>

<!-- Or with initials -->
<div class="avatar avatar-md">JD</div>
```

#### Sizes
- `.avatar-xs` - 24px
- `.avatar-sm` - 32px
- `.avatar-md` - 40px
- `.avatar-lg` - 56px
- `.avatar-xl` - 80px

### Typography Classes

```html
<h1 class="text-display-1">Display 1</h1>
<h2 class="text-display-2">Display 2</h2>
<h3 class="text-display-3">Display 3</h3>
<h1 class="text-heading-1">Heading 1</h1>
<h2 class="text-heading-2">Heading 2</h2>
<h3 class="text-heading-3">Heading 3</h3>
<p class="text-body-lg">Large body text</p>
<p class="text-body">Regular body text</p>
<p class="text-body-sm">Small body text</p>
<p class="text-caption">Caption text</p>
```

## Seeker/Customer Components

### Navbar
```html
<nav class="seeker-navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <div class="brand-logo">C</div>
            <span>Cleanova</span>
        </a>
        <div class="navbar-nav">
            <a href="#" class="nav-link active">Home</a>
            <a href="#" class="nav-link">Services</a>
            <a href="#" class="nav-link">Providers</a>
        </div>
    </div>
</nav>
```

### Hero Section
```html
<section class="hero-section" style="background-image: url('hero.jpg')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Find Professional Services</h1>
            <p class="hero-subtitle">Connect with verified service providers</p>
            <div class="hero-search">
                <!-- Search form -->
            </div>
        </div>
    </div>
</section>
```

### Service Card
```html
<div class="service-card">
    <div class="service-card-image">
        <img src="service.jpg" alt="Service">
        <span class="service-card-badge">Featured</span>
        <span class="service-card-price">$50/hr</span>
    </div>
    <div class="service-card-body">
        <h3 class="service-card-title">House Cleaning</h3>
        <p class="service-card-description">Professional cleaning service</p>
        <div class="service-card-meta">
            <div class="service-card-rating">
                <i class="bi bi-star-fill"></i> 4.8
            </div>
            <div class="service-card-meta-item">
                <i class="bi bi-geo-alt"></i> New York
            </div>
        </div>
        <button class="btn btn-primary btn-sm">Book Now</button>
    </div>
</div>
```

### Provider Card
```html
<div class="provider-card">
    <div class="provider-card-header">
        <div class="provider-avatar-wrapper">
            <div class="avatar avatar-lg">
                <img src="provider.jpg" alt="Provider">
            </div>
            <div class="provider-verified-badge">
                <i class="bi bi-check"></i>
            </div>
        </div>
        <div class="provider-card-info">
            <h3 class="provider-card-name">John Doe</h3>
            <p class="provider-card-specialty">Professional Cleaner</p>
            <div class="provider-card-stats">
                <span class="provider-card-stat">
                    <i class="bi bi-star-fill"></i> 4.9
                </span>
                <span class="provider-card-stat">
                    <i class="bi bi-briefcase"></i> 150 jobs
                </span>
            </div>
        </div>
    </div>
    <div class="provider-card-tags">
        <span class="provider-tag">Verified</span>
        <span class="provider-tag">Top Rated</span>
    </div>
    <button class="btn btn-primary btn-md">View Profile</button>
</div>
```

## Provider Dashboard Components

### Sidebar Layout
```html
<div class="provider-layout">
    <aside class="provider-sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo">C</div>
            <span class="sidebar-brand-text">Cleanova</span>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="sidebar-nav-item active">
                <i class="sidebar-nav-icon bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <!-- More nav items -->
        </nav>
    </aside>
    <main class="provider-main">
        <div class="provider-topbar">
            <h1 class="topbar-title">Dashboard</h1>
        </div>
        <div class="provider-content">
            <!-- Content here -->
        </div>
    </main>
</div>
```

### Stats Cards
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
        <div class="stat-card-value">24</div>
        <div class="stat-card-label">Active Bookings</div>
    </div>
    <!-- More stat cards -->
</div>
```

### Data Table
```html
<div class="data-table-wrapper">
    <div class="data-table-header">
        <h2 class="data-table-title">Recent Bookings</h2>
        <div class="data-table-actions">
            <button class="btn btn-primary btn-sm">Add New</button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>House Cleaning</td>
                <td>2026-01-30</td>
                <td><span class="badge badge-success">Confirmed</span></td>
                <td>
                    <button class="btn btn-ghost btn-xs">View</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

## Admin Dashboard Components

### Admin Sidebar
```html
<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <div class="admin-logo">C</div>
        <span class="admin-brand-text">Admin</span>
    </div>
    <nav class="admin-sidebar-nav">
        <div class="admin-nav-section">
            <h4 class="admin-nav-section-title">Main</h4>
            <div class="admin-nav-items">
                <a href="#" class="admin-nav-item active">
                    <i class="admin-nav-icon bi bi-speedometer2"></i>
                    <span class="admin-nav-text">Dashboard</span>
                </a>
                <!-- More items -->
            </div>
        </div>
    </nav>
</aside>
```

### Admin Stats
```html
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div class="admin-stat-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="admin-stat-trend">
                <i class="bi bi-arrow-up"></i> 8.2%
            </div>
        </div>
        <div class="admin-stat-value">1,234</div>
        <div class="admin-stat-label">Total Users</div>
        <div class="admin-stat-footer">
            Last updated 5 minutes ago
        </div>
    </div>
    <!-- More stat cards -->
</div>
```

## Authentication Pages

### Login Page
```html
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-visual">
                <div class="auth-visual-content">
                    <div class="auth-visual-logo">C</div>
                    <h1 class="auth-visual-title">Welcome Back</h1>
                    <p class="auth-visual-description">
                        Sign in to access your account
                    </p>
                </div>
            </div>
            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h2 class="auth-form-title">Sign In</h2>
                    <p class="auth-form-subtitle">Enter your credentials</p>
                </div>
                <form class="auth-form">
                    <div class="auth-form-group">
                        <label class="auth-form-label">Email</label>
                        <input type="email" class="auth-form-input" placeholder="you@example.com">
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-form-label">Password</label>
                        <div class="auth-password-group">
                            <input type="password" class="auth-form-input auth-password-input" placeholder="••••••••">
                            <button type="button" class="auth-password-toggle">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="auth-form-options">
                        <div class="auth-checkbox-group">
                            <input type="checkbox" class="auth-checkbox" id="remember">
                            <label class="auth-checkbox-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="auth-forgot-link">Forgot password?</a>
                    </div>
                    <button type="submit" class="auth-submit-btn">Sign In</button>
                </form>
                <div class="auth-footer">
                    Don't have an account? <a href="#" class="auth-footer-link">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</div>
```

## Utility Classes

### Spacing
- Margin: `.mt-1` to `.mt-8`, `.mb-1` to `.mb-8`
- Padding: `.p-0` to `.p-8`

### Colors
- Text: `.text-primary`, `.text-secondary`, `.text-muted`, `.text-success`, `.text-warning`, `.text-danger`
- Background: `.bg-primary`, `.bg-secondary`, `.bg-white`

### Border Radius
- `.rounded-sm`, `.rounded`, `.rounded-md`, `.rounded-lg`, `.rounded-xl`, `.rounded-2xl`, `.rounded-full`

### Shadows
- `.shadow-sm`, `.shadow`, `.shadow-md`, `.shadow-lg`, `.shadow-xl`, `.shadow-none`

### Animations
- `.animate-fade-in` - Fade in animation
- `.animate-fade-in-up` - Fade in from bottom
- `.animate-slide-in-right` - Slide in from right
- `.stagger-animation` - Stagger children animations

## Best Practices

1. **Always use design tokens** instead of hardcoded values
2. **Maintain consistency** by using the predefined component classes
3. **Follow the spacing scale** for margins and padding
4. **Use semantic color names** (success, warning, danger) for appropriate contexts
5. **Test responsiveness** on multiple screen sizes
6. **Ensure accessibility** with proper contrast ratios and keyboard navigation
7. **Optimize performance** by avoiding inline styles when possible

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Migration Guide

If you're updating existing pages:

1. Include the new CSS files in your layout
2. Replace old class names with new design system classes
3. Update color values to use CSS custom properties
4. Test all interactive elements
5. Verify responsive behavior

## Support

For questions or issues with the design system, please refer to this documentation or contact the development team.
