<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cleanova')</title>

    <!-- Bootstrap (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap (Icons) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS (single file) -->
    <link rel="stylesheet" href="{{ asset('seeker/css/style.css') }}">

    @livewireStyles
</head>

<body class="cc-body">

    @include('seeker.partials.navbar')

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS (single file) -->
    <script src="{{ asset('seeker/js/main.js') }}"></script>
    @livewireScripts
    <script>
        document.addEventListener('scroll', function() {
            const navbar = document.querySelector('.cc-navbar');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>
