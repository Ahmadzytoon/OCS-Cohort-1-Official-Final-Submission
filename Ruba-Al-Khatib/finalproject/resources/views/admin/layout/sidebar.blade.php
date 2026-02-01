<div class="bg-dark-sidebar border-end" id="sidebar-wrapper">
    <div class="sidebar-heading text-white py-4 px-3">
        <h4 class="m-0">
            <i class="fas fa-layer-group me-2"></i> KaiAdmin
        </h4>
    </div>

    <div class="list-group list-group-flush px-3">

        <a href="{{ route('admin.dashboard') }}"
            class="list-group-item list-group-item-action mb-2
           {{ request()->routeIs('admin.dashboard') ? 'active-nav' : '' }}">
            <i class="fas fa-home me-3"></i> Dashboard
        </a>

        <a href="{{ route('admin.users') }}"
            class="list-group-item list-group-item-action mb-2
           {{ request()->routeIs('admin.users') ? 'active-nav' : '' }}">
            <i class="fas fa-users me-3"></i> Users
        </a>

        <a href="{{ route('admin.photographers') }}"
            class="list-group-item list-group-item-action mb-2
           {{ request()->routeIs('admin.photographers') ? 'active-nav' : '' }}">
            <i class="fas fa-camera me-3"></i> Photographer Approvals
        </a>

        <a href="{{ route('admin.studios') }}"
            class="list-group-item list-group-item-action mb-2
           {{ request()->routeIs('admin.studios') ? 'active-nav' : '' }}">
            <i class="fas fa-camera me-3"></i> Studios
        </a>

        <a href="{{ route('admin.bookings') }}"
            class="list-group-item list-group-item-action mb-2
           {{ request()->routeIs('admin.bookings') ? 'active-nav' : '' }}">
            <i class="fas fa-calendar-alt me-3"></i> Bookings
        </a>

        <a href="{{ route('admin.subscriptions.index') }}" class="nav-link">
            <i class="fas fa-credit-card me-2"></i> Subscriptions
        </a>




    </div>
</div>