@php
$user = auth()->user();
$profile = $user?->photographer;

$avatarSrc = ($profile && $profile->avatar)
? asset('storage/'.$profile->avatar)
: 'https://ui-avatars.com/api/?name='.urlencode($user->full_name ?? 'User').'&background=a67c52&color=fff';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Photographer Dashboard')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')

    <style>
        /* ===== Design System Variables ===== */
        :root {
            /* Color Palette */
            --primary-accent: #a67c52;
            --secondary-accent: #c4a484;
            --background: #faf7f8;
            --text-dark: #232222;
            --text-gray: #64748b;
            --white: #ffffff;
            --success: #4ade80;
            --error: #f87171;

            /* Additional Variables */
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --light-gray: #f3f4f6;
            --hover-bg: #f9fafb;

            /* Typography */
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body: 'Inter', 'Segoe UI', system-ui, sans-serif;

            /* Spacing */
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --spacing-xl: 3rem;

            /* Border Radius */
            --radius-sm: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;

            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);

            /* Transitions */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }

        /* ===== Reset & Base Styles ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            color: var(--text-dark);
            background-color: var(--background);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 1.3;
            color: var(--text-dark);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: var(--spacing-md);
        }

        h2 {
            font-size: 2rem;
            margin-bottom: var(--spacing-md);
        }

        h3 {
            font-size: 1.5rem;
            margin-bottom: var(--spacing-sm);
        }

        p {
            margin-bottom: var(--spacing-sm);
            color: var(--text-gray);
        }

        a {
            text-decoration: none;
            color: var(--primary-accent);
            transition: color var(--transition-fast);
        }

        a:hover {
            color: var(--secondary-accent);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }

        /* ===== Buttons ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all var(--transition-normal);
            font-family: var(--font-body);
        }

        .btn-primary {
            background-color: var(--primary-accent);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--secondary-accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary-accent);
            border: 2px solid var(--primary-accent);
        }

        .btn-secondary:hover {
            background-color: var(--primary-accent);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success);
            color: var(--white);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            background-color: var(--light-gray);
            border-color: var(--primary-accent);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* ===== Cards ===== */
        .card {
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: var(--spacing-lg);
            transition: transform var(--transition-normal), box-shadow var(--transition-normal);
            border: 1px solid var(--border-color);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
            padding-bottom: var(--spacing-sm);
            border-bottom: 1px solid var(--border-color);
        }

        /* ===== Photographer Dashboard Layout ===== */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
            gap: 0;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            padding: var(--spacing-lg);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .photographer-info {
            text-align: center;
            padding-bottom: var(--spacing-lg);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: var(--spacing-lg);
        }

        .photographer-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--secondary-accent);
            margin-bottom: var(--spacing-md);
        }

        .photographer-name {
            font-size: 1.5rem;
            margin-bottom: var(--spacing-xs);
        }

        .photographer-specialty {
            color: var(--primary-accent);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }

        .rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            margin-bottom: var(--spacing-sm);
        }

        .star {
            color: #fbbf24;
        }

        .rating-value {
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: var(--radius-md);
            color: var(--text-gray);
            transition: all var(--transition-fast);
        }

        .nav-item:hover {
            background-color: var(--light-gray);
            color: var(--primary-accent);
        }

        .nav-item.active {
            background-color: var(--primary-accent);
            color: var(--white);
        }

        .nav-item.active .nav-icon {
            color: var(--white);
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            color: var(--text-gray);
        }

        /* ===== Main Content ===== */
        .main-content {
            padding: var(--spacing-lg);
            overflow-y: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 0;
        }

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1rem;
        }

        /* ===== Stats Grid ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            padding: var(--spacing-lg);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.bookings {
            background-color: rgba(166, 124, 82, 0.1);
            color: var(--primary-accent);
        }

        .stat-icon.earnings {
            background-color: rgba(74, 222, 128, 0.1);
            color: var(--success);
        }

        .stat-icon.rating {
            background-color: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .stat-icon.pending {
            background-color: rgba(248, 113, 113, 0.1);
            color: var(--error);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--text-gray);
            font-size: 0.875rem;
        }

        /* ===== Bookings Table ===== */
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .bookings-table th {
            background-color: var(--light-gray);
            padding: var(--spacing-md);
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-color);
        }

        .bookings-table td {
            padding: var(--spacing-md);
            border-bottom: 1px solid var(--border-color);
        }

        .bookings-table tr:last-child td {
            border-bottom: none;
        }

        .bookings-table tr:hover {
            background-color: var(--hover-bg);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-confirmed {
            background-color: rgba(74, 222, 128, 0.1);
            color: var(--success);
        }

        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .status-cancelled {
            background-color: rgba(248, 113, 113, 0.1);
            color: var(--error);
        }

        /* ===== Portfolio Grid ===== */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-md);
        }

        .portfolio-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: transform var(--transition-normal);
        }

        .portfolio-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .portfolio-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .portfolio-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: var(--spacing-md);
            color: var(--white);
            transform: translateY(100%);
            transition: transform var(--transition-normal);
        }

        .portfolio-item:hover .portfolio-overlay {
            transform: translateY(0);
        }

        .portfolio-actions {
            position: absolute;
            top: var(--spacing-md);
            right: var(--spacing-md);
            display: flex;
            gap: var(--spacing-xs);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .portfolio-item:hover .portfolio-actions {
            opacity: 1;
        }

        .portfolio-actions .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 50%;
        }

        /* ===== Form Styles ===== */
        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        .form-label {
            display: block;
            margin-bottom: var(--spacing-xs);
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-family: var(--font-body);
            font-size: 1rem;
            transition: border-color var(--transition-fast);
            background-color: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-accent);
            box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* ===== Calendar ===== */
        .calendar-container {
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
        }

        .fc {
            font-family: var(--font-body);
        }

        .fc .fc-button-primary {
            background-color: var(--primary-accent);
            border-color: var(--primary-accent);
        }

        .fc .fc-button-primary:hover {
            background-color: var(--secondary-accent);
            border-color: var(--secondary-accent);
        }

        .fc .fc-button-primary:disabled {
            background-color: var(--text-gray);
            border-color: var(--text-gray);
        }

        /* ===== Earnings Chart ===== */
        .earnings-chart {
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
        }

        .chart-placeholder {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--light-gray);
            border-radius: var(--radius-md);
            color: var(--text-gray);
        }

        /* ===== Responsive Design ===== */
        @media (max-width: 1024px) {
            .dashboard-layout {
                grid-template-columns: 250px 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .main-content {
                padding: var(--spacing-md);
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-md);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .portfolio-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .portfolio-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.75rem;
            }
        }

        /* ===== Utility Classes ===== */
        .hidden {
            display: none !important;
        }

        .text-center {
            text-align: center;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mt-0 {
            margin-top: 0;
        }

        .mb-1 {
            margin-bottom: var(--spacing-xs);
        }

        .mb-2 {
            margin-bottom: var(--spacing-sm);
        }

        .mb-3 {
            margin-bottom: var(--spacing-md);
        }

        .mb-4 {
            margin-bottom: var(--spacing-lg);
        }

        .mb-5 {
            margin-bottom: var(--spacing-xl);
        }

        .mt-1 {
            margin-top: var(--spacing-xs);
        }

        .mt-2 {
            margin-top: var(--spacing-sm);
        }

        .mt-3 {
            margin-top: var(--spacing-md);
        }

        .mt-4 {
            margin-top: var(--spacing-lg);
        }

        .mt-5 {
            margin-top: var(--spacing-xl);
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .gap-1 {
            gap: var(--spacing-xs);
        }

        .gap-2 {
            gap: var(--spacing-sm);
        }

        .gap-3 {
            gap: var(--spacing-md);
        }

        .gap-4 {
            gap: var(--spacing-lg);
        }

        .w-100 {
            width: 100%;
        }

        /* ===== Page Transitions ===== */
        .page-section {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body>

    <div class="dashboard-layout">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="photographer-info">
                <img class="avatar" src="{{ $avatarSrc }}" alt="Avatar">


                <h3 class="photographer-name">{{ auth()->user()->full_name }}</h3>
                <p class="photographer-specialty">
                    @php
                    $profile = auth()->user()?->photographerProfile; // أو ->photograph حسب علاقتك
                    @endphp

                    {{ is_array($profile->photography_types)
                   ? implode(', ', $profile->photography_types)
                   : ($profile->photography_types ?? 'Photographer')
                    }}
                </p>


                <p class="text-gray">Status: {{ auth()->user()->status ?? '-' }}</p>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('photographer.dashboard') }}"
                    class="nav-item {{ request()->routeIs('photographer.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-home"></i></span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('photographer.profile.show') }}"
                    class="nav-item {{ request()->routeIs('photographer.profile.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-user"></i></span>
                    <span>Profile</span>
                </a>
                <a href="{{ route('pricing') }}"
                 class="nav-item {{ request()->routeIs('pricing') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-credit-card"></i></span>
                 <span>Manage Subscription</span>
                </a>


                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="nav-item w-100" style="background:none;border:none;text-align:left;">
                        <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

</body>

</html>