<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ asset('admin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                    height="20" />
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>

            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('admin.index*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <!-- Section -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Management</h4>
                </li>

                <!-- Companies -->
                <li class="nav-item ">
                    <a href="{{ route('admin.companies.index') }}">
                        <i class="fas fa-building"></i>
                        <p>Companies</p>
                    </a>
                </li>

                <!-- Users -->
                <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#users">
                        <i class="fas fa-users"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="users">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.users.index') }}">
                                    <span class="sub-item">All Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.create') }}">
                                    <span class="sub-item">Add User</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.accessRequests') }}">
                                    <span class="sub-item">Access Requests</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Access Requests -->
                {{-- <li class="nav-item ">
                    <a href="{{ route('admin.index') }}">
                        <i class="fas fa-user-lock"></i>
                        <p>Access Requests</p>
                    </a>
                </li> --}}

                <!-- Departments -->
                <li class="nav-item {{ request()->routeIs('admin.departments*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#departments">
                        <i class="fas fa-server"></i>
                        <p>Departments</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.departments*') ? 'show' : '' }}"
                        id="departments">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.departments.index') }}">
                                    <span class="sub-item">All Departments</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.departments.create') }}">
                                    <span class="sub-item">Add Department</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <!-- Knowledge Management -->
                <li class="nav-item {{ request()->routeIs('admin.knowledge*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#knowledge">
                        <i class="fas fa-file-export"></i>
                        <p>Knowledge Management </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.knowledge*') ? 'show' : '' }}" id="knowledge">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.knowledgeItems.index') }}">
                                    <span class="sub-item">knowledge Items</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>

                <!-- Cards & Content -->
                {{-- <li class="nav-item ">
                    <a href="{{ route('admin.index') }}">
                        <i class="far fa-folder-open"></i>
                        <p>Cards & Content</p>
                    </a>
                </li> --}}

                <!-- AI Settings-->
                <li class="nav-item ">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fab fa-searchengin"></i>
                        <p>AI Settings</p>
                    </a>
                </li>

                <!-- Plans-->
                <li class="nav-item ">
                    <a href="{{ route('admin.plans.index') }}">
                        <i class="fas fa-code-branch"></i>
                        <p>Plans</p>
                    </a>
                </li>

                <!-- Subscriptions-->
                <li class="nav-item ">
                    <a href="{{ route('admin.subscriptions.index') }}">
                        <i class="fas fa-share-square"></i>
                        <p>Subscriptions</p>
                    </a>
                </li>

                <!-- Payments-->
                <li class="nav-item ">
                    <a href="{{ route('admin.payments') }}">
                        <i class="fas fa-credit-card"></i>
                        <p>Payments</p>
                    </a>
                </li>

                <!-- Section -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Settings</h4>
                </li>

                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('admin.setting*') ? 'active' : '' }}">
                    <a href="{{ route('admin.setting') }}">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>




                <!-- Departments -->
                {{-- <li class="nav-item {{ request()->routeIs('admin.departments*') ? 'active' : '' }}">
                    <a href="{{ route('admin.departments.index') }}">
                        <i class="fas fa-building"></i>
                        <p>Departments</p>
                    </a>
                </li> --}}

                <!-- Projects -->
                {{-- <li class="nav-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                    <a href="{{ route('admin.projects.index') }}">
                        <i class="fas fa-tasks"></i>
                        <p>Projects</p>
                    </a>
                </li> --}}

                <!-- Settings -->
                {{-- <li class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li> --}}

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
