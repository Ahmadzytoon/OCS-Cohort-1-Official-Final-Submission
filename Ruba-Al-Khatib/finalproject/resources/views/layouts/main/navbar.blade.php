<nav class="navbar navbar-expand-lg fixed-top">
    <!-- NAVBAR_OK -->

    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">LYDIA</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('photographers') ? 'active' : '' }}" href="{{ url('/photographers') }}">Photographers</a>
                </li>
                <li class="nav-item">

                    <a class="nav-link {{ request()->routeIs('studio') ? 'active' : '' }}" href="{{ url('/studio') }}">Studios</a>
                </li>
                <li class="nav-item">
                    {{-- نفس الفكرة اللي كانت عندك: How It Works --}}
                    <a class="nav-link {{ request()->routeIs('/') ? 'active' : '' }}" href="{{ url('/#how-it-works') }}">How It Works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
                        ABOUT US
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('features') ? 'active' : '' }}" href="{{ url('/features') }}">FEATURES</a>
                </li>

                {{-- AUTH LINKS --}}
                @guest
                <li class="nav-item nav-auth">
                    <a class="nav-link nav-login" href="{{ route('login') }}">LOG IN</a>
                </li>

                <li class="nav-item nav-auth">
                    <a class="nav-link nav-signup" href="{{ route('signup.step1') }}">SIGN UP</a>
                </li>
                @else
                @php
                $type = Auth::user()->accountType ?? 'user';
                @endphp

                <li class="nav-item dropdown nav-auth">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        {{ Auth::user()->fullName ?? Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">

                        @if($type === 'admin')
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                Admin Dashboard
                            </a>
                        </li>
                        @elseif($type === 'photographer')
                        <li>
                            <a class="dropdown-item" href="{{ route('photographer.dashboard') }}">
                                Photographer Dashboard
                            </a>
                        </li>
                        @else
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.home') }}">
                                My Dashboard
                            </a>
                        </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>