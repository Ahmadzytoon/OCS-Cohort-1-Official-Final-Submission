<div class="main-header">
    <div class="main-header-logo">
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

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">



            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">



                <!-- Messages -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                    </a>

                    <ul class="dropdown-menu messages-notif-box animated fadeIn">
                        <li>
                            <div class="dropdown-title d-flex justify-content-between align-items-center">
                                Messages
                                <a href="#" class="small">Mark all as read</a>
                            </div>
                        </li>

                        <li>
                            <div class="message-notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-img">
                                            <img src="{{ asset('admin/assets/img/jm_denis.jpg') }}" alt="Profile">
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject">Jimmy Denis</span>
                                            <span class="block">How are you?</span>
                                            <span class="time">5 minutes ago</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li>
                            <a class="see-all" href="#">See all messages <i class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
                </li>

                <!-- Notifications -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span class="notification">4</span>
                    </a>

                    <ul class="dropdown-menu notif-box animated fadeIn">
                        <li>
                            <div class="dropdown-title">You have 4 new notifications</div>
                        </li>

                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-icon notif-primary">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">New user registered</span>
                                            <span class="time">5 minutes ago</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li>
                            <a class="see-all" href="#">See all notifications <i
                                    class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
                </li>

                <!-- User -->
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                        <div class="avatar-sm">
                            <img src="{{ asset('admin/assets/img/profile.jpg') }}" class="avatar-img rounded-circle"
                                alt="User" />
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ auth()->user()->name ?? 'Admin' }}</span>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ asset('admin/assets/img/profile.jpg') }}" class="avatar-img rounded"
                                        alt="Profile" />
                                </div>
                                <div class="u-text">
                                    <h4>{{ auth()->user()->name ?? 'Admin' }}</h4>
                                    <p class="text-muted">{{ auth()->user()->email ?? '' }}</p>
                                    <a href="{{ route('admin.profile') }}" class="btn btn-xs btn-secondary btn-sm">
                                        View Profile
                                    </a>

                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('admin.setting') }}">Account Settings</a>
                            <div class="dropdown-divider"></div>

                            <form method="POST" action="{{ route('admin.logout') }}">

                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
