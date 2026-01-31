@extends('admin.layout.master')

@section('title', 'Edit Plan')


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

        <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
            @csrf
            @method('PUT')
            <h4 class="fw-bold mb-3">Create New Plan</h4>

            <div class="row">

                <!-- Plan Name -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Plan Name</label>
                        <input name="name" type="text" class="form-control" value="{{ old('name', $plan->name) }}">

                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Price -->
                <div class="col-md-3">
                    <div class="form-group form-group-default">
                        <label>Price ($)</label>
                        <input name="price" type="number" step="0.01" class="form-control" placeholder="0"
                            value="{{ old('price', $plan->price) }}">
                        @error('price')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Billing Cycle -->
                <div class="col-md-3">
                    <div class="form-group form-group-default">
                        <label>Billing Cycle</label>
                        <select class="form-control" name="billing_cycle">
                            <option value="monthly"
                                {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly
                            </option>
                            <option value="yearly"
                                {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly
                            </option>
                            <option value="trial"
                                {{ old('billing_cycle', $plan->billing_cycle) == 'trial' ? 'selected' : '' }}>Trial</option>
                            <option
                                value="lifetime"{{ old('billing_cycle', $plan->billing_cycle) == 'lifetime' ? 'selected' : '' }}>
                                Lifetime</option>

                        </select>
                        @error('billing_cycle')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Limits -->
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Max Users</label>
                        <input type="number" name="max_users" class="form-control" placeholder="10"
                            value="{{ old('max_users', $plan->max_users) }}">
                        @error('max_users')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Knowledge Cards Limit</label>
                        <input type="number" name="max_knowledge_cards" class="form-control" placeholder="500"
                            value="{{ old('max_knowledge_cards', $plan->max_knowledge_cards) }}">
                        @error('max_knowledge_cards')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Max Departments</label>
                        <input type="number" name="max_departments" class="form-control" placeholder="20"
                            value="{{ old('max_departments', $plan->max_departments) }}">
                        @error('max_departments')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>AI Requests / Month</label>
                        <input type="number" name="ai_requests_limit" class="form-control" placeholder="1000"
                            value="{{ old('ai_requests_limit', $plan->ai_requests_limit) }}">
                        @error('ai_requests_limit')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Trial -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Trial Days (optional)</label>
                        <input type="number" name="trial_days" class="form-control" placeholder="14"
                            value="{{ old('trial_days', $plan->trial_days) }}">
                        @error('trial_days')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <div class="form-group form-group-default">
                        <label>Status</label>
                        <select class="form-control" name="is_active">
                            <option value="1" {{ old('is_active', $plan->is_active) == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('is_active', $plan->is_active) == 0 ? 'selected' : '' }}>Inactive
                            </option>

                        </select>
                        @error('is_active')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Plan Features -->
                <div class="col-md-12">
                    <div class="form-group form-group-default">
                        <label>Plan Features</label>

                        <div id="featuresWrapper">
                            @php
                                $featuresList = old('features', $features ?? ['']);
                            @endphp

                            @foreach ($featuresList as $f)
                                <div class="d-flex gap-2 mb-2 feature-row">
                                    <input type="text" name="features[]" class="form-control"
                                        placeholder="e.g. 📅 Public Calendar" value="{{ $f }}">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-feature">X</button>
                                </div>
                            @endforeach
                        </div>

                        @error('features')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        @error('features.*')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        <button type="button" id="btnAddFeature" class="btn btn-primary btn-sm mt-2">
                            + Add Feature
                        </button>
                    </div>
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Edit Plan</button>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('featuresWrapper');
            const addBtn = document.getElementById('btnAddFeature');

            function addRow(value = '') {
                const row = document.createElement('div');
                row.className = 'd-flex gap-2 mb-2 feature-row';
                row.innerHTML = `
      <input type="text" name="features[]" class="form-control" placeholder="e.g. 📰 Company News" value="${value}">
      <button type="button" class="btn btn-danger btn-sm btn-remove-feature">X</button>
    `;
                wrapper.appendChild(row);
            }

            addBtn.addEventListener('click', () => addRow());

            wrapper.addEventListener('click', (e) => {
                if (e.target.classList.contains('btn-remove-feature')) {
                    e.target.closest('.feature-row').remove();
                }
            });
        });
    </script>

@endsection
