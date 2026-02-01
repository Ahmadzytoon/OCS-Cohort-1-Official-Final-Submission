@extends('layouts.admin')
@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
<div class="row g-3">
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="mb-3"><i class="fas fa-cog me-2"></i> System Settings</h5>
            <form>
                <div class="mb-3">
                    <label class="form-label">Low Stock Threshold</label>
                    <input type="number" class="form-control" value="50" placeholder="Enter threshold">
                </div>
                <div class="mb-3">
                    <label class="form-label">OTP Expiry Time (minutes)</label>
                    <input type="number" class="form-control" value="10" placeholder="Enter minutes">
                </div>
                <div class="mb-3">
                    <label class="form-label">Items Per Page</label>
                    <input type="number" class="form-control" value="20" placeholder="Enter number">
                </div>
                <div class="mb-3">
                    <label class="form-label">Currency</label>
                    <select class="form-select">
                        <option>USD ($)</option>
                        <option>EUR (€)</option>
                        <option>GBP (£)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="mb-3"><i class="fas fa-envelope me-2"></i> Email Settings</h5>
            <form>
                <div class="mb-3">
                    <label class="form-label">SMTP Host</label>
                    <input type="text" class="form-control" placeholder="smtp.example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">SMTP Port</label>
                    <input type="text" class="form-control" placeholder="587">
                </div>
                <div class="mb-3">
                    <label class="form-label">SMTP Username</label>
                    <input type="email" class="form-control" placeholder="email@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">SMTP Password</label>
                    <input type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save Email Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection