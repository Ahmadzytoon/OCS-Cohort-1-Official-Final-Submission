@extends('admin.layout.master')

@section('title', 'Add Department')
@section('css')

@endsection

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

        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Company (Required) -->
                <div class="col-sm-6">
                    <div class="form-group form-group-default">
                        <label>Company <span class="text-danger">*</span></label>
                        <select id="companySelect" name="company_id" class="form-control" required>
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

                <!-- Department Name (Required) -->
                <div class="col-sm-6">
                    <div class="form-group form-group-default">
                        <label>Department Name <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="e.g., IT Department"
                            required />
                    </div>
                </div>

                <!-- Description (Optional) -->
                <div class="col-sm-12">
                    <div class="form-group form-group-default">
                        <label>Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the department"></textarea>
                    </div>
                </div>

                <!-- Manager (Optional) -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Department Manager (Optional)</label>
                        <select id="managerSelect" name="manager_id" class="form-control">
                            <option value="">Select Manager</option>
                        </select>
                        <small class="text-muted">Select a company first</small>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Add</button>

                <a href="{{ route('admin.departments.index') }}">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                </a>
            </div>
        </form>

    </div>
@endsection

@section('js')

    <script>
        const users = @json($users);

        const companySelect = document.getElementById('companySelect');
        const managerSelect = document.getElementById('managerSelect');

        function fillManagers(companyId) {
            managerSelect.innerHTML = '<option value="">Select Manager</option>';

            if (!companyId) return;

            const filtered = users.filter(u =>
                String(u.company_id) === String(companyId) &&
                (u.role === 'department_manager' || u.role === 'employee')
            );

            filtered.forEach(u => {
                const opt = document.createElement('option');
                opt.value = u.id;
                opt.textContent = u.name + ' (' + u.role + ')';
                managerSelect.appendChild(opt);
            });
        }

        companySelect.addEventListener('change', function() {
            fillManagers(this.value);
        });

        // لو في old company_id بعد validation
        document.addEventListener('DOMContentLoaded', function() {
            const oldCompany = "{{ old('company_id') }}";
            const oldManager = "{{ old('manager_id') }}";

            if (oldCompany) {
                fillManagers(oldCompany);
                if (oldManager) managerSelect.value = oldManager;
            }
        });
    </script>

@endsection
