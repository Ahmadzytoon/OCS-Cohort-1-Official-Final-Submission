@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                {{-- <li class="breadcrumb-item active"> Roles & Permissions</li> --}}
            </ol>
        </nav>
    </div>


    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">
                    <i class="fas fa-cog text-primary me-2"></i> Settings
                </h4>
                <p class="text-muted">Manage your workspace settings and preferences</p>
            </div>
        </div>

        <!-- Settings Navigation Tabs -->
        <ul class="nav nav-tabs settings-tabs mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#generalSettings" type="button"
                    role="tab">
                    <i class="fas fa-sliders-h me-2"></i> General Settings
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">
                    <i class="fas fa-bell me-2"></i> Notifications
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- General Settings Tab -->
            <div class="tab-pane fade show active" id="generalSettings" role="tabpanel">
                <!-- Company Information -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4>Company Information</h4>
                    </div>
                    <div class="card-body">
                        <form id="companyInfoForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" value="Acme Corporation" required>
                                    <small class="text-muted">This will appear across the platform</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Workspace URL</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="acme" required>
                                        <span class="input-group-text">.knowledgehub.com</span>
                                    </div>
                                    <small class="text-muted">Your unique workspace identifier</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Company Logo</label>
                                    <div class="logo-upload-section">
                                        <div class="current-logo">
                                            <img src="https://ui-avatars.com/api/?name=Acme+Corporation&size=100&background=47b2e4&color=fff"
                                                alt="Logo" class="company-logo-preview">
                                        </div>
                                        <div class="logo-upload-controls">
                                            <input type="file" class="form-control" id="logoUpload" accept="image/*">
                                            <small class="text-muted d-block mt-2">Recommended size: 200x200px, Max size:
                                                2MB</small>
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                                onclick="removeLogo()">
                                                <i class="fas fa-trash me-1"></i> Remove Logo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-actions mt-4">
                                <button type="button" class="btn btn-primary" onclick="saveCompanyInfo()">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-2"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Regional Settings -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4>Regional Settings</h4>
                    </div>
                    <div class="card-body">
                        <form id="regionalSettingsForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select">
                                        <option value="">Select Timezone</option>
                                        <option value="UTC+3" selected>(GMT+3:00) Jordan - Amman</option>
                                        <option value="UTC+2">(GMT+2:00) Cairo</option>
                                        <option value="UTC+3-riyadh">(GMT+3:00) Riyadh</option>
                                        <option value="UTC+4">(GMT+4:00) Dubai</option>
                                        <option value="UTC+0">(GMT+0:00) London</option>
                                        <option value="UTC-5">(GMT-5:00) New York</option>
                                    </select>
                                    <small class="text-muted">Used for scheduling and timestamps</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Language</label>
                                    <select class="form-select">
                                        <option value="en" selected>English</option>
                                        <option value="ar">العربية (Arabic)</option>
                                        <option value="fr">Français (French)</option>
                                        <option value="es">Español (Spanish)</option>
                                    </select>
                                    <small class="text-muted">Interface language</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date Format</label>
                                    <select class="form-select">
                                        <option value="mdy" selected>MM/DD/YYYY (01/22/2025)</option>
                                        <option value="dmy">DD/MM/YYYY (22/01/2025)</option>
                                        <option value="ymd">YYYY-MM-DD (2025-01-22)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Time Format</label>
                                    <select class="form-select">
                                        <option value="12" selected>12-hour (3:30 PM)</option>
                                        <option value="24">24-hour (15:30)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="settings-actions mt-4">
                                <button type="button" class="btn btn-primary" onclick="saveRegionalSettings()">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-2"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- System Preferences -->
                <div class="content-card">
                    <div class="card-header">
                        <h4>System Preferences</h4>
                    </div>
                    <div class="card-body">
                        <form id="systemPreferencesForm">
                            <div class="settings-group">
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>Email Notifications</h6>
                                        <p>Enable email notifications for important updates</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications"
                                                checked>
                                            <label class="form-check-label" for="emailNotifications"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>Two-Factor Authentication</h6>
                                        <p>Add an extra layer of security to your account</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="twoFactor">
                                            <label class="form-check-label" for="twoFactor"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>Auto-save Drafts</h6>
                                        <p>Automatically save your work as drafts</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="autoSave" checked>
                                            <label class="form-check-label" for="autoSave"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-actions mt-4">
                                <button type="button" class="btn btn-primary" onclick="saveSystemPreferences()">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Notifications Tab -->
            <div class="tab-pane fade" id="notifications" role="tabpanel">
                <!-- Notification Preferences -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4>Notification Preferences</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Choose which notifications you want to receive via email and in-app
                            alerts</p>

                        <!-- Approval Notifications -->
                        <div class="notification-section">
                            <h6 class="notification-section-title">
                                <i class="fas fa-check-circle text-success me-2"></i> Approval Notifications
                            </h6>
                            <div class="settings-group">
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>New Pending Approvals</h6>
                                        <p>Get notified when new knowledge cards need approval</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="approvalEmail"
                                                    checked>
                                                <label class="form-check-label" for="approvalEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="approvalInApp"
                                                    checked>
                                                <label class="form-check-label" for="approvalInApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>Approval Decisions</h6>
                                        <p>Notify me when my submitted cards are approved or rejected</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="decisionEmail"
                                                    checked>
                                                <label class="form-check-label" for="decisionEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="decisionInApp"
                                                    checked>
                                                <label class="form-check-label" for="decisionInApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Access Request Notifications -->
                        <div class="notification-section">
                            <h6 class="notification-section-title">
                                <i class="fas fa-user-plus text-primary me-2"></i> New Join Requests
                            </h6>
                            <div class="settings-group">
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>New Access Requests</h6>
                                        <p>Get notified when someone requests to join the company</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="joinEmail" checked>
                                                <label class="form-check-label" for="joinEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="joinInApp" checked>
                                                <label class="form-check-label" for="joinInApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>Daily Summary</h6>
                                        <p>Receive daily summary of pending access requests</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="summarEmail" checked>
                                                <label class="form-check-label" for="summarEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- AI Usage Alerts -->
                        <div class="notification-section">
                            <h6 class="notification-section-title">
                                <i class="fas fa-robot text-warning me-2"></i> AI Usage Alerts
                            </h6>
                            <div class="settings-group">
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>AI Usage Threshold</h6>
                                        <p>Alert when AI usage reaches 80% of monthly limit</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aiThresholdEmail"
                                                    checked>
                                                <label class="form-check-label" for="aiThresholdEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aiThresholdInApp"
                                                    checked>
                                                <label class="form-check-label" for="aiThresholdInApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>AI Limit Exceeded</h6>
                                        <p>Alert when monthly AI usage limit is exceeded</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aiLimitEmail"
                                                    checked>
                                                <label class="form-check-label" for="aiLimitEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aiLimitInApp"
                                                    checked>
                                                <label class="form-check-label" for="aiLimitInApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <h6>Monthly AI Usage Report</h6>
                                        <p>Receive monthly report on AI feature usage</p>
                                    </div>
                                    <div class="setting-control">
                                        <div class="notification-toggles">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="aiReportEmail"
                                                    checked>
                                                <label class="form-check-label" for="aiReportEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="settings-actions mt-4">
                            <button type="button" class="btn btn-primary" onclick="saveNotificationSettings()">
                                <i class="fas fa-save me-2"></i> Save Notification Settings
                            </button>
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-2"></i> Reset to Default
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Notification Schedule -->
                <div class="content-card">
                    <div class="card-header">
                        <h4>Notification Schedule</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Set quiet hours when you don't want to receive notifications</p>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="enableQuietHours">
                                    <label class="form-check-label" for="enableQuietHours">
                                        <strong>Enable Quiet Hours</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">From</label>
                                <input type="time" class="form-control" value="22:00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">To</label>
                                <input type="time" class="form-control" value="08:00">
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            During quiet hours, you'll only receive critical notifications
                        </div>
                        <div class="settings-actions mt-3">
                            <button type="button" class="btn btn-primary" onclick="saveQuietHours()">
                                <i class="fas fa-save me-2"></i> Save Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
