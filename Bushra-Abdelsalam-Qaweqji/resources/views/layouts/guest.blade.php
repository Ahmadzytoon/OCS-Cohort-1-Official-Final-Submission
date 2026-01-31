<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('seeker/css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="cc-body cc-auth-body antialiased">
    <div class="cc-auth-wrap">
        <div class="cc-auth-card">
            <div class="cc-auth-image" style="background-image: url('{{ asset('seeker/img/images.png') }}');">
                <div class="cc-auth-image-overlay"></div>
            </div>
            <div class="cc-auth-panel">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
