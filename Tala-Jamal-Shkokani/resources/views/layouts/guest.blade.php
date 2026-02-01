<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chic & Co.') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Refined "Blush Luxe Noir" Palette */
            --color-primary-blush: #E87A90;
            --color-secondary-mauve: #C68CA0;
            --color-ink-black: #1A1A1A;
            --color-charcoal: #2F2F2F;
            --color-warm-gold: #D4AF37;
            --color-ivory: #FDFAF5;
            --color-cloud: #F8F5F2;
            --color-sage: #DCE8E6;

            /* Legacy mapping compatibility */
            --color-dusty-rose: var(--color-secondary-mauve);
            --color-warm-ivory: var(--color-ivory);

            --font-heading: 'Playfair Display', serif;
            --font-body: 'Lato', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-warm-ivory);
            overflow-x: hidden;
            color: var(--color-ink-black);
        }

        .split-screen {
            min-height: 100vh;
            display: flex;
        }

        /* Left Side - Visual Experience */
        .visual-side {
            flex: 1.2;
            background-image: url('https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            position: relative;
            display: none;
            flex-direction: column;
            justify-content: space-between;
            padding: 5rem;
        }

        .visual-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7));
            z-index: 1;
        }

        .visual-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        /* Right Side - Form Interaction */
        .form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #fff;
            max-width: 100%;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
            animation: fadeUp 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Typography & Branding */
        .brand-logo {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: white;
            text-decoration: none;
        }

        .quote-text {
            font-family: var(--font-heading);
            font-size: 3.5rem;
            font-weight: 600;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        /* Form Inputs - High End */
        .form-control {
            border-radius: 100px !important;
            padding: 16px 28px !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            background-color: #f8f9fa !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
        }

        .form-control:focus {
            background-color: white !important;
            border-color: var(--color-primary-blush) !important;
            box-shadow: 0 0 0 4px rgba(246, 166, 178, 0.1) !important;
            outline: none !important;
        }

        /* Buttons */
        .btn-luxury {
            background-color: var(--color-ink-black) !important;
            color: white !important;
            border-radius: 100px !important;
            padding: 18px 32px !important;
            font-weight: 600 !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
            width: 100% !important;
            border: none !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .btn-luxury:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
            background-color: #333 !important;
        }

        @media (min-width: 992px) {
            .visual-side {
                display: flex;
            }

            .form-side {
                max-width: 50vw;
                background-color: var(--color-warm-ivory);
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @livewireStyles
</head>

<body>
    <div class="split-screen">
        <!-- Visual Side -->
        <div class="visual-side">
            <div class="visual-overlay"></div>
            <div class="visual-content">
                <a href="/" class="brand-logo"><i class="fa-solid fa-gem me-2"></i>CHIC & CO.</a>
            </div>
            <div class="visual-content">
                <p class="h6 text-uppercase ls-2 mb-3 opacity-75">The Collection</p>
                <h2 class="quote-text">"Elegance is the only beauty that never fades."</h2>
                <div class="d-flex text-white-50 gap-4 mt-4">
                    <small>CURATED FASHION</small>
                    <small>&bull;</small>
                    <small>EXCLUSIVE ACCESS</small>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="form-side">
            <div class="form-container">
                <div class="d-lg-none text-center mb-5">
                    <a href="/" class="text-decoration-none text-dark">
                        <h2 class="mb-0"
                            style="font-family: var(--font-heading); letter-spacing: 2px; font-weight: 700;">
                            <i class="fa-solid fa-gem me-2" style="font-size: 1.5rem;"></i>CHIC & CO.
                        </h2>
                    </a>
                </div>

                {{ $slot }}

                <div class="text-center mt-5">
                    <a href="/" class="text-muted text-decoration-none small">
                        <i class="fa-solid fa-arrow-left me-2"></i> Return to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>