@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Compant Management</a></li>
                <li class="breadcrumb-item active">Company Profile</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Company Overview Card -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Company Information</h4>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i> Edit Profile
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="info-label">Workspace Name</label>
                                    <div class="info-value">
                                        <i class="fas fa-building text-primary me-2"></i>
                                        <span>{{ $company->workspace_name }}</span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="info-label">Created Date</label>
                                    <div class="info-value">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <span>{{ optional($company->created_at)->format('F d, Y') }}</span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="info-label">Company Size</label>
                                    <div class="info-value">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        @php
                                            $sizeMap = [
                                                '1-10' => '1–10 employees',
                                                '11-50' => '11–50 employees',
                                                '51-200' => '51–200 employees',
                                                '200+' => '200+ employees',
                                            ];
                                        @endphp
                                        <span>{{ $sizeMap[$company->company_size] ?? '-' }}</span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="info-label">Industry</label>
                                    <div class="info-value">
                                        <i class="fas fa-briefcase text-primary me-2"></i>
                                        @php
                                            $industryMap = [
                                                'it-software' => 'IT / Software',
                                                'accounting' => 'Accounting / Finance',
                                                'marketing' => 'Marketing',
                                                'hr' => 'HR',
                                                'manufacturing' => 'Manufacturing',
                                                'other' => 'Other',
                                            ];
                                            $industryText =
                                                $company->industry === 'other'
                                                    ? $company->other_industry ?? 'Other'
                                                    : $industryMap[$company->industry] ?? '-';
                                        @endphp

                                        <span>{{ $industryText }}</span>

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <div class="info-group">
                                    <label class="info-label">Workspace URL</label>
                                    <div class="info-value">
                                        <i class="fas fa-link text-primary me-2"></i>
                                        <span>acme.knowledgehub.com</span>
                                        <button class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <div class="card-header">

                        <h4>Subscription Status</h4>
                    </div>
                    @if ($subscription)
                        <div class="card-body text-center">
                            <div class="status-badge status-active mb-3">
                                <i class="fas fa-check-circle"></i> Active
                            </div>
                            <h5 class="mb-2">{{ $subscription->plan?->name ?? 'Plan' }}</h5>
                            <p class="text-muted small mb-3">${{ number_format($subscription->plan?->price ?? 0, 2) }}/month
                            </p>

                            <div class="subscription-stats">
                                <div class="stat-item">
                                    <div class="stat-number">25</div>
                                    <div class="stat-label">of 30 Users</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">342</div>
                                    <div class="stat-label">of 500 Cards</div>
                                </div>
                            </div>

                            <a href="#" class="btn btn-outline-primary w-100 mt-3 text-center" data-bs-toggle="modal"
                                data-bs-target="#subscriptionDetailsModal">
                                View Subscription Details
                            </a>
                        </div>
                    @else
                        <h5 class="mb-2">No Subscription</h5>
                    @endif
                </div>
            </div>
        </div>

        <!-- Admin Information -->
        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="content-card">
                    <div class="card-header">
                        <h4>Company Admin</h4>
                    </div>
                    <div class="card-body">
                        <div class="admin-profile">
                            <img src="https://ui-avatars.com/api/?name=Ahmad+Khaled&size=80" alt="Admin"
                                class="admin-avatar">
                            <div class="admin-info">
                                <h5>{{ $company->owner?->name ?? auth()->user()->name }}</h5>
                                <p class="text-muted mb-2">Company Owner</p>
                                <div class="admin-contact">
                                    <div class="contact-item">
                                        <i class="fas fa-envelope text-primary"></i>
                                        <span>{{ $company->owner?->email ?? auth()->user()->email }}</span>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-phone text-primary"></i>
                                        <span>{{ $company->owner?->phone ?? auth()->user()->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-lg-4">
                <div class="content-card">
                    <div class="card-header">
                        <h4>Billing Contact</h4>
                    </div>
                    <div class="card-body">
                        <div class="billing-info">
                            <div class="info-item">
                                <i class="fas fa-envelope text-primary"></i>
                                <div>
                                    <div class="info-title">Email</div>
                                    <div class="info-text">billing@acme.com</div>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-credit-card text-primary"></i>
                                <div>
                                    <div class="info-title">Payment Method</div>
                                    <div class="info-text">•••• •••• •••• 4242</div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                                data-bs-target="#manageBillingModal">
                                <i class="fas fa-cog me-1"></i> Manage Billing
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Quick Stats -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="quick-stat-card">
                    <div class="stat-icon-sm bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-details">
                        <h4>{{ $totalEmployees }}</h4>
                        <p>Total Employees</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quick-stat-card">
                    <div class="stat-icon-sm bg-success bg-opacity-10 text-success">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stat-details">
                        <h4>{{ $departmentsCount }}</h4>
                        <p>Departments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quick-stat-card">
                    <div class="stat-icon-sm bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-details">
                        <h4>{{ $knowledgeCardsCount }}</h4>
                        <p>Knowledge Cards</p>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="fas fa-edit me-2"></i> Edit Company Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm" method="POST"
                        action="{{ route('companyOwner.companyProfile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Workspace Name</label>
                                <input type="text" class="form-control" name="workspace_name"
                                    value="{{ $company->workspace_name ?? '' }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company Size</label>
                                <select class="form-select" name="company_size">
                                    <option value="1-10" @selected(($company->company_size ?? '') == '1-10')>1-10 employees</option>
                                    <option value="11-50" @selected(($company->company_size ?? '') == '11-50')>11-50 employees</option>
                                    <option value="51-200" @selected(($company->company_size ?? '') == '51-200')>51-200 employees</option>
                                    <option value="200+" @selected(($company->company_size ?? '') == '200+')>200+ employees</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Industry</label>
                                <select class="form-select" name="industry">
                                    <option value="it-software" @selected(($company->industry ?? '') == 'it-software')>IT / Software</option>
                                    <option value="accounting" @selected(($company->industry ?? '') == 'accounting')>Accounting / Finance</option>
                                    <option value="marketing" @selected(($company->industry ?? '') == 'marketing')>Marketing</option>
                                    <option value="hr" @selected(($company->industry ?? '') == 'hr')>HR</option>
                                    <option value="manufacturing" @selected(($company->industry ?? '') == 'manufacturing')>Manufacturing</option>
                                    <option value="other" @selected(($company->industry ?? '') == 'other')>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Admin Name</label>
                                <input type="text" class="form-control" name="admin_name"
                                    value="{{ auth()->user()->name ?? '' }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Admin Email</label>
                                <input type="email" class="form-control" name="admin_email"
                                    value="{{ auth()->user()->email ?? '' }}" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Subscription Details Modal -->
    <div class="modal fade" id="subscriptionDetailsModal" tabindex="-1" aria-labelledby="subscriptionDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscriptionDetailsModalLabel">
                        <i class="fas fa-file-invoice me-2"></i> Subscription Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="subscription-details">
                        <!-- Current Plan Info -->
                        <div class="detail-section">
                            <h6 class="detail-title">Current Plan</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Plan Name</span>
                                        <span class="detail-value">Business Plan</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Billing Cycle</span>
                                        <span class="detail-value">Monthly</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Price</span>
                                        <span class="detail-value text-primary fw-bold">$29.00/month</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Status</span>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Usage Details -->
                        <div class="detail-section">
                            <h6 class="detail-title">Current Usage</h6>
                            <div class="usage-bars">
                                <div class="usage-bar-item">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Users</span>
                                        <span class="text-muted">25 / 30</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 83%"></div>
                                    </div>
                                </div>
                                <div class="usage-bar-item">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Knowledge Cards</span>
                                        <span class="text-muted">342 / 500</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 68%"></div>
                                    </div>
                                </div>
                                <div class="usage-bar-item">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>AI Requests (This Month)</span>
                                        <span class="text-muted">90 / 200</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Billing Info -->
                        <div class="detail-section">
                            <h6 class="detail-title">Billing Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Next Billing Date</span>
                                        <span class="detail-value">February 15, 2025</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Amount Due</span>
                                        <span class="detail-value text-primary fw-bold">$29.00</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Payment Method</span>
                                        <span class="detail-value">Visa •••• 4242</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Subscription Started</span>
                                        <span class="detail-value">January 15, 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features Included -->
                        <hr>
                        <div class="detail-section">
                            <h6 class="detail-title">Features Included</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="feature-badge">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Up to 30 employees
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-badge">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        500 Knowledge Cards
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-badge">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        200 AI Requests/month
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-badge">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Department Calendars
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-badge">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Company News
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-badge">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Basic Analytics
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-arrow-up me-1"></i> Upgrade Plan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Billing Modal -->
    <div class="modal fade" id="manageBillingModal" tabindex="-1" aria-labelledby="manageBillingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageBillingModalLabel">
                        <i class="fas fa-credit-card me-2"></i> Manage Billing
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="billingForm">
                        <!-- Payment Method -->
                        <div class="billing-section">
                            <h6 class="billing-section-title">Payment Method</h6>
                            <div class="current-payment-method">
                                <div class="payment-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="card-icon">
                                                <i class="fab fa-cc-visa fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="card-number">•••• •••• •••• 4242</div>
                                                <div class="card-expiry text-muted small">Expires 12/2026</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="removeCard()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-3" onclick="addNewCard()">
                                <i class="fas fa-plus me-1"></i> Add New Card
                            </button>
                        </div>

                        <hr>

                        <!-- Billing Contact -->
                        <div class="billing-section">
                            <h6 class="billing-section-title">Billing Contact</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="billingEmail" class="form-label">Billing Email</label>
                                    <input type="email" class="form-control" id="billingEmail"
                                        value="billing@acme.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="billingName" class="form-label">Billing Contact Name</label>
                                    <input type="text" class="form-control" id="billingName" value="Ahmad Khaled">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Billing Address -->
                        <div class="billing-section">
                            <h6 class="billing-section-title">Billing Address</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="addressLine1" class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" id="addressLine1"
                                        placeholder="Street address">
                                </div>
                                <div class="col-12">
                                    <label for="addressLine2" class="form-label">Address Line 2 (Optional)</label>
                                    <input type="text" class="form-control" id="addressLine2"
                                        placeholder="Apartment, suite, etc.">
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country">
                                        <option value="">Select Country</option>
                                        <option value="JO" selected>Jordan</option>
                                        <option value="US">United States</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="AE">United Arab Emirates</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="postalCode" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="postalCode"
                                        placeholder="Postal code">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Invoice Preferences -->
                        <div class="billing-section">
                            <h6 class="billing-section-title">Invoice Preferences</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="autoInvoice" checked>
                                <label class="form-check-label" for="autoInvoice">
                                    Send invoice automatically after each payment
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="monthlyReport">
                                <label class="form-check-label" for="monthlyReport">
                                    Send monthly usage report
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveBilling()">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
