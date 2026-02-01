<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Book Store Admin')</title>
    
    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Your Custom CSS -->
    <link href="{{ asset('assets/admin/css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>

<body>
    @include('partials.sidebar')
    
    <div class="main-content">
        @include('partials.topbar')
        
        <div class="content-section">
            @yield('content')
        </div>
    </div>

    <!-- Include all modals (CORRECTED PATHS) -->
    {{-- @include('partials.modals.add-user-modal') --}}
    @include('partials.modals.add-book-modal')
    @include('partials.modals.add-category-modal')
    @include('partials.modals.add-author-modal')
    @include('partials.modals.order-detail-modal')
    @include('partials.modals.adjust-stock-modal')
    @include('partials.modals.add-coupon-modal')

    <!-- External JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
    <!-- SweetAlert2 Session Messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    timer: 5000,
                    showConfirmButton: true
                });
            @endif

            @if($errors->any())
                let errorHtml = '<ul class="text-start">';
                @foreach($errors->all() as $error)
                    errorHtml += '<li>{{ $error }}</li>';
                @endforeach
                errorHtml += '</ul>';

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Errors',
                    html: errorHtml,
                    showConfirmButton: true
                });
            @endif
        });
    </script>

    @stack('scripts')

    <!-- SweetAlert2 -->
</body>
</html>