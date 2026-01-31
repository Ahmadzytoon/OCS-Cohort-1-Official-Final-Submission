@extends('layouts.app')

@section('content')
    <div class="container py-5 animate-fade-up">
        <!-- Header: Boutique Curation Style -->
        <div class="text-center mb-5 pb-5 border-bottom" style="border-color: rgba(0,0,0,0.03) !important;">
            <span class="text-muted extra-small text-uppercase ls-3 fw-bold mb-2 d-block opacity-75">Curator Identity</span>
            <h1 class="display-3 font-heading fw-bold">Profile Curation</h1>
            <p class="fst-italic text-muted h5" style="font-family: 'Playfair Display', serif;">Manage your presence within
                the archive</p>
        </div>

        <div class="row g-5 justify-content-center">
            <div class="col-lg-7">
                <!-- Profile Information -->
                <div class="card card-premium shadow-sm border-0 mb-5 overflow-hidden rounded-5">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0 font-heading fw-bold text-uppercase ls-1">Personal Details</h5>
                    </div>
                    <div class="card-body p-5">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Security / Password -->
                <div class="card card-premium shadow-sm border-0 mb-5 overflow-hidden rounded-5">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0 font-heading fw-bold text-uppercase ls-1">Archival Security</h5>
                    </div>
                    <div class="card-body p-5">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Dangerous Zone -->
                <div class="card bg-white shadow-sm border-0 overflow-hidden rounded-5 border-top border-danger border-4">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0 font-heading fw-bold text-uppercase ls-1 text-danger">De-archive Account</h5>
                    </div>
                    <div class="card-body p-5">
                        <p class="text-muted small mb-4">Once your account is removed, all your curated archives and
                            wishlists will be permanently dissolved.</p>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 120px;">
                    <div class="p-5 rounded-5 shadow-sm mb-4"
                        style="background: rgba(248, 245, 242, 0.4); border: 1px solid rgba(0,0,0,0.03);">
                        <i class="fa-solid fa-shield-halved fa-2x mb-3 text-muted opacity-25"></i>
                        <h5 class="font-heading fw-bold mb-3">Identity Guard</h5>
                        <p class="text-muted small mb-0 leading-relaxed" style="line-height: 1.8;">Your presence in our
                            Archive is managed with the highest level of encryption. Ensure your credentials remain as
                            exclusive as your collection.</p>
                    </div>

                    <div class="p-5 rounded-5 border-0 shadow-none text-center" style="background: #1E1E1E;">
                        <h6 class="text-white extra-small text-uppercase ls-2 mb-3">Member Status</h6>
                        <span class="badge bg-white text-dark rounded-pill px-4 py-2 text-uppercase fw-bold ls-1">Founding
                            Curator</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ls-3 {
            letter-spacing: 3px;
        }

        .leading-relaxed {
            line-height: 1.8;
        }
    </style>
@endsection