@extends('layouts.admin')

@section('content')
    <div class="animate-fade-in">
        <!-- Header & Statistics -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Collections</h1>
                    <p class="text-muted small mb-0">Manage the thematic structure of your luxury pieces.</p>
                </div>
                <a href="{{ route('admin.categories.create') }}"
                    class="btn btn-dark rounded-pill px-4 shadow-sm border-0 d-flex align-items-center gap-2">
                    <i class="fa fa-plus small"></i> New Collection
                </a>
            </div>
        </div>

        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                        ...softSwal
                    });
                });
            </script>
        @endif

        <!-- Collections Table -->
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light bg-opacity-50 align-top">
                                <th class="ps-4 py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1"
                                    style="width: 60px;">ID</th>
                                <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Collection Name
                                </th>
                                <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">
                                    Inventory Count</th>
                                <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">
                                    Global Discount</th>
                                <th class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($categories as $category)
                                <tr class="border-top" style="border-color: rgba(0,0,0,0.02) !important;">
                                    <td class="ps-4 text-muted small fw-bold">#{{ $category->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-soft-blush rounded-circle d-flex align-items-center justify-content-center me-3 text-dark fw-bold"
                                                style="width: 40px; height: 40px; font-size: 0.85rem; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                                {{ substr($category->name, 0, 1) }}
                                            </div>
                                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 small">
                                            {{ $category->products_count ?? $category->products()->count() }} items
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($category->discount_percentage > 0)
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 small">
                                                -{{ (float) $category->discount_percentage }}%
                                            </span>
                                        @else
                                            <span class="text-muted opacity-50 small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-light rounded-pill px-3 py-1 extra-small fw-bold border shadow-sm hover-lift"
                                                title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                                class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 extra-small border-0 hover-lift delete-btn"
                                                    title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa fa-layer-group fa-3x mb-3 opacity-25 text-primary"></i>
                                        <p class="mb-0 fw-bold">No collections found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($categories->hasPages())
                <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.65rem;
        }

        .ls-1 {
            letter-spacing: 1.5px;
        }

        .bg-soft-blush {
            background: rgba(246, 166, 178, 0.15);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }

        .text-primary {
            color: #F6A6B2 !important;
        }
    </style>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.delete-form');
                Swal.fire({
                    ...softSwal,
                    title: 'Dissolve Collection?',
                    text: "This will remove the category and detach all associated products.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, dissolve',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endsection