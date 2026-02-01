<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Chic & Co.' }} | {{ config('app.name', 'Wonderland') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --nav-height: 80px;

            /* Refined "Blush Luxe Noir" Palette */
            --color-primary-blush: #E87A90;
            /* Richer, warm blush */
            --color-secondary-mauve: #C68CA0;
            /* Soft accent */
            --color-ink-black: #1A1A1A;
            /* Deep neutral */
            --color-charcoal: #2F2F2F;
            /* Dark accent */
            --color-warm-gold: #D4AF37;
            /* Luxury metallic */
            --color-ivory: #FDFAF5;
            /* Warm neutral base */
            --color-cloud: #F8F5F2;
            /* Light section base */
            --color-sage: #DCE8E6;
            /* Subtle accent */

            /* Legacy mapping compatibility */
            --color-dusty-rose: var(--color-secondary-mauve);
            --color-warm-ivory: var(--color-ivory);

            /* Typography */
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Lato', sans-serif;

            --shadow-premium: 0 10px 40px rgba(26, 26, 26, 0.06);
            --transition-premium: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        html {
            font-size: 80%;
            /* Primary scale adjustment */
        }

        body {
            font-family: var(--font-body);
            color: var(--color-ink-black);
            background-color: var(--color-warm-ivory);
            cursor: default;
            overflow-x: hidden !important;
            line-height: 1.7;
            /* Remove explicit 1.05rem if we want the 80% html scale to work uniformly */
        }

        /* Breadcrumb Alignment Fix */
        .breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 0;
            padding: 0;
            list-style: none;
        }

        .breadcrumb-item {
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            line-height: 1;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "•";
            padding: 0 0.5rem;
            color: #ccc;
            font-size: 0.6em;
            line-height: 1;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: gray;
            transition: color 0.2s;
            display: inline-block;
        }

        .breadcrumb-item a:hover {
            color: black;
        }

        .breadcrumb-item.active {
            color: black;
            font-weight: 600;
        }

        /* Typography Helper Classes */
        .font-heading {
            font-family: var(--font-heading) !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: 700;
            color: var(--color-ink-black);
            letter-spacing: 0.5px;
        }

        .navbar {
            height: var(--nav-height);
            padding: 0;
            background: rgba(255, 255, 255, 0.95) !important;
            /* Higher opacity for solid band feel */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
            width: 100%;
            /* Ensure full width */
        }

        .navbar .container {
            max-width: 100%;
            /* Allow full width content */
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--color-ink-black) !important;
        }

        .nav-link {
            font-weight: 400;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            color: var(--color-ink-black) !important;
            padding: 0.5rem 1.2rem !important;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 1px;
            background: var(--color-ink-black);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover:after,
        .nav-link.active:after {
            width: 30%;
        }

        .nav-link.active {
            font-weight: 600;
        }

        .search-container {
            position: relative;
            width: 200px;
            transition: width 0.3s ease;
        }

        .search-input {
            background: rgba(0, 0, 0, 0.03);
            border: 1px solid transparent;
            border-radius: 100px;
            padding: 8px 15px 8px 35px;
            font-size: 0.8rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: white;
            border-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            width: 240px;
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .cart-icon-wrapper {
            position: relative;
            display: inline-block;
            margin-left: 15px;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: var(--color-ink-black);
            color: white;
            font-size: 0.6rem;
            min-width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .btn-primary-custom {
            background-color: var(--color-ink-black);
            color: white !important;
            border-radius: 100px;
            font-weight: 500;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 10px 25px !important;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #333;
        }

        main {
            padding-top: calc(var(--nav-height) + 10px);
            min-height: 80vh;
        }

        /* Product Cards & Aesthetics */
        .product-card {
            border: none;
            background: transparent;
            transition: all 0.3s ease;
        }

        .img-shadow-overlay {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
        }

        .img-shadow-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.05));
            pointer-events: none;
        }

        .quick-actions {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 20;
            padding: 0 15px;
        }

        .product-img-primary,
        .product-img-secondary {
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .product-card:hover .product-img-primary {
            transform: scale(1.1);
            opacity: 0.7;
        }

        .product-card:hover .product-img-secondary {
            opacity: 1 !important;
            transform: scale(1.05);
        }

        .btn-quick {
            background: white;
            color: var(--color-ink-black);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-quick:hover {
            background: var(--color-ink-black);
            color: white;
            transform: translateY(-3px);
        }

        .aesthetic-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 12px;
            border-radius: 100px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 10;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .aesthetic-soft {
            background: #FDE2E4;
            color: #AD2E41;
        }

        .aesthetic-alt {
            background: #E5E5E5;
            color: #1A1A1A;
        }

        .aesthetic-luxury {
            background: #FEFAE0;
            color: #B9975B;
        }

        .aesthetic-mix {
            background: #E0F2F1;
            color: #00796B;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        [x-cloak] {
            display: none !important;
        }

        .w-20 {
            width: 20px;
            text-align: center;
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
        }

        /* Update Utility Group */
        .utility-icon {
            font-size: 1.1rem;
            color: var(--color-ink-black);
            transition: all 0.2s ease;
            position: relative;
        }

        .utility-icon:hover {
            transform: scale(1.1);
            color: #000;
        }

        /* Premium Pagination Styling */
        .pagination {
            gap: 8px;
            border: none;
        }

        .page-item {
            border: none;
        }

        .page-link {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            color: var(--color-ink-black) !important;
            border-radius: 12px !important;
            padding: 10px 18px;
            font-size: 0.85rem;
            font-weight: 600;
            background: #fff;
            transition: var(--transition-premium);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .page-link:hover {
            background: var(--color-cloud) !important;
            color: var(--color-primary-blush) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-color: var(--color-primary-blush) !important;
        }

        .page-item.active .page-link {
            background: var(--color-ink-black) !important;
            border-color: var(--color-ink-black) !important;
            color: #fff !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .page-item.disabled .page-link {
            background: transparent !important;
            color: #ccc !important;
            opacity: 0.5;
            cursor: not-allowed;
            box-shadow: none;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            border-radius: 12px !important;
        }
    </style>
</head>

<body>
    <div id="app">
        @include('layouts.navigation')

        <main>
            @if(session('error'))
                <div class="container mt-3">
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert"><i
                            class="fa-solid fa-circle-exclamation me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            </div>@endif
            @yield('content')
            {{ $slot ?? '' }}
        </main>
        <footer class="py-5 mt-5 bg-white border-top">
            <div class="container text-center">
                <h4 class="mb-4"><i class="fa-solid fa-gem me-2"></i>CHIC & CO.</h4>
                <p class="text-muted small mb-4">Elevating everyday aesthetics with curated fashion.</p>
                <div class="d-flex justify-content-center gap-4 mb-4"><a href="#" class="text-dark"><i
                            class="fa-brands fa-instagram"></i></a><a href="#" class="text-dark"><i
                            class="fa-brands fa-pinterest"></i></a><a href="#" class="text-dark"><i
                            class="fa-brands fa-tiktok"></i></a></div>
                <p class="text-muted" style="font-size: 0.7rem;">&copy;

                    {{ date('Y') }}
                    CHIC & CO. All Rights Reserved.
                </p>
            </div>
        </footer>
    </div><livewire:cart-sidebar /><livewire:quick-add-to-cart />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const softSwal = {
            confirmButtonColor: 'var(--color-ink-black)',
            cancelButtonColor: 'var(--color-secondary-mauve)',
            background: '#ffffff',
            color: 'var(--color-ink-black)',
            customClass: {
                popup: 'rounded-5 shadow-lg p-4 border-0',
                title: 'font-heading fw-bold fs-3',
                confirmButton: 'btn btn-primary-custom rounded-pill px-4 py-2 border-0',
                cancelButton: 'btn btn-outline-secondary rounded-pill px-4 py-2 border-0'
            },
            buttonsStyling: false
        };

        const getSwalData = (event) => {
            if (event.detail && typeof event.detail === 'object') {
                return Array.isArray(event.detail) ? event.detail[0] : event.detail;
            }
            return {};
        };

        window.addEventListener('swal:success', event => {
            const data = getSwalData(event);
            Swal.fire({
                ...softSwal,
                title: data.title || 'Success',
                text: data.text || '',
                icon: 'success',
                iconColor: 'var(--color-primary-blush)'
            });
        });

        window.addEventListener('swal:auth-prompt', event => {
            Swal.fire({
                ...softSwal,
                title: 'Exclusive Access',
                text: 'To curate your final selection and secure your order, please sign in or join our archive.',
                icon: 'info',
                iconColor: 'var(--color-primary-blush)',
                showCancelButton: true,
                confirmButtonText: 'Sign In',
                cancelButtonText: 'Register',
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "{{ route('register') }}";
                }
            });
        });

        window.addEventListener('swal:error', event => {
            const data = getSwalData(event);
            Swal.fire({
                ...softSwal,
                title: data.title || 'Error',
                text: data.text || 'Something went wrong.',
                icon: 'error',
                iconColor: 'var(--color-ink-black)'
            });
        });

        window.addEventListener('open-cart', event => {
            const sidebar = document.getElementById('cartSidebar');
            if (sidebar) {
                const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
                bsOffcanvas.show();
            }
        });

        function triggerReviewModal(productName) {
            Swal.fire({
                ...softSwal,
                title: 'Review ' + productName,
                html: `
                    <div class="mb-3 text-start">
                        <label class="small text-muted mb-2 d-block text-uppercase ls-1">Your Rating</label>
                        <div class="d-flex gap-2 mb-4 fs-3 justify-content-center" id="star-rating">
                            <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(1)"></i>
                            <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(2)"></i>
                            <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(3)"></i>
                            <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(4)"></i>
                            <i class="fa-regular fa-star cursor-pointer transition-premium hover-scale" onclick="setRating(5)"></i>
                        </div>
                        <textarea class="form-control bg-light border-0 rounded-4 p-3" rows="3" placeholder="Share your experience..."></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit Review',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        ...softSwal,
                        title: 'Thank You!',
                        text: 'Your review has been shared with the community.',
                        icon: 'success'
                    });
                }
            });
        }

        function setRating(val) {
            const stars = document.querySelectorAll('#star-rating i');
            stars.forEach((star, index) => {
                if (index < val) {
                    star.classList.replace('fa-regular', 'fa-solid');
                    star.classList.add('text-warning');
                } else {
                    star.classList.replace('fa-solid', 'fa-regular');
                    star.classList.remove('text-warning');
                }
            });
        }

        function confirmLogout(formId) {
            Swal.fire({
                ...softSwal,
                title: 'Depart Curiosity?',
                text: 'Are you sure you wish to end your curated session?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Leave',
                cancelButtonText: 'Stay',
                iconColor: 'var(--color-ink-black)'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (formId) {
                        document.getElementById(formId).submit();
                    } else {
                        // Fallback search for any logout form
                        const form = document.querySelector('form[action*="logout"]');
                        if (form) form.submit();
                    }
                }
            });
        }
    </script>
    <script> // Global Backdrop & Scroll Lock Reaper
        // Ensures the page never gets stuck in a "dark/disabled" state
        document.addEventListener('livewire:navigated', cleanupUIState);
        document.addEventListener('hidden.bs.offcanvas', cleanupUIState);
        document.addEventListener('hidden.bs.modal', cleanupUIState);

        function cleanupUIState() {

            // Give a tiny timeout for animations to finish
            setTimeout(() => {
                const activeOffcanvas = document.querySelector('.offcanvas.show');
                const activeModal = document.querySelector('.modal.show');

                // If nothing is supposedly open, purge all leftovers
                if (!activeOffcanvas && !activeModal) {
                    // Remove all backdrops
                    document.querySelectorAll('.offcanvas-backdrop, .modal-backdrop').forEach(el => el.remove());
                    // Restore body styles
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    document.body.classList.remove('modal-open', 'offcanvas-open', 'overflow-hidden');
                }
            }

                , 350);
        }

    </script>
    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('trigger-confirm', (data) => {
                Swal.fire({
                    ...softSwal,
                    title: data.title || 'Are you sure?',
                    text: data.text || '',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: data.confirmButtonText || 'Confirm',
                    cancelButtonText: data.cancelButtonText || 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(data.method, data.params || {});
                    }
                });
            });
        });
    </script>
    <!-- Custom Toast Container -->
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; pointer-events: none;">
    </div>

    <script>
        window.addEventListener('show-toast', event => {
            const data = event.detail.length ? event.detail[0] : event.detail;
            showToast(data.message, data.type);
        });

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            // Premium aesthetics
            const baseClasses = 'toast show d-flex align-items-center border-0 shadow-lg rounded-4 mb-3 animate-fade-up';
            const bgClass = type === 'success' ? 'bg-white text-dark' : 'bg-dark text-white';
            const icon = type === 'success' ? '<i class="fa-solid fa-heart text-danger fs-5"></i>' : '<i class="fa-solid fa-info-circle fs-5"></i>';
            const borderColor = type === 'success' ? 'border-left: 4px solid var(--color-primary-blush);' : 'border-left: 4px solid #fff;';

            toast.className = `${baseClasses} ${bgClass}`;
            toast.style.cssText = `min-width: 300px; ${borderColor} pointer-events: auto;`;

            toast.innerHTML = `
                <div class="toast-body d-flex align-items-center w-100 py-3 px-4">
                    <div class="me-3">${icon}</div>
                    <div class="fw-bold extra-small text-uppercase ls-1">${message}</div>
                    <button type="button" class="btn-close ms-auto me-0" data-bs-dismiss="toast" aria-label="Close" style="filter: ${type === 'success' ? 'none' : 'invert(1)'}"></button>
                </div>
            `;

            container.appendChild(toast);

            // Auto remove
            setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('fade');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>