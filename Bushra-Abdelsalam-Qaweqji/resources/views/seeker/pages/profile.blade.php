@extends('seeker.layouts.app')
@section('title', 'Cleanova | My Profile')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                <div>
                    <h2 class="fw-bold mb-1">My Profile</h2>
                    <p class="text-muted mb-0">Update your details to make booking faster.</p>
                </div>
                <a href="{{ route('seeker.dashboard') }}" class="btn btn-outline-primary cc-btn-outline">
                    Back to Dashboard
                </a>
            </div>

            <div class="row g-4">
                @if (session('success'))
                    <div class="col-12">
                        <div class="alert alert-success mb-0">{{ session('success') }}</div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-danger mb-0">Please fix the highlighted fields.</div>
                    </div>
                @endif
                {{-- Left card (avatar + quick actions) --}}
                <div class="col-12 col-lg-4">
                    <div class="card cc-shell-card">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <div class="text-muted small mb-3">Customer Account</div>

                            <hr class="cc-hr my-4">

                            <div class="d-grid gap-2">
                                <a href="{{ route('seeker.bookings.index') }}" class="btn btn-primary cc-book-btn">My
                                    Bookings</a>
                                <a href="{{ route('seeker.providers-list') }}"
                                    class="btn btn-outline-primary cc-btn-outline">Find
                                    Cleaners</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right cards (forms) --}}
                <div class="col-12 col-lg-8">
                    <form method="POST" action="{{ route('seeker.profile.update') }}">
                        @csrf

                        {{-- Personal info --}}
                        <div class="card cc-shell-card mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">Personal Information</h5>
                                    <button type="submit" class="btn btn-primary cc-book-btn px-4">Save</button>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">First Name</label>
                                        <input
                                            name="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', $firstName) }}">
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">Last Name</label>
                                        <input
                                            name="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', $lastName) }}">
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">Email</label>
                                        <input
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            type="email"
                                            value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">Phone</label>
                                        <input
                                            name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Default address --}}
                        <div class="card cc-shell-card mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Default Address</h5>
                                <p class="text-muted small mb-3">This helps you book faster (you can still change it during
                                    checkout).</p>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-semibold">Street Address</label>
                                        <input
                                            name="address_line"
                                            class="form-control @error('address_line') is-invalid @enderror"
                                            value="{{ old('address_line', $profile->address_line ?? '') }}"
                                            placeholder="e.g., 12 King Abdullah St.">
                                        @error('address_line')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">City</label>
                                        <input
                                            name="city"
                                            class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city', $profile->city ?? '') }}"
                                            placeholder="Amman">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label class="form-label small fw-semibold">Zip</label>
                                        <input
                                            name="zip_code"
                                            class="form-control @error('zip_code') is-invalid @enderror"
                                            value="{{ old('zip_code', $profile->zip_code ?? '') }}"
                                            placeholder="11181">
                                        @error('zip_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label class="form-label small fw-semibold">Unit</label>
                                        <input
                                            name="unit"
                                            class="form-control @error('unit') is-invalid @enderror"
                                            value="{{ old('unit', $profile->unit ?? '') }}"
                                            placeholder="Apt 3B">
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Preferences --}}
                        <div class="card cc-shell-card">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Preferences</h5>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">Preferred Language</label>
                                        <select name="preferred_language" class="form-select @error('preferred_language') is-invalid @enderror">
                                            <option value="">Select</option>
                                            <option value="en" @selected(old('preferred_language', $profile->preferred_language ?? '') === 'en')>English</option>
                                            <option value="ar" @selected(old('preferred_language', $profile->preferred_language ?? '') === 'ar')>Arabic</option>
                                        </select>
                                        @error('preferred_language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">Notifications</label>
                                        <select name="notifications" class="form-select @error('notifications') is-invalid @enderror">
                                            <option value="">Select</option>
                                            <option value="email_sms" @selected(old('notifications', $profile->notifications ?? '') === 'email_sms')>Email + SMS</option>
                                            <option value="email" @selected(old('notifications', $profile->notifications ?? '') === 'email')>Email only</option>
                                            <option value="sms" @selected(old('notifications', $profile->notifications ?? '') === 'sms')>SMS only</option>
                                        </select>
                                        @error('notifications')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label small fw-semibold">Default Notes for Cleaners</label>
                                        <textarea
                                            name="default_notes"
                                            class="form-control @error('default_notes') is-invalid @enderror"
                                            rows="4"
                                            placeholder="e.g., Please focus on kitchen and bathrooms. We have a cat.">{{ old('default_notes', $profile->default_notes ?? '') }}</textarea>
                                        @error('default_notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="text-muted small mt-2">
                                            These notes will be pre-filled during checkout (you can edit them per booking).
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary cc-book-btn px-4">Save Changes</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection
