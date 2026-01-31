@extends('layouts.app')

@section('title', 'Your Bag')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4" style="font-family: 'Playfair Display', serif;">Shopping Bag</h1>

        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Cart Item -->
                <div class="card card-custom p-3 mb-3">
                    <div class="row align-items-center">
                        <div class="col-3 col-md-2">
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&w=200&q=80"
                                class="img-fluid rounded" alt="Product">
                        </div>
                        <div class="col-9 col-md-10">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="h6 mb-0">Rose Gold Silk Abaya</h5>
                                <span class="fw-bold">149 JOD</span>
                            </div>
                            <p class="small text-muted mb-2">Size: M | Color: Rose</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <button class="btn btn-outline-secondary">-</button>
                                    <input type="text" class="form-control text-center" value="1">
                                    <button class="btn btn-outline-secondary">+</button>
                                </div>
                                <button class="btn btn-link text-danger text-decoration-none small">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="card card-custom p-3 mb-3">
                    <div class="row align-items-center">
                        <div class="col-3 col-md-2">
                            <img src="https://images.unsplash.com/photo-1584917865442-de89df76afd3?ixlib=rb-4.0.3&w=200&q=80"
                                class="img-fluid rounded" alt="Product">
                        </div>
                        <div class="col-9 col-md-10">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="h6 mb-0">Studded Mini Bag</h5>
                                <span class="fw-bold">45 JOD</span>
                            </div>
                            <p class="small text-muted mb-2">Size: One Size | Color: Black</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <button class="btn btn-outline-secondary">-</button>
                                    <input type="text" class="form-control text-center" value="1">
                                    <button class="btn btn-outline-secondary">+</button>
                                </div>
                                <button class="btn btn-link text-danger text-decoration-none small">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="col-lg-4">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h5 class="mb-4">Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>194 JOD</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold h5">194 JOD</span>
                    </div>
                    <a href="{{ url('/checkout') }}" class="btn btn-primary-custom w-100">Checkout</a>
                </div>
            </div>
        </div>
    </div>
@endsection