@extends('admin.layout.master')

@section('title', 'Add User')

@section('content')

    <div class="page-inner">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Name -->
                <div class="col-sm-12">
                    <div class="form-group form-group-default">
                        <label>Name</label>
                        <input name="name" type="text" class="form-control" placeholder="fill name" required />
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" placeholder="fill Email" required />
                    </div>
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="company_owner">Company Owner</option>
                            <option value="department_manager">Department Manager</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                </div>

                <!-- Position -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Position</label>
                        <input name="position" type="text" class="form-control" placeholder="fill Position" />
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Phone</label>
                        <input name="phone" type="text" class="form-control" placeholder="fill Phone" />
                    </div>
                </div>



                <!-- Company -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Company</label>
                        <select name="company_id" id="companySelect" class="form-control" required>
                            <option value="">Select Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->workspace_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <!-- Department -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Department</label>
                        <select name="department_id" id="departmentSelect" class="form-control">
                            <option value="">Select Department (optional)</option>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" placeholder="fill Password" required />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Confirm Password</label>
                        <input name="password_confirmation" type="password" class="form-control"
                            placeholder="fill Confirm Password" required />
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Add</button>

                <a href="{{ route('admin.users.index') }}">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                </a>
            </div>
        </form>


    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('companySelect');
            const departmentSelect = document.getElementById('departmentSelect');

            const oldDepartmentId = "{{ old('department_id') }}";

            function resetDepartments() {
                departmentSelect.innerHTML = `<option value="">Select Department (optional)</option>`;
            }

            async function loadDepartments(companyId) {
                resetDepartments();

                if (!companyId) return;

                try {
                    const url = `{{ url('admin/companies') }}/${companyId}/departments`;
                    const res = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const departments = await res.json();

                    departments.forEach(dep => {
                        const option = document.createElement('option');
                        option.value = dep.id;
                        option.textContent = dep.name;

                        // يرجّع old بعد الفشل بالـ validation
                        if (oldDepartmentId && String(dep.id) === String(oldDepartmentId)) {
                            option.selected = true;
                        }

                        departmentSelect.appendChild(option);
                    });

                } catch (e) {
                    console.error('Failed to load departments', e);
                }
            }

            // لما أغير الشركة
            companySelect.addEventListener('change', function() {
                loadDepartments(this.value);
            });

            // إذا الصفحة رجعت وفيها old(company_id) نحمّل الأقسام تلقائياً
            const oldCompanyId = "{{ old('company_id') }}";
            if (oldCompanyId) {
                loadDepartments(oldCompanyId);
            }
        });
    </script>

@endsection
