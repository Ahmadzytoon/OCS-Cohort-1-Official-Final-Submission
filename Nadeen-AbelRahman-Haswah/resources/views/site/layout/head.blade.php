<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - Arsha Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('site/landingPage/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('site/landingPage/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Jost:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Vendor CSS Files -->
    <link href="{{ asset('site/landingPage/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/landingPage/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('site/landingPage/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('site/landingPage/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/landingPage/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->



    @if (Route::is('site.loging.plans.plans'))
        <link href="{{ asset('site/logging/plans.css') }}" rel="stylesheet">
    @endif

    @if (Route::is('login.create', 'signup.create', 'accessRequest.create'))
        <link href="{{ asset('site/logging/style.css') }}" rel="stylesheet">
        <link href="{{ asset('site/logging/forms.css') }}" rel="stylesheet">
    @endif

    @if (Route::is('site.loging.choose'))
        <link href="{{ asset('site/logging/style.css') }}" rel="stylesheet">
    @endif

    <link href="{{ asset('site/landingPage/assets/css/main.css') }}" rel="stylesheet">




    @yield('css')
</head>
