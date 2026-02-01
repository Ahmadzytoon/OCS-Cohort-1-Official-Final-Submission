{{-- @extends('site.layout.chooseRole.master') --}}
@extends('site.layout.mater')

@section('content')
    <div class="row h-90 align-items-center justify-content-center gap-4  m-5 p-5">
        <!-- Create Workspace Card -->
        <div class="col-lg-4 col-md-6 col-sm-10 ">
            <div class="card workspace-card">
                <div class="card-body p-4">
                    <!-- Illustration -->
                    <div class="illustration-wrapper mb-4">
                        <div class="illustration-box">
                            <svg viewBox="0 0 300 200" class="workspace-illustration">
                                <!-- Desk -->
                                <rect x="50" y="120" width="200" height="60" fill="#47b2e4" rx="5" />
                                <!-- Monitors -->
                                <rect x="80" y="80" width="50" height="40" fill="#fff" rx="2" />
                                <rect x="170" y="80" width="50" height="40" fill="#fff" rx="2" />
                                <!-- Chairs -->
                                <circle cx="90" cy="150" r="15" fill="#37517e" />
                                <circle cx="210" cy="150" r="15" fill="#37517e" />
                                <!-- Plants -->
                                <ellipse cx="40" cy="140" rx="15" ry="25" fill="#4CAF50" />
                                <ellipse cx="260" cy="140" rx="15" ry="25" fill="#4CAF50" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <h2 class="card-title mb-4">Create Your Company Workspace</h2>

                    <div class="feature-list mb-4">
                        <div class="feature-item d-flex align-items-start  mb-3">
                            <div class="feature-icon">
                                <svg width="24" height="24" fill="#47b2e4" viewBox="0 0 24 24">
                                    <path
                                        d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg>
                            </div>
                            <div class="feature-text ms-3">
                                <h6 class="mb-1">Manage Your Team</h6>
                                <p class="text-muted mb-0">Invite members, assign roles, and collaborate seamlessly</p>
                            </div>
                        </div>

                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon">
                                <svg width="24" height="24" fill="#47b2e4" viewBox="0 0 24 24">
                                    <path
                                        d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
                                </svg>
                            </div>
                            <div class="feature-text ms-3">
                                <h6 class="mb-1">Secure & Private</h6>
                                <p class="text-muted mb-0">Your workspace is completely isolated and protected</p>
                            </div>
                        </div>

                        <div class="feature-item d-flex align-items-start">
                            <div class="feature-icon">
                                <svg width="24" height="24" fill="#47b2e4" viewBox="0 0 24 24">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                            </div>
                            <div class="feature-text ms-3">
                                <h6 class="mb-1">Scale with Confidence</h6>
                                <p class="text-muted mb-0">Grow your team and projects without limitations</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('site.loging.plans.plans') }}"><button class="btn btn-primary w-100 btn-md">Create
                            Your
                            Workspace</button></a>
                </div>
            </div>
        </div>

        <!-- Join Workspace Card -->
        <div class="col-lg-4 col-md-6 col-sm-10">
            <div class="card workspace-card">
                <div class="card-body p-4">
                    <!-- Illustration -->
                    <div class="illustration-wrapper mb-4">
                        <div class="illustration-box join-box">
                            <svg viewBox="0 0 300 200" class="join-illustration">
                                <!-- Screen -->
                                <rect x="75" y="60" width="150" height="100" fill="#47b2e4" rx="5" />
                                <!-- Login form -->
                                <rect x="100" y="85" width="100" height="15" fill="#fff" rx="3" />
                                <rect x="100" y="110" width="100" height="15" fill="#fff" rx="3" />
                                <!-- Person icon -->
                                <circle cx="150" cy="140" r="10" fill="#fff" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <h2 class="card-title mb-4">Join Your Company</h2>

                    <p class="text-muted mb-4">
                        Already have an account? Sign in to access your company workspace and start collaborating with your
                        team.
                    </p>

                    <a href="{{ route('login.create') }}"><button class="btn btn-dark w-100 btn-md mb-4">Login to Your
                            Account</button></a>

                    <div class="text-center">
                        <p class="text-muted mb-1">Need to join a company?</p>
                        <a href="{{ route('accessRequest.create') }}" class="text-primary text-decoration-none">Send
                            Access Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
