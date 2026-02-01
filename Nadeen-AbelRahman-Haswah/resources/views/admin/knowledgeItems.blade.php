@extends('admin.layout.master')

@section('title', 'Knowledge Items')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Home</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Knowledge Items</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center  justify-content-between">
                            <h4 class="card-title">Knowledge Items</h4>

                        </div>
                    </div>
                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($items as $item)
                                        <tr>
                                            <td>{{ $item->title }}</td>

                                            <td>
                                                @php
                                                    $typeLabels = [
                                                        'onboarding' => 'Onboarding',
                                                        'mistakes' => 'Mistakes',
                                                        'operational' => 'Operational',
                                                        'critical' => 'Critical',
                                                    ];
                                                @endphp
                                                {{ $typeLabels[$item->type] ?? $item->type }}
                                            </td>

                                            <td>{{ $item->company?->workspace_name ?? '-' }}</td>
                                            <td>{{ $item->department?->name ?? '-' }}</td>
                                            <td>{{ $item->author?->name ?? '-' }}</td>

                                            <td>
                                                @php
                                                    $statusBadges = [
                                                        'draft' => 'secondary',
                                                        'pending' => 'warning',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                    ];
                                                    $badge = $statusBadges[$item->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $badge }}">{{ $item->status }}</span>
                                            </td>

                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.knowledgeItems.show', $item->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-round btn-sm">View</button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No knowledge items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                            {{-- <div class="mt-3">
                                    {{ $items->links() }}
                                </div> --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of
                                    {{ $items->total() }} entries
                                </div>
                                <nav aria-label="Page navigation">
                                    {{ $items->links('pagination::bootstrap-5') }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- Datatables -->
    <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('admin/assets/js/setting-demo2.js') }}"></script>

  

@endsection
