@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h2 class="h3 text-gray-800" style="font-family: 'Playfair Display', serif;">User Management</h2>
                <p class="text-muted">Manage your users and their profiles efficiently.</p>
            </div>
        </div>

        <livewire:admin.user-manager />
    </div>
@endsection