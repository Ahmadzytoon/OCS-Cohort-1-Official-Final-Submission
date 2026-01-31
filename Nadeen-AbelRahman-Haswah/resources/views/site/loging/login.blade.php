{{-- @extends('site.loging.layout.mater') --}}
@extends('site.layout.mater')

@section('content_forms')
    <!-- Login Form -->
    <div id="login-form" class="form-container mt-5">
        <h2 class="form-title">Sign In</h2>
        <form action=" {{ route('login.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@company.com"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password"
                    required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>

        <div class="form-footer">
            <p>Do you need to join company? <a href="{{ route('accessRequest.create') }}" class="fw-bold">Send access
                    request</a></p>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
@endsection
