<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-book-open"></i> BookStore Admin</h3>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-page="users">
            <i class="fas fa-users"></i> User Management
        </a>
        <a href="{{ route('admin.books.index') }}" class="menu-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}" data-page="books">
            <i class="fas fa-book"></i> Book Management
        </a>
        <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-page="categories">
            <i class="fas fa-list"></i> Categories
        </a>
        <a href="{{ route('admin.authors.index') }}" class="menu-item {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}" data-page="authors">
            <i class="fas fa-user-edit"></i> Authors
        </a>
        <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-page="orders">
            <i class="fas fa-shopping-cart"></i> Order Management
        </a>
        <a href="{{ route('admin.stock.index') }}" class="menu-item {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}" data-page="stock">
            <i class="fas fa-boxes"></i> Stock Management
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="menu-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" data-page="coupons">
            <i class="fas fa-tags"></i> Coupons & Discounts
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="menu-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" data-page="reviews">
            <i class="fas fa-star"></i> Reviews & Ratings
        </a>

        <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
            @csrf
            <button type="submit" class="menu-item" style="width: 100%; text-align: left; border: none; background: transparent; color: white; font: inherit; padding: 0.75rem 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>