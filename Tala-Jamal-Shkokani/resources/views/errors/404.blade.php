@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column align-items-center justify-content-center animate-fade-in"
        style="min-height: 70vh;">
        <h1
            style="font-size: 8rem; font-family: 'Playfair Display', serif; color: var(--color-primary-blush); font-style: italic; opacity: 0.5;">
            404</h1>
        <h2 class="mb-3">A Chic Mystery</h2>
        <p class="text-muted mb-5 text-center" style="max-width: 500px;">The piece you're looking for seems to have slipped
            through our collection. Let's get you back to something beautiful.</p>
        <a href="{{ url('/') }}" class="btn btn-primary-custom px-5 py-3">Return to Home</a>
    </div>
@endsection