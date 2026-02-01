@extends('admin.layout.master')

@section('title', 'Edit Department')

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

        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Company (Required) -->
                <div class="col-sm-6">
                    <div class="form-group form-group-default">
                        <label>Company <span class="text-danger">*</span></label>
                        <select id="companySelect" name="company_id" class="form-control" required>
                            <option value="">Select Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id', $department->company_id) == $company->id ? 'selected' : '' }}>
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
                        <input name="name" type="text" class="form-control" placeholder="e.g., IT Department" required
                            value="{{ old('name', $department->name) }}" />
                    </div>
                </div>

                <!-- Description (Optional) -->
                <div class="col-sm-12">
                    <div class="form-group form-group-default">
                        <label>Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the department">{{ old('description', $department->description) }}</textarea>
                    </div>
                </div>

                <!-- Manager (Optional) -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Department Manager (Optional)</label>

                        <select id="managerSelect" name="manager_id" class="form-control">
                            <option value="">No Manager</option>

                            @foreach ($companyUsers as $u)
                                <option value="{{ $u->id }}"
                                    {{ old('manager_id', $department->manager_id) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">Managers must belong to the same company.</small>
                    </div>
                </div>

                {{-- Icon (optional) --}}

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>

                <a href="{{ route('admin.departments.show', $department->id) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>

    </div>

@endsection
