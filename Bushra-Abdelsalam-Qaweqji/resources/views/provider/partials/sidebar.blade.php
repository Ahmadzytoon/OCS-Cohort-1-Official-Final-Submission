<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('provider.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-broom"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Cleanova Provider</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('provider.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Management
    </div>

    <li class="nav-item {{ request()->routeIs('provider.bookings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('provider.bookings') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Bookings</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('provider.availability*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('provider.availability') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Availability</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('provider.services*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('provider.services') }}">
            <i class="fas fa-fw fa-concierge-bell"></i>
            <span>Services</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('provider.earnings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('provider.earnings') }}">
            <i class="fas fa-fw fa-coins"></i>
            <span>Earnings</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('provider.profile*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('provider.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
