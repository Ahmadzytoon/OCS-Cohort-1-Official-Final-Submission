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

        <form action="{{ route('admin.companies.store') }}" method="POST">
            @csrf
            <div class="row">

                <!-- Company Name -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Company Name</label>
                        <input name="company_name" type="text" class="form-control" placeholder="e.g., Acme Corporation" />
                    </div>
                </div>

                <!-- Company Size -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Company Size</label>
                        <select name="company_size" class="form-control">
                            <option value="">Select size</option>
                            <option value="1-10">1-10 employees</option>
                            <option value="11-50">11-50 employees</option>
                            <option value="51-200">51-200 employees</option>
                            <option value="200+">200+ employees</option>
                        </select>
                    </div>
                </div>

                <!-- Industry -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Industry</label>
                        <select name="industry" id="industrySelect" class="form-control">
                            <option value="">Select industry</option>
                            <option value="it-software">IT / Software</option>
                            <option value="accounting">Accounting</option>
                            <option value="marketing">Marketing</option>
                            <option value="hr">HR</option>
                            <option value="manufacturing">Manufacturing</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Other Industry (Hidden by default) -->
                <div class="col-md-6" id="otherIndustryField" style="display: none;">
                    <div class="form-group form-group-default">
                        <label>Specify Industry</label>
                        <input name="other_industry" type="text" class="form-control"
                            placeholder="e.g., Healthcare, Education" />
                    </div>
                </div>

                <!-- Owner Name -->
                <div class="col-md-6" id="ownerNameField">
                    <div class="form-group form-group-default">
                        <label>Owner Name</label>
                        <input name="owner_name" type="text" class="form-control" placeholder="fill owner name"
                            required />
                    </div>
                </div>

                <!-- Owner Email -->
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Owner Email</label>
                        <input name="owner_email" type="email" class="form-control" placeholder="fill owner email"
                            required />
                    </div>
                </div>

                <!-- Owner Phone -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Owner Phone</label>
                        <input name="owner_phone" type="text" class="form-control" placeholder="fill phone (optional)" />
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
                <button type="submit" class="btn btn-primary">
                    Add
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
