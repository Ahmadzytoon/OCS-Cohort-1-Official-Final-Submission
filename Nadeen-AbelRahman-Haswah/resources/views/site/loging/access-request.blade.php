{{-- @extends('site.loging.layout.mater') --}}
@extends('site.layout.mater')
@section('content_forms')
    <!-- Access Request Form -->
    <div id="access-request-form" class="form-container mt-5">
        <h2 class="form-title">Request Access</h2>

        <form action="{{ route('accessRequest.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                    placeholder="Your full name" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                    placeholder="name@example.com" required>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="0799...">
                @error('phone')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Company</label>
                <select class="form-select" name="company_id" id="companySelect" required>
                    <option value="" selected disabled>Select company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                            {{ $company->workspace_name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select class="form-select" name="department_id" id="departmentSelect">
                    <option value="" selected>Select department</option>
                    {{-- رح يتعبّى بالـ JS حسب الشركة --}}
                </select>
                @error('department_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Requested Role</label>
                <select class="form-select" name="requested_role" required>
                    <option value="employee" @selected(old('requested_role', 'employee') == 'employee')>Employee</option>
                    <option value="department_manager" @selected(old('requested_role') == 'department_manager')>
                        Department Manager
                    </option>
                </select>
                @error('requested_role')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="message" rows="4" placeholder="Briefly explain why you need access..."
                    required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Submit Request</button>
        </form>

        <div class="form-switch">
            <p>Already have an account? <a href="{{ route('login.create') }}" class="fw-bold">Sign in here</a></p>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const departmentsByCompany = @json($departmentsByCompany);
        const companySelect = document.getElementById('companySelect');
        const departmentSelect = document.getElementById('departmentSelect');

        function fillDepartments(companyId, selectedDepartmentId = null) {
            departmentSelect.innerHTML = '<option value="" selected>Select department</option>';

            const deps = departmentsByCompany[companyId] || [];
            deps.forEach(dep => {
                const opt = document.createElement('option');
                opt.value = dep.id;
                opt.textContent = dep.name;

                if (selectedDepartmentId && String(selectedDepartmentId) === String(dep.id)) {
                    opt.selected = true;
                }

                departmentSelect.appendChild(opt);
            });
        }

        companySelect.addEventListener('change', function() {
            fillDepartments(this.value);
        });

        // لو رجعنا للفورم مع old values (validation error)
        const oldCompany = @json(old('company_id'));
        const oldDepartment = @json(old('department_id'));
        if (oldCompany) {
            fillDepartments(oldCompany, oldDepartment);
        }
    </script>
@endsection
