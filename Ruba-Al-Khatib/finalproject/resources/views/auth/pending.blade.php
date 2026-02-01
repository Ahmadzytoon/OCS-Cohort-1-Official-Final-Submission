@extends('layouts.auth.master')

@section('title', 'Account Pending')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Your account is pending approval</h1>
                <p class="auth-subtitle">
                    Your account is not verified yet. Our team will review it within 1–2 business days.
                    You will receive an email once your account is approved.
                </p>
            </div>

            <div style="margin-top:20px; display:flex; gap:10px; justify-content:center;">
                <a href="{{ route('home') }}" class="submit-btn" style="text-decoration:none;">
                    Back to Home
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="submit-btn" style="opacity:.85;">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
