# Design System Quick Reference

## 🎨 Color Variables

```css
/* Primary Colors */
var(--primary-900)  /* #0a1829 - Darkest */
var(--primary-800)  /* #0f2854 */
var(--primary-700)  /* #1c4d8d - Main Brand */
var(--primary-500)  /* #4988c4 - Interactive */
var(--primary-200)  /* #bde8f5 - Light BG */
var(--primary-50)   /* #f3fbff - Subtle BG */

/* Neutral Colors */
var(--neutral-900)  /* #091426 - Primary Text */
var(--neutral-700)  /* #334155 - Secondary Text */
var(--neutral-500)  /* #64748b - Muted Text */
var(--neutral-300)  /* #cbd5e1 - Borders */
var(--neutral-100)  /* #f1f5f9 - Backgrounds */

/* Semantic Colors */
var(--success-600)  /* Green */
var(--warning-600)  /* Orange */
var(--danger-600)   /* Red */
var(--info-600)     /* Blue */
```

## 📏 Spacing Scale

```css
var(--space-1)   /* 4px */
var(--space-2)   /* 8px */
var(--space-3)   /* 12px */
var(--space-4)   /* 16px */
var(--space-5)   /* 20px */
var(--space-6)   /* 24px */
var(--space-8)   /* 32px */
var(--space-12)  /* 48px */
```

## 🔘 Border Radius

```css
var(--radius-sm)    /* 6px */
var(--radius-base)  /* 8px */
var(--radius-md)    /* 12px */
var(--radius-lg)    /* 16px */
var(--radius-xl)    /* 20px */
var(--radius-full)  /* 9999px */
```

## 🔤 Typography

```html
<!-- Display Headings -->
<h1 class="text-display-1">48px, Black</h1>
<h2 class="text-display-2">36px, Extrabold</h2>
<h3 class="text-display-3">30px, Bold</h3>

<!-- Regular Headings -->
<h1 class="text-heading-1">24px, Bold</h1>
<h2 class="text-heading-2">20px, Semibold</h2>
<h3 class="text-heading-3">18px, Semibold</h3>

<!-- Body Text -->
<p class="text-body-lg">18px</p>
<p class="text-body">16px</p>
<p class="text-body-sm">14px</p>
<p class="text-caption">12px</p>
```

## 🔘 Buttons

```html
<!-- Sizes -->
<button class="btn btn-primary btn-xs">Extra Small</button>
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary btn-md">Medium</button>
<button class="btn btn-primary btn-lg">Large</button>

<!-- Variants -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-outline">Outline</button>
<button class="btn btn-ghost">Ghost</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-warning">Warning</button>
```

## 🎴 Cards

```html
<!-- Basic Card -->
<div class="card">
    <div class="card-header">Header</div>
    <div class="card-body">Content</div>
    <div class="card-footer">Footer</div>
</div>

<!-- Card Variants -->
<div class="card card-hover">Hover Effect</div>
<div class="card card-elevated">More Shadow</div>
<div class="card card-flat">No Shadow</div>
<div class="card card-gradient">Gradient BG</div>
```

## 📝 Forms

```html
<!-- Form Group -->
<div class="form-group">
    <label class="form-label">Label</label>
    <input type="text" class="form-control" placeholder="Placeholder">
    <span class="form-help">Help text</span>
    <span class="form-error">Error message</span>
</div>

<!-- Select -->
<select class="form-select">
    <option>Option 1</option>
</select>

<!-- Textarea -->
<textarea class="form-textarea"></textarea>
```

## 🏷️ Badges

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-danger">Danger</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-neutral">Neutral</span>
```

## 👤 Avatars

```html
<!-- With Image -->
<div class="avatar avatar-md">
    <img src="user.jpg" alt="User">
</div>

<!-- With Initials -->
<div class="avatar avatar-lg">JD</div>

<!-- Sizes -->
<div class="avatar avatar-xs">24px</div>
<div class="avatar avatar-sm">32px</div>
<div class="avatar avatar-md">40px</div>
<div class="avatar avatar-lg">56px</div>
<div class="avatar avatar-xl">80px</div>
```

## 🎯 Utility Classes

```html
<!-- Spacing -->
<div class="mt-4">Margin Top 16px</div>
<div class="mb-6">Margin Bottom 24px</div>
<div class="p-5">Padding 20px</div>

<!-- Colors -->
<p class="text-primary">Primary Color</p>
<p class="text-muted">Muted Color</p>
<div class="bg-primary">Primary BG</div>

<!-- Border Radius -->
<div class="rounded-lg">16px Radius</div>
<div class="rounded-full">Full Radius</div>

<!-- Shadows -->
<div class="shadow-sm">Small Shadow</div>
<div class="shadow-lg">Large Shadow</div>

<!-- Animations -->
<div class="animate-fade-in">Fade In</div>
<div class="animate-fade-in-up">Fade In Up</div>
```

## 📊 Stats Cards (Provider/Admin)

```html
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
```

## 📋 Data Tables

```html
<div class="data-table-wrapper">
    <div class="data-table-header">
        <h2 class="data-table-title">Table Title</h2>
        <div class="data-table-actions">
            <button class="btn btn-primary btn-sm">Add</button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data 1</td>
                <td>Data 2</td>
            </tr>
        </tbody>
    </table>
</div>
```

## 🎨 Seeker Components

```html
<!-- Service Card -->
<div class="service-card">
    <div class="service-card-image">
        <img src="service.jpg" alt="Service">
        <span class="service-card-badge">Featured</span>
        <span class="service-card-price">$50/hr</span>
    </div>
    <div class="service-card-body">
        <h3 class="service-card-title">Title</h3>
        <p class="service-card-description">Description</p>
        <div class="service-card-meta">
            <div class="service-card-rating">
                <i class="bi bi-star-fill"></i> 4.8
            </div>
        </div>
        <button class="btn btn-primary btn-sm">Book</button>
    </div>
</div>

<!-- Provider Card -->
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
            <p class="provider-card-specialty">Cleaner</p>
        </div>
    </div>
    <button class="btn btn-primary">View Profile</button>
</div>
```

## 🔐 Auth Components

```html
<!-- Auth Page -->
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-visual">
                <!-- Visual content -->
            </div>
            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h2 class="auth-form-title">Sign In</h2>
                </div>
                <form class="auth-form">
                    <div class="auth-form-group">
                        <label class="auth-form-label">Email</label>
                        <input type="email" class="auth-form-input">
                    </div>
                    <button type="submit" class="auth-submit-btn">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
```

## 🎯 Common Patterns

### Responsive Grid
```html
<div class="row g-4">
    <div class="col-12 col-md-6 col-lg-4">Column</div>
    <div class="col-12 col-md-6 col-lg-4">Column</div>
    <div class="col-12 col-md-6 col-lg-4">Column</div>
</div>
```

### Flex Layout
```html
<div class="d-flex justify-content-between align-items-center">
    <div>Left</div>
    <div>Right</div>
</div>
```

### Status Badge
```html
@if($status === 'active')
    <span class="badge badge-success">Active</span>
@elseif($status === 'pending')
    <span class="badge badge-warning">Pending</span>
@else
    <span class="badge badge-danger">Inactive</span>
@endif
```

### Loading State
```html
<button class="btn btn-primary" disabled>
    <div class="auth-loading">
        <div class="auth-spinner"></div>
        <span>Loading...</span>
    </div>
</button>
```

## 📱 Responsive Breakpoints

```css
/* Mobile First */
.element { /* Mobile styles */ }

/* Tablet and up */
@media (min-width: 768px) {
    .element { /* Tablet styles */ }
}

/* Desktop and up */
@media (min-width: 1024px) {
    .element { /* Desktop styles */ }
}
```

## 🎨 CSS File Includes

```html
<!-- Seeker Pages -->
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/seeker.css') }}">

<!-- Provider Pages -->
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/provider.css') }}">

<!-- Admin Pages -->
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<!-- Auth Pages -->
<link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
```

## 💡 Pro Tips

1. **Always use design tokens** for colors and spacing
2. **Combine utility classes** for quick styling
3. **Use semantic color names** (success, warning, danger)
4. **Test on mobile** devices regularly
5. **Follow Bootstrap grid** for layouts
6. **Use Bootstrap Icons** for consistency
7. **Add hover effects** with `card-hover` class
8. **Use animations** sparingly for better UX

## 🔍 Quick Debugging

```css
/* Add temporary border to see layout */
.debug { border: 1px solid red !important; }

/* Check spacing */
.debug-spacing { 
    background: rgba(255, 0, 0, 0.1) !important; 
}
```

## 📚 Resources

- Full Documentation: `DESIGN_SYSTEM.md`
- Implementation Guide: `IMPLEMENTATION_GUIDE.md`
- Project Summary: `PROJECT_SUMMARY.md`
- Bootstrap Docs: https://getbootstrap.com/docs/5.3/
- Bootstrap Icons: https://icons.getbootstrap.com/

---

**Print this page for quick reference while coding!** 🚀
