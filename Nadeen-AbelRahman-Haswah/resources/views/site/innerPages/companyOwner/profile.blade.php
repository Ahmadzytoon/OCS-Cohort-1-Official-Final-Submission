@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">
                    <i class="fas fa-user text-primary me-2"></i> My Profile
                </h4>
                <p class="text-muted">Manage your personal information and account settings</p>
            </div>
        </div>

        <!-- Profile Overview -->
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="content-card">
                    <div class="card-body text-center">
                        <div class="profile-avatar-section">
                            <div class="profile-avatar-wrapper">
                                <img src="https://ui-avatars.com/api/?name=Ahmad+Khaled&size=150&background=47b2e4&color=fff"
                                    alt="Profile" class="profile-avatar">
                                <button class="avatar-edit-btn" data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        </div>
                        <h4 class="profile-name mt-3">Ahmad Khaled</h4>
                        <p class="profile-role">Company Admin</p>
                        <div class="profile-badges">
                            <span class="badge bg-primary">Owner</span>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <hr>
                        <div class="profile-stats">
                            <div class="stat-item-profile">
                                <h5>42</h5>
                                <small>Knowledge Cards</small>
                            </div>
                            <div class="stat-item-profile">
                                <h5>IT Dept.</h5>
                                <small>Department</small>
                            </div>
                            <div class="stat-item-profile">
                                <h5>2 Years</h5>
                                <small>Member Since</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card mt-4">
                    <div class="card-header">
                        <h5>Quick Actions</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="quick-actions-list">
                            <button class="quick-action-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-key text-warning"></i>
                                <span>Change Password</span>
                                <i class="fas fa-chevron-right ms-auto"></i>
                            </button>
                            <button class="quick-action-item" onclick="downloadData()">
                                <i class="fas fa-download text-primary"></i>
                                <span>Download My Data</span>
                                <i class="fas fa-chevron-right ms-auto"></i>
                            </button>
                            <button class="quick-action-item text-danger" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt text-danger"></i>
                                <span>Logout</span>
                                <i class="fas fa-chevron-right ms-auto"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h5>Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <form id="personalInfoForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" value="Ahmad" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" value="Khaled" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" value="ahmad.khaled@acme.com" required>
                                    <small class="text-muted">Your work email address</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" value="+962 79 123 4567">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" class="form-control" value="IT Manager">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Department</label>
                                    <select class="form-select" disabled>
                                        <option value="it" selected>IT Department</option>
                                    </select>
                                    <small class="text-muted">Contact admin to change department</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Bio (Optional)</label>
                                    <textarea class="form-control" rows="3" placeholder="Tell us about yourself...">Experienced IT professional with over 10 years in software development and team management.</textarea>
                                </div>
                            </div>
                            <div class="settings-actions mt-4">
                                <button type="button" class="btn btn-primary" onclick="savePersonalInfo()">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-2"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h5>Account Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="settings-group">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h6>Email Notifications</h6>
                                    <p>Receive email notifications for updates and activities</p>
                                </div>
                                <div class="setting-control">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="profileEmailNotif" checked>
                                        <label class="form-check-label" for="profileEmailNotif"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h6>Show Profile to Others</h6>
                                    <p>Allow other employees to view your profile</p>
                                </div>
                                <div class="setting-control">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showProfile" checked>
                                        <label class="form-check-label" for="showProfile"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h6>Activity Status</h6>
                                    <p>Show when you're online and active</p>
                                </div>
                                <div class="setting-control">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activityStatus" checked>
                                        <label class="form-check-label" for="activityStatus"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="content-card">
                    <div class="card-header">
                        <h5>Security & Privacy</h5>
                    </div>
                    <div class="card-body">
                        <div class="security-section">
                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-key text-primary"></i>
                                </div>
                                <div class="security-info">
                                    <h6>Password</h6>
                                    <p class="text-muted">Last changed 3 months ago</p>
                                </div>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">
                                    Change Password
                                </button>
                            </div>
                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-shield-alt text-success"></i>
                                </div>
                                <div class="security-info">
                                    <h6>Two-Factor Authentication</h6>
                                    <p class="text-muted">Add extra security to your account</p>
                                </div>
                                <button class="btn btn-sm btn-outline-success" onclick="enable2FA()">
                                    Enable 2FA
                                </button>
                            </div>
                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-laptop text-info"></i>
                                </div>
                                <div class="security-info">
                                    <h6>Active Sessions</h6>
                                    <p class="text-muted">3 devices currently logged in</p>
                                </div>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#sessionsModal">
                                    Manage Sessions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Avatar Modal -->
    <div class="modal fade" id="changeAvatarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-camera me-2"></i> Change Profile Picture
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="avatar-preview mb-3">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Khaled&size=150&background=47b2e4&color=fff"
                            alt="Preview" class="profile-avatar" id="avatarPreview">
                    </div>
                    <input type="file" class="form-control" accept="image/*" onchange="previewAvatar(event)">
                    <small class="text-muted d-block mt-2">Recommended size: 400x400px, Max size: 5MB</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveAvatar()">
                        <i class="fas fa-save me-1"></i> Save Picture
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i> Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" placeholder="Enter current password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" placeholder="Enter new password" required>
                            <div class="password-strength mt-2">
                                <small class="text-muted">Password strength: </small>
                                <span class="badge bg-danger">Weak</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" placeholder="Confirm new password" required>
                        </div>
                        <div class="alert alert-info">
                            <strong>Password Requirements:</strong>
                            <ul class="mb-0 mt-2">
                                <li>At least 8 characters</li>
                                <li>One uppercase letter</li>
                                <li>One number</li>
                                <li>One special character</li>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="changePassword()">
                        <i class="fas fa-check me-1"></i> Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Sessions Modal -->
    <div class="modal fade" id="sessionsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-laptop me-2"></i> Active Sessions
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">These devices are currently logged into your account. Remove any sessions
                        you don't recognize.</p>
                    <div class="sessions-list">
                        <div class="session-item">
                            <div class="session-icon">
                                <i class="fas fa-desktop text-primary"></i>
                            </div>
                            <div class="session-details">
                                <h6>Windows Desktop - Chrome</h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt text-danger"></i> Amman, Jordan</p>
                                <p class="mb-0"><i class="fas fa-clock text-muted"></i> Active now</p>
                            </div>
                            <span class="badge bg-success">Current Session</span>
                        </div>
                        <div class="session-item">
                            <div class="session-icon">
                                <i class="fas fa-mobile-alt text-info"></i>
                            </div>
                            <div class="session-details">
                                <h6>iPhone - Safari</h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt text-danger"></i> Amman, Jordan</p>
                                <p class="mb-0"><i class="fas fa-clock text-muted"></i> 2 hours ago</p>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" onclick="removeSession(2)">
                                Remove
                            </button>
                        </div>
                        <div class="session-item">
                            <div class="session-icon">
                                <i class="fas fa-tablet-alt text-success"></i>
                            </div>
                            <div class="session-details">
                                <h6>iPad - Safari</h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt text-danger"></i> Amman, Jordan</p>
                                <p class="mb-0"><i class="fas fa-clock text-muted"></i> 1 day ago</p>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" onclick="removeSession(3)">
                                Remove
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-danger w-100 mt-3" onclick="removeAllSessions()">
                        <i class="fas fa-sign-out-alt me-2"></i> Remove All Other Sessions
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-sign-out-alt me-2"></i> Confirm Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to logout from your account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="logout()">
                        <i class="fas fa-sign-out-alt me-1"></i> Yes, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
