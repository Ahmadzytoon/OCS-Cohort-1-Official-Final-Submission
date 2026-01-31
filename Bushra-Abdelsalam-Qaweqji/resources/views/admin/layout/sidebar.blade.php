<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-broom"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Cleanova Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Management
    </div>

    <!-- Customers -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.customers') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Customers</span>
        </a>
    </li>

    <!-- Providers -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.providers') }}">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Service Providers</span>
        </a>
    </li>

    <!-- Bookings -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.bookings') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Bookings</span>
        </a>
    </li>

    <!-- Payments -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.payments') }}">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Payments</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
