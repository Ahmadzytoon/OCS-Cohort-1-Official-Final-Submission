<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 px-4 border-bottom">
    <div class="container-fluid p-0">
        <div class="d-flex align-items-center">
            <i class="fas fa-bars me-2" id="sidebarToggle"></i>
            <i class="fas fa-home me-2"></i>
            <span class="fw-bold">Dashboard</span>
        </div>
        
        <div class="ms-auto d-flex align-items-center">
            <!-- Search -->
            <div class="search-box me-4 d-none d-md-flex">
                <i class="fas fa-search text-muted"></i>
                <input type="text" class="form-control border-0 bg-light" placeholder="Search...">
            </div>

            <!-- Notifications + Profile -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">

                    <div class="position-relative me-2">
                        <i class="fas fa-bell text-muted"></i>
                        <span class="notification-badge"></span>
                    </div>

                    <span class="me-2 d-none d-sm-inline">Admin</span>
                    <img src="{{ asset('/img/Userprofile.png') }}"
                         class="rounded-circle admin-profile-img"
                         alt="Admin"
                         style="width:32px;height:32px;">
                </a>

                <!-- Dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li class="dropdown-header text-muted small">
                        Signed in as<br>
                        <strong>{{ auth()->user()->email ?? 'Admin' }}</strong>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    

                    <li><hr class="dropdown-divider"></li>

                    <!-- Logout -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
