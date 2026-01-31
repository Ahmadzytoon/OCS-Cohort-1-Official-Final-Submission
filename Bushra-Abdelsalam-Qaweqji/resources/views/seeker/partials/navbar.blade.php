<nav class="navbar navbar-expand-lg cc-navbar fixed-top">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="{{ url('/') }}">
            <span class="cc-logo d-inline-flex align-items-center justify-content-center">C</span>
            <span>Cleanova</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ccNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="ccNav">
            <ul class="navbar-nav mx-auto">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('seeker.providers-list') }}">Find Cleaners</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seeker.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seeker.bookings.index') }}">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seeker.profile') }}">Profile</a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register.seeker') }}">Register</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

