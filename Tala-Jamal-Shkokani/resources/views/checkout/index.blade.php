@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <h4 class="mb-4">Shipping Details</h4>
                <form>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">First name</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Last name</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" placeholder="1234 Main St">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">City</label>
                            <select class="form-select">
                                <option>Amman</option>
                                <option>Zarqa</option>
                                <option>Irbid</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="+962 79 ...">
                        </div>
                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">Payment</h4>
                    <div class="my-3">
                        <div class="form-check">
                            <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked>
                            <label class="form-check-label" for="credit">Cash on Delivery (COD)</label>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button class="btn btn-primary-custom btn-lg w-100" type="submit">Place Order</button>
                </form>
            </div>

            <div class="col-lg-5">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h5 class="mb-3">Order Summary</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm px-0">
                            <div>
                                <h6 class="my-0">Rose Gold Silk Abaya</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">149 JOD</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm px-0">
                            <div>
                                <h6 class="my-0">Studded Mini Bag</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">45 JOD</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Total (JOD)</span>
                            <strong>194 JOD</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection