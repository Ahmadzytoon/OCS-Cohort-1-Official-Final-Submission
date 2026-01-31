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

        <form action="{{ route('admin.companies.update', $company->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">

                <!-- Company Name -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Company Name</label>
                        <input name="workspace_name" type="text" class="form-control" placeholder="e.g., Acme Corporation"
                            value="{{ old('workspace_name', $company->workspace_name ?? $company->workspace_name) }}" />
                    </div>
                </div>

                <!-- Company Size -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Company Size</label>
                        <select name="company_size" class="form-control">
                            <option value="">Select size</option>
                            <option value="1-10"
                                {{ old('company_size', $company->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees
                            </option>
                            <option value="11-50"
                                {{ old('company_size', $company->company_size) == '11-50' ? 'selected' : '' }}>11-50
                                employees</option>
                            <option value="51-200"
                                {{ old('company_size', $company->company_size) == '51-200' ? 'selected' : '' }}>51-200
                                employees</option>
                            <option value="200+"
                                {{ old('company_size', $company->company_size) == '200+' ? 'selected' : '' }}>200+ employees
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Industry -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Industry</label>
                        <select name="industry" id="industrySelect" class="form-control">
                            <option value="">Select industry</option>
                            <option value="it-software"
                                {{ old('industry', $company->industry) == 'it-software' ? 'selected' : '' }}>IT / Software
                            </option>
                            <option value="accounting"
                                {{ old('industry', $company->industry) == 'accounting' ? 'selected' : '' }}>Accounting
                            </option>
                            <option value="marketing"
                                {{ old('industry', $company->industry) == 'marketing' ? 'selected' : '' }}>Marketing
                            </option>
                            <option value="hr" {{ old('industry', $company->industry) == 'hr' ? 'selected' : '' }}>HR
                            </option>
                            <option value="manufacturing"
                                {{ old('industry', $company->industry) == 'manufacturing' ? 'selected' : '' }}>
                                Manufacturing</option>
                            <option value="other" {{ old('industry', $company->industry) == 'other' ? 'selected' : '' }}>
                                Other</option>
                        </select>
                    </div>
                </div>

                <!-- Other Industry (Hidden by default) -->
                <div class="col-md-6" id="otherIndustryField"
                    style="display: {{ old('industry', $company->industry) == 'other' ? 'block' : 'none' }};">
                    <div class="form-group form-group-default">
                        <label>Specify Industry</label>
                        <input name="other_industry" type="text" class="form-control"
                            placeholder="e.g., Healthcare, Education"
                            value="{{ old('other_industry', $company->other_industry) }}" />
                    </div>
                </div>

                <!-- Owner Name -->
                <div class="col-md-6" id="ownerNameField">
                    <div class="form-group form-group-default">
                        <label>Owner Name</label>
                        <input name="owner_name" type="text" class="form-control" placeholder="fill owner name" required
                            value="{{ old('owner_name', $owner?->name) }}" />
                    </div>
                </div>

                <!-- Owner Email -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Owner Email</label>
                        <input name="owner_email" type="email" class="form-control" placeholder="fill owner email"
                            required value="{{ old('owner_email', $owner?->email) }}" />
                    </div>
                </div>

                <!-- Owner Phone -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Owner Phone</label>
                        <input name="owner_phone" type="text" class="form-control" placeholder="fill phone (optional)"
                            value="{{ old('owner_phone', $owner?->phone) }}" />
                    </div>
                </div>




            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    Edit
                </button>
                <a href="{{ route('admin.companies.index') }}">
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
            const industrySelect = document.getElementById('industrySelect');
            const otherIndustryField = document.getElementById('otherIndustryField');
            const ownerNameField = document.getElementById('ownerNameField');
            const otherIndustryInput = otherIndustryField.querySelector('input');

            industrySelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    // Show other industry field
                    otherIndustryField.style.display = 'block';
                    otherIndustryInput.required = true;

                    // Adjust owner name field position
                    ownerNameField.classList.remove('col-md-6');
                    ownerNameField.classList.add('col-md-12');
                } else {
                    // Hide other industry field
                    otherIndustryField.style.display = 'none';
                    otherIndustryInput.required = false;
                    otherIndustryInput.value = '';

                    // Reset owner name field position
                    ownerNameField.classList.remove('col-md-12');
                    ownerNameField.classList.add('col-md-6');
                }
            });
        });
    </script>
@endsection
