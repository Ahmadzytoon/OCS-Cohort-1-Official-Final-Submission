<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="pixel-plus">
    <meta name="description" content="Boimela - Books Library eCommerce Store">
    <title>@yield('title', 'Boimela - Books Library eCommerce Store')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/user/images/favicon.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/pagination-style.css') }}">

    @stack('styles')
    @livewireStyles
</head>
<body>

    <!-- Header Top Section -->
    @include('user.header-top-section')

    <!-- Navbar -->
    @include('user.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('user.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/user/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('assets/user/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/user/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/main.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>




{{-- add offacnvas here or treate it --}}