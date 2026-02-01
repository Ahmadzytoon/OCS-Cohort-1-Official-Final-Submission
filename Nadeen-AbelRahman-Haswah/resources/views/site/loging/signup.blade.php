{{-- @extends('site.loging.layout.mater') --}}
@extends('site.layout.mater')

@section('css')
    <style>
        #other-industry-container {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        #other-industry-container.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* تنسيق إضافي للـ input */
        #other-industry {
            border-left: 3px solid #47b2e4;
        }

        #other-industry:focus {
            border-left-color: #5bc0de;
            box-shadow: 0 0 0 0.2rem rgba(71, 178, 228, 0.25);
        }
    </style>
@endsection
@section('content_forms')
    <div class="signup-wrapper mt-5">
        <div class="container">
            <div id="signup-form" class="form-container signup-form">
                <h2 class="form-title">Create Your Workspace</h2>

                <form action="{{ route('signup.store') }}" method="POST">

                    @csrf

                    <!-- Section 1: Workspace Info -->
                    <div class="form-section">
                        <h3 class="section-title">Workspace Information</h3>

                        <div class="mb-3">
                            <label for="workspace-name" class="form-label">Workspace Name</label>
                            <input type="text" class="form-control" name="workspace_name" id="workspace-name"
                                placeholder="e.g. Acme Corporation" required>
                        </div>
                    </div>

                    <!-- Section 2: Company Admin -->
                    <div class="form-section">
                        <h3 class="section-title">Company Admin</h3>

                        <div class="mb-3">
                            <label for="admin-name" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" name="owner_name" id="admin-name"
                                placeholder="e.g. Ahmad Khaled" required>
                        </div>

                        <div class="mb-3">
                            <label for="admin-email" class="form-label">Work Email</label>
                            <input type="email" class="form-control" name="owner_email" id="admin-email"
                                placeholder="admin@company.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="admin-password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="admin-password"
                                placeholder="••••••••" required>
                            <div class="password-rules">
                                <ul>
                                    <li>At least 8 characters</li>
                                    <li>One number</li>
                                    <li>One special character</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="confirm-password"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Section 3: Optional Information -->
                    <div class="form-section">
                        <h3 class="section-title">Additional Information <span class="optional-badge">Optional</span></h3>

                        <div class="mb-3">
                            <label for="company-size" class="form-label">Company Size</label>
                            <select class="form-select" id="company-size" name="company_size">
                                <option value="" selected>Select company size</option>
                                <option value="1-10">1–10 employees</option>
                                <option value="11-50">11–50 employees</option>
                                <option value="51-200">51–200 employees</option>
                                <option value="200+">200+ employees</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <select class="form-select" id="industry" name="industry" onchange="toggleOtherIndustry(this)">
                                <option value="" selected>Select industry</option>
                                <option value="it-software">IT / Software</option>
                                <option value="accounting">Accounting / Finance</option>
                                <option value="marketing">Marketing</option>
                                <option value="hr">HR</option>
                                <option value="manufacturing">Manufacturing</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Other Industry Input (Hidden by default) -->
                        <div class="mb-3" id="other-industry-container" style="display: none;">
                            <label for="other-industry" class="form-label">Specify Industry</label>
                            <input type="text" class="form-control" id="other-industry" name="other_industry"
                                placeholder="e.g. Healthcare, Education, Real Estate">
                            <div class="form-text">Please specify your industry</div>
                        </div>
                    </div>

                    <!-- Section 4: Legal & Confirmation -->
                    <div class="form-section">
                        <div class="terms-box">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" target="_blank">Terms of Service</a> and
                                    <a href="#" target="_blank">Privacy Policy</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Create Workspace</button>
                </form>

                <div class="form-footer">
                    <p>Already have an account? <a href="{{ route('login.create') }}" class="fw-bold">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
