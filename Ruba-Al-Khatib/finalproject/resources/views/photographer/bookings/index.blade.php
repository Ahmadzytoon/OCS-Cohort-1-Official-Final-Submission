@extends('photographer.layout')

@section('title', 'Bookings Management')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --warning: #fbbf24;
            --info: #3b82f6;
            
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
        
        h1, h2, h3, h4, h5, h6 {
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
        
        .btn-success {
            background-color: var(--success);
            color: var(--white);
        }
        
        .btn-success:hover {
            background-color: #22c55e;
            transform: translateY(-2px);
        }
        
        .btn-error {
            background-color: var(--error);
            color: var(--white);
        }
        
        .btn-error:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
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
        
        .btn-xs {
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
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
        
        /* ===== Page Header ===== */
        .page-header {
            padding: var(--spacing-xl) 0 var(--spacing-lg);
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: var(--spacing-xl);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--spacing-md);
        }
        
        .header-title h1 {
            margin-bottom: var(--spacing-xs);
        }
        
        .header-actions {
            display: flex;
            gap: var(--spacing-sm);
        }
        
        /* ===== Main Content ===== */
        .main-content {
            padding-bottom: var(--spacing-xl);
        }
        
        /* ===== Filters & Search ===== */
        .filters-section {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
        }
        
        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-md);
            align-items: center;
        }
        
        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
            transition: border-color var(--transition-fast);
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--primary-accent);
            box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.1);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
        }
        
        .date-filter {
            display: flex;
            gap: var(--spacing-sm);
            align-items: center;
        }
        
        .date-filter input {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
        }
        
        /* ===== Status Tabs ===== */
        .status-tabs {
            display: flex;
            gap: var(--spacing-xs);
            background-color: var(--light-gray);
            padding: var(--spacing-xs);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-lg);
            flex-wrap: wrap;
        }
        
        .status-tab {
            padding: 0.75rem 1.5rem;
            border: none;
            background: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            color: var(--text-gray);
            cursor: pointer;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-tab:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: var(--text-dark);
        }
        
        .status-tab.active {
            background-color: var(--white);
            color: var(--primary-accent);
            box-shadow: var(--shadow-sm);
        }
        
        .tab-count {
            background-color: var(--light-gray);
            color: var(--text-gray);
            padding: 0.125rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-tab.active .tab-count {
            background-color: var(--primary-accent);
            color: var(--white);
        }
        
        /* ===== Bookings Table ===== */
        .bookings-table-container {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .bookings-table th {
            background-color: var(--light-gray);
            padding: var(--spacing-md);
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
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
        
        /* ===== Status Badges ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }
        
        .status-approved {
            background-color: rgba(74, 222, 128, 0.1);
            color: #059669;
            border: 1px solid rgba(74, 222, 128, 0.2);
        }
        
        .status-rejected {
            background-color: rgba(248, 113, 113, 0.1);
            color: #dc2626;
            border: 1px solid rgba(248, 113, 113, 0.2);
        }
        
        .status-completed {
            background-color: rgba(100, 116, 139, 0.1);
            color: #475569;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }
        
        /* ===== Customer Info ===== */
        .customer-info {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .customer-details h4 {
            font-size: 1rem;
            margin-bottom: 0.125rem;
        }
        
        .customer-details p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin-bottom: 0;
        }
        
        /* ===== Session Details ===== */
        .session-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .session-date {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .session-time {
            font-size: 0.875rem;
            color: var(--text-gray);
        }
        
        .session-type {
            font-size: 0.875rem;
            color: var(--primary-accent);
            font-weight: 500;
        }
        
        /* ===== Price Column ===== */
        .price {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1.125rem;
        }
        
        /* ===== Actions Column ===== */
        .actions {
            display: flex;
            gap: var(--spacing-xs);
            flex-wrap: wrap;
        }
        
        /* ===== Empty State ===== */
        .empty-state {
            padding: var(--spacing-xl);
            text-align: center;
            color: var(--text-gray);
        }
        
        .empty-state-icon {
            font-size: 3rem;
            color: var(--light-gray);
            margin-bottom: var(--spacing-md);
        }
        
        .empty-state h3 {
            color: var(--text-gray);
            margin-bottom: var(--spacing-xs);
        }
        
        /* ===== Responsive Design ===== */
        @media (max-width: 1024px) {
            .bookings-table {
                min-width: 700px;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                min-width: 100%;
            }
            
            .bookings-table-container {
                overflow-x: auto;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .status-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }
        }
        
        @media (max-width: 576px) {
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.75rem;
            }
            
            .container {
                padding: 0 var(--spacing-sm);
            }
            
            .bookings-table th,
            .bookings-table td {
                padding: var(--spacing-sm);
            }
        }
        
        /* ===== Modal Styles ===== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
        }
        
        .modal-header {
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-body {
            padding: var(--spacing-lg);
        }
        
        .modal-footer {
            padding: var(--spacing-lg);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-sm);
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-gray);
            padding: 0.25rem;
        }
        
        .close-modal:hover {
            color: var(--error);
        }
        
        /* ===== Booking Details ===== */
        .booking-detail-item {
            display: flex;
            margin-bottom: var(--spacing-md);
        }
        
        .booking-detail-label {
            width: 120px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .booking-detail-value {
            flex: 1;
            color: var(--text-gray);
        }
        
        /* ===== Utility Classes ===== */
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
        
        .text-center {
            text-align: center;
        }
</style>
@endsection
@section('content')
<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-title">
                <h1>Bookings Management</h1>
                <p class="text-gray">Manage all your photography bookings in one place</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-outline">
                    <i class="fas fa-download"></i> Export
                </button>
                <button class="btn btn-primary" id="refreshBookings">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filters-row">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Search by customer name...">
                </div>
                <div class="date-filter">
                    <input type="date" id="dateFrom" class="form-control">
                    <span>to</span>
                    <input type="date" id="dateTo" class="form-control">
                    <button class="btn btn-outline" id="applyDateFilter">Apply</button>
                </div>
            </div>
        </div>

        <!-- Status Tabs -->
        <div class="status-tabs">
            <a class="status-tab {{ request('status','pending')=='pending' ? 'active' : '' }}"
                href="{{ route('photographer.bookings.index', ['status'=>'pending']) }}">
                <i class="fas fa-clock"></i> Pending
                <span class="tab-count">{{ $counts['pending'] }}</span>
            </a>

            <a class="status-tab {{ request('status')=='approved' ? 'active' : '' }}"
                href="{{ route('photographer.bookings.index', ['status'=>'approved']) }}">
                <i class="fas fa-check-circle"></i> Approved (Upcoming)
                <span class="tab-count">{{ $counts['approved'] }}</span>
            </a>

            <a class="status-tab {{ request('status')=='rejected' ? 'active' : '' }}"
                href="{{ route('photographer.bookings.index', ['status'=>'rejected']) }}">
                <i class="fas fa-times-circle"></i> Rejected
                <span class="tab-count">{{ $counts['rejected'] }}</span>
            </a>

            <a class="status-tab {{ request('status')=='completed' ? 'active' : '' }}"
                href="{{ route('photographer.bookings.index', ['status'=>'completed']) }}">
                <i class="fas fa-check-double"></i> Completed
                <span class="tab-count">{{ $counts['completed'] }}</span>
            </a>
        </div>


        <!-- Bookings Table -->
        <div class="bookings-table-container">
            <div class="table-responsive">
                <table class="bookings-table" id="bookingsTable">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Session Date & Time</th>
                            <th>Session Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        <tr>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-details">
                                        <h4>{{ $b->customer->full_name ?? '-' }}</h4>
                                        <p>{{ $b->customer->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="session-details">
                                    <span class="session-date">{{ $b->booking_date?->format('D, M d, Y') }}</span>
                                    <span class="session-time">{{ $b->booking_time ?? '-' }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="session-type">Session #{{ $b->session_type_id }}</span>
                            </td>

                            <td><span class="price">${{ $b->price }}</span></td>

                            <td>
                                <span class="status-badge status-{{ $b->status }}">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="actions">
                                    @if($b->status === 'pending')
                                    <form method="POST" action="{{ route('photographer.bookings.approve', $b) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approve</button>
                                    </form>

                                    <form method="POST" action="{{ route('photographer.bookings.reject', $b) }}">
                                        @csrf
                                        <button class="btn btn-error btn-sm"><i class="fas fa-times"></i> Reject</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding:30px;">No bookings found</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div class="empty-state hidden" id="emptyState">
            <div class="empty-state-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
            <h3>No bookings found</h3>
            <p>You don't have any bookings in this category yet.</p>
        </div>
    </div>
</main>

<!-- Booking Details Modal -->
<div class="modal" id="bookingDetailsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="mb-0">Booking Details</h3>
            <button class="close-modal" id="closeModal">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Content will be populated dynamically -->
        </div>
        <div class="modal-footer" id="modalFooter">
            <!-- Buttons will be populated dynamically -->
        </div>
    </div>
</div>

<script>
    // Sample bookings data
    const bookingsData = {
        pending: [{
                id: 1001,
                customer: {
                    name: "Sarah Johnson",
                    email: "sarah.j@example.com",
                    phone: "+1 (555) 123-4567",
                    avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                },
                session: {
                    date: "2024-06-15",
                    time: "14:00-16:00",
                    type: "Family Portrait",
                    duration: "2 hours",
                    location: "Central Park, New York"
                },
                price: 350,
                status: "pending",
                notes: "Family of 4 including 2 children (ages 5 and 8). Prefer natural, candid shots.",
                createdAt: "2024-05-20"
            },
            {
                id: 1002,
                customer: {
                    name: "David Wilson",
                    email: "david.w@example.com",
                    phone: "+1 (555) 234-5678",
                    avatar: null
                },
                session: {
                    date: "2024-06-22",
                    time: "10:00-16:00",
                    type: "Wedding Coverage",
                    duration: "6 hours",
                    location: "St. Patrick's Cathedral"
                },
                price: 1200,
                status: "pending",
                notes: "Full day wedding coverage. Need both ceremony and reception photos.",
                createdAt: "2024-05-18"
            },
            {
                id: 1003,
                customer: {
                    name: "Emma Davis",
                    email: "emma.d@example.com",
                    phone: "+1 (555) 345-6789",
                    avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                },
                session: {
                    date: "2024-06-28",
                    time: "15:00-17:00",
                    type: "Maternity Session",
                    duration: "2 hours",
                    location: "Studio B, Manhattan"
                },
                price: 280,
                status: "pending",
                notes: "Indoor studio session. Client will provide her own outfits.",
                createdAt: "2024-05-15"
            },
            {
                id: 1004,
                customer: {
                    name: "Robert Chen",
                    email: "robert.c@example.com",
                    phone: "+1 (555) 456-7890",
                    avatar: null
                },
                session: {
                    date: "2024-07-05",
                    time: "11:00-14:00",
                    type: "Product Photography",
                    duration: "3 hours",
                    location: "Client's Office"
                },
                price: 450,
                status: "pending",
                notes: "Product shots for e-commerce website. Need white background.",
                createdAt: "2024-05-10"
            },
            {
                id: 1005,
                customer: {
                    name: "Lisa Thompson",
                    email: "lisa.t@example.com",
                    phone: "+1 (555) 567-8901",
                    avatar: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                },
                session: {
                    date: "2024-07-12",
                    time: "13:00-15:00",
                    type: "Headshot Session",
                    duration: "2 hours",
                    location: "Studio A, Brooklyn"
                },
                price: 320,
                status: "pending",
                notes: "Professional headshots for LinkedIn profile.",
                createdAt: "2024-05-05"
            }
        ],
        approved: [{
                id: 2001,
                customer: {
                    name: "Michael Brown",
                    email: "michael.b@example.com",
                    phone: "+1 (555) 678-9012",
                    avatar: null
                },
                session: {
                    date: "2024-06-10",
                    time: "09:00-12:00",
                    type: "Corporate Event",
                    duration: "3 hours",
                    location: "Convention Center"
                },
                price: 600,
                status: "approved",
                notes: "Annual company conference. Need candid and group shots.",
                createdAt: "2024-04-20"
            },
            {
                id: 2002,
                customer: {
                    name: "Jennifer Lee",
                    email: "jennifer.l@example.com",
                    phone: "+1 (555) 789-0123",
                    avatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                },
                session: {
                    date: "2024-06-18",
                    time: "16:00-18:00",
                    type: "Graduation Photos",
                    duration: "2 hours",
                    location: "University Campus"
                },
                price: 250,
                status: "approved",
                notes: "Graduation photos with cap and gown. Outdoor locations preferred.",
                createdAt: "2024-04-15"
            }
        ],
        rejected: [{
                id: 3001,
                customer: {
                    name: "Alex Rodriguez",
                    email: "alex.r@example.com",
                    phone: "+1 (555) 890-1234",
                    avatar: null
                },
                session: {
                    date: "2024-06-25",
                    time: "14:00-17:00",
                    type: "Real Estate",
                    duration: "3 hours",
                    location: "Multiple properties"
                },
                price: 500,
                status: "rejected",
                notes: "Property photography for real estate listing. Date conflict.",
                createdAt: "2024-04-10"
            },
            {
                id: 3002,
                customer: {
                    name: "Maria Garcia",
                    email: "maria.g@example.com",
                    phone: "+1 (555) 901-2345",
                    avatar: "https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                },
                session: {
                    date: "2024-07-01",
                    time: "10:00-13:00",
                    type: "Baby Shower",
                    duration: "3 hours",
                    location: "Client's Home"
                },
                price: 400,
                status: "rejected",
                notes: "Outside of preferred photography genres.",
                createdAt: "2024-04-05"
            }
        ],
        completed: [{
                id: 4001,
                customer: {
                    name: "James Miller",
                    email: "james.m@example.com",
                    phone: "+1 (555) 012-3456",
                    avatar: null
                },
                session: {
                    date: "2024-05-10",
                    time: "10:00-13:00",
                    type: "Corporate Headshots",
                    duration: "3 hours",
                    location: "Office Building"
                },
                price: 450,
                status: "completed",
                notes: "Team headshots for company website. Very satisfied client.",
                createdAt: "2024-03-20"
            },
            {
                id: 4002,
                customer: {
                    name: "Sophia Williams",
                    email: "sophia.w@example.com",
                    phone: "+1 (555) 123-4567",
                    avatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                },
                session: {
                    date: "2024-05-18",
                    time: "14:00-16:00",
                    type: "Engagement Photos",
                    duration: "2 hours",
                    location: "Brooklyn Bridge Park"
                },
                price: 380,
                status: "completed",
                notes: "Sunset engagement session. Beautiful golden hour light.",
                createdAt: "2024-03-15"
            }
        ]
    };

    // Current state
    let currentStatus = 'pending';
    let filteredBookings = [...bookingsData.pending];
    let searchTerm = '';
    let dateFilter = {
        from: null,
        to: null
    };

    // DOM Elements
    const statusTabs = document.querySelectorAll('.status-tab');
    const searchInput = document.getElementById('searchInput');
    const dateFromInput = document.getElementById('dateFrom');
    const dateToInput = document.getElementById('dateTo');
    const applyDateFilterBtn = document.getElementById('applyDateFilter');
    const bookingsTableBody = document.getElementById('bookingsTableBody');
    const emptyState = document.getElementById('emptyState');
    const bookingDetailsModal = document.getElementById('bookingDetailsModal');
    const closeModalBtn = document.getElementById('closeModal');
    const modalBody = document.getElementById('modalBody');
    const modalFooter = document.getElementById('modalFooter');
    const refreshBookingsBtn = document.getElementById('refreshBookings');

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        // Set default dates for date filters
        const today = new Date().toISOString().split('T')[0];
        const nextMonth = new Date();
        nextMonth.setMonth(nextMonth.getMonth() + 1);
        const nextMonthStr = nextMonth.toISOString().split('T')[0];

        dateFromInput.value = today;
        dateToInput.value = nextMonthStr;

        // Initialize with pending bookings
        renderBookingsTable();

        // Set up event listeners
        setupEventListeners();
    });

    // Set up event listeners
    function setupEventListeners() {
        // Status tabs
        statusTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                statusTabs.forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Update current status
                currentStatus = this.getAttribute('data-status');

                // Filter bookings
                filterBookings();
            });
        });

        // Search input
        searchInput.addEventListener('input', function() {
            searchTerm = this.value.toLowerCase();
            filterBookings();
        });

        // Date filter
        applyDateFilterBtn.addEventListener('click', function() {
            dateFilter.from = dateFromInput.value;
            dateFilter.to = dateToInput.value;
            filterBookings();
        });

        // Clear date filter on input change
        dateFromInput.addEventListener('change', function() {
            if (!this.value) dateFilter.from = null;
        });

        dateToInput.addEventListener('change', function() {
            if (!this.value) dateFilter.to = null;
        });

        // Modal close
        closeModalBtn.addEventListener('click', function() {
            bookingDetailsModal.classList.remove('active');
        });

        // Close modal when clicking outside
        bookingDetailsModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });

        // Refresh bookings
        refreshBookingsBtn.addEventListener('click', function() {
            // In a real app, this would fetch fresh data from the server
            filterBookings();
            showNotification('Bookings refreshed successfully!', 'success');
        });
    }

    // Filter bookings based on current filters
    function filterBookings() {
        // Get bookings for current status
        filteredBookings = [...bookingsData[currentStatus]];

        // Apply search filter
        if (searchTerm) {
            filteredBookings = filteredBookings.filter(booking =>
                booking.customer.name.toLowerCase().includes(searchTerm) ||
                booking.customer.email.toLowerCase().includes(searchTerm)
            );
        }

        // Apply date filter
        if (dateFilter.from && dateFilter.to) {
            filteredBookings = filteredBookings.filter(booking => {
                const sessionDate = booking.session.date;
                return sessionDate >= dateFilter.from && sessionDate <= dateFilter.to;
            });
        }

        // Update tab counts
        updateTabCounts();

        // Render the table
        renderBookingsTable();
    }

    // Update tab counts
    function updateTabCounts() {
        statusTabs.forEach(tab => {
            const status = tab.getAttribute('data-status');
            const count = bookingsData[status].length;
            const countElement = tab.querySelector('.tab-count');
            if (countElement) {
                countElement.textContent = count;
            }
        });
    }

    // Render bookings table
    function renderBookingsTable() {
        // Clear table body
        bookingsTableBody.innerHTML = '';

        // Show empty state if no bookings
        if (filteredBookings.length === 0) {
            bookingsTableBody.parentElement.parentElement.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        // Show table
        bookingsTableBody.parentElement.parentElement.classList.remove('hidden');
        emptyState.classList.add('hidden');

        // Render each booking
        filteredBookings.forEach(booking => {
            const row = document.createElement('tr');
            row.setAttribute('data-booking-id', booking.id);

            // Format date for display
            const sessionDate = new Date(booking.session.date);
            const formattedDate = sessionDate.toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            // Status badge
            let statusBadge = '';
            let statusClass = '';

            switch (booking.status) {
                case 'pending':
                    statusClass = 'status-pending';
                    statusBadge = 'Pending';
                    break;
                case 'approved':
                    statusClass = 'status-approved';
                    statusBadge = 'Approved';
                    break;
                case 'rejected':
                    statusClass = 'status-rejected';
                    statusBadge = 'Rejected';
                    break;
                case 'completed':
                    statusClass = 'status-completed';
                    statusBadge = 'Completed';
                    break;
            }

            // Customer avatar or placeholder
            const avatar = booking.customer.avatar ?
                `<img src="${booking.customer.avatar}" alt="${booking.customer.name}" class="customer-avatar">` :
                `<div class="customer-avatar" style="background-color: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user" style="color: #9ca3af;"></i>
                    </div>`;

            // Actions based on status
            let actions = '';
            if (booking.status === 'pending') {
                actions = `
                        <button class="btn btn-success btn-sm" onclick="approveBooking(${booking.id})">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="btn btn-error btn-sm" onclick="rejectBooking(${booking.id})">
                            <i class="fas fa-times"></i> Reject
                        </button>
                        <button class="btn btn-outline btn-sm" onclick="viewBookingDetails(${booking.id})">
                            <i class="fas fa-eye"></i> Details
                        </button>
                    `;
            } else if (booking.status === 'approved') {
                actions = `
                        <button class="btn btn-outline btn-sm" onclick="markAsCompleted(${booking.id})">
                            <i class="fas fa-check-double"></i> Complete
                        </button>
                        <button class="btn btn-outline btn-sm" onclick="viewBookingDetails(${booking.id})">
                            <i class="fas fa-eye"></i> Details
                        </button>
                    `;
            } else {
                actions = `
                        <button class="btn btn-outline btn-sm" onclick="viewBookingDetails(${booking.id})">
                            <i class="fas fa-eye"></i> Details
                        </button>
                    `;
            }

            row.innerHTML = `
                    <td>
                        <div class="customer-info">
                            ${avatar}
                            <div class="customer-details">
                                <h4>${booking.customer.name}</h4>
                                <p>${booking.customer.email}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="session-details">
                            <span class="session-date">${formattedDate}</span>
                            <span class="session-time">${booking.session.time}</span>
                        </div>
                    </td>
                    <td>
                        <span class="session-type">${booking.session.type}</span>
                    </td>
                    <td>
                        <span class="price">$${booking.price}</span>
                    </td>
                    <td>
                        <span class="status-badge ${statusClass}">${statusBadge}</span>
                    </td>
                    <td>
                        <div class="actions">
                            ${actions}
                        </div>
                    </td>
                `;

            bookingsTableBody.appendChild(row);
        });
    }

    // View booking details
    function viewBookingDetails(bookingId) {
        // Find the booking in all status arrays
        let booking = null;
        for (const status in bookingsData) {
            booking = bookingsData[status].find(b => b.id === bookingId);
            if (booking) break;
        }

        if (!booking) return;

        // Format date for display
        const sessionDate = new Date(booking.session.date);
        const formattedDate = sessionDate.toLocaleDateString('en-US', {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

        // Create modal content
        modalBody.innerHTML = `
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Customer:</div>
                    <div class="booking-detail-value">
                        <strong>${booking.customer.name}</strong><br>
                        ${booking.customer.email}<br>
                        ${booking.customer.phone}
                    </div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Session Date:</div>
                    <div class="booking-detail-value">${formattedDate}</div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Session Time:</div>
                    <div class="booking-detail-value">${booking.session.time} (${booking.session.duration})</div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Session Type:</div>
                    <div class="booking-detail-value">${booking.session.type}</div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Location:</div>
                    <div class="booking-detail-value">${booking.session.location}</div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Price:</div>
                    <div class="booking-detail-value"><strong>$${booking.price}</strong></div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Status:</div>
                    <div class="booking-detail-value">
                        <span class="status-badge ${getStatusClass(booking.status)}">${getStatusText(booking.status)}</span>
                    </div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Client Notes:</div>
                    <div class="booking-detail-value">${booking.notes}</div>
                </div>
                
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Booking Created:</div>
                    <div class="booking-detail-value">${new Date(booking.createdAt).toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    })}</div>
                </div>
            `;

        // Create modal footer buttons based on status
        let footerButtons = '';
        if (booking.status === 'pending') {
            footerButtons = `
                    <button class="btn btn-success" onclick="approveBooking(${booking.id}); bookingDetailsModal.classList.remove('active');">
                        <i class="fas fa-check"></i> Approve Booking
                    </button>
                    <button class="btn btn-error" onclick="rejectBooking(${booking.id}); bookingDetailsModal.classList.remove('active');">
                        <i class="fas fa-times"></i> Reject Booking
                    </button>
                `;
        } else if (booking.status === 'approved') {
            footerButtons = `
                    <button class="btn btn-success" onclick="markAsCompleted(${booking.id}); bookingDetailsModal.classList.remove('active');">
                        <i class="fas fa-check-double"></i> Mark as Completed
                    </button>
                `;
        }

        footerButtons += `
                <button class="btn btn-outline" onclick="bookingDetailsModal.classList.remove('active');">
                    Close
                </button>
            `;

        modalFooter.innerHTML = footerButtons;

        // Show modal
        bookingDetailsModal.classList.add('active');
    }

    // Approve booking
    function approveBooking(bookingId) {
        if (!confirm('Are you sure you want to approve this booking?')) return;

        // Find and move booking from pending to approved
        for (let i = 0; i < bookingsData.pending.length; i++) {
            if (bookingsData.pending[i].id === bookingId) {
                const booking = bookingsData.pending[i];
                booking.status = 'approved';
                bookingsData.approved.push(booking);
                bookingsData.pending.splice(i, 1);
                break;
            }
        }

        // Update UI
        filterBookings();
        showNotification('Booking approved successfully!', 'success');
    }

    // Reject booking
    function rejectBooking(bookingId) {
        const reason = prompt('Please enter reason for rejection:');
        if (reason === null) return;

        // Find and move booking from pending to rejected
        for (let i = 0; i < bookingsData.pending.length; i++) {
            if (bookingsData.pending[i].id === bookingId) {
                const booking = bookingsData.pending[i];
                booking.status = 'rejected';
                booking.rejectionReason = reason;
                bookingsData.rejected.push(booking);
                bookingsData.pending.splice(i, 1);
                break;
            }
        }

        // Update UI
        filterBookings();
        showNotification('Booking rejected successfully!', 'warning');
    }

    // Mark booking as completed
    function markAsCompleted(bookingId) {
        if (!confirm('Mark this booking as completed?')) return;

        // Find and move booking from approved to completed
        for (let i = 0; i < bookingsData.approved.length; i++) {
            if (bookingsData.approved[i].id === bookingId) {
                const booking = bookingsData.approved[i];
                booking.status = 'completed';
                bookingsData.completed.push(booking);
                bookingsData.approved.splice(i, 1);
                break;
            }
        }

        // Update UI
        filterBookings();
        showNotification('Booking marked as completed!', 'success');
    }

    // Helper functions for status
    function getStatusClass(status) {
        switch (status) {
            case 'pending':
                return 'status-pending';
            case 'approved':
                return 'status-approved';
            case 'rejected':
                return 'status-rejected';
            case 'completed':
                return 'status-completed';
            default:
                return '';
        }
    }

    function getStatusText(status) {
        switch (status) {
            case 'pending':
                return 'Pending';
            case 'approved':
                return 'Approved';
            case 'rejected':
                return 'Rejected';
            case 'completed':
                return 'Completed';
            default:
                return '';
        }
    }

    // Show notification
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="notification-close" onclick="this.parentElement.remove()">&times;</button>
            `;

        // Add styles
        notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: ${type === 'success' ? '#dcfce7' : type === 'error' ? '#fee2e2' : type === 'warning' ? '#fef3c7' : '#dbeafe'};
                color: ${type === 'success' ? '#166534' : type === 'error' ? '#991b1b' : type === 'warning' ? '#92400e' : '#1e40af'};
                padding: 1rem 1.5rem;
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                min-width: 300px;
                max-width: 400px;
                animation: slideIn 0.3s ease;
            `;

        // Add animation
        const style = document.createElement('style');
        style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
            `;
        document.head.appendChild(style);

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // Add some CSS for notifications
    const notificationStyles = document.createElement('style');
    notificationStyles.textContent = `
            .notification-close {
                background: none;
                border: none;
                font-size: 1.25rem;
                cursor: pointer;
                color: inherit;
                padding: 0;
                line-height: 1;
            }
            
            .notification-content {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            
            .notification-content i {
                font-size: 1.25rem;
            }
        `;
    document.head.appendChild(notificationStyles);
</script>
@endsection