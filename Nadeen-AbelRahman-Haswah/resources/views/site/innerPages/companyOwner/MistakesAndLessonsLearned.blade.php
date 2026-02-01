@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Knowledge Center</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Knowledge Center</a></li>
                <li class="breadcrumb-item active"> Mistakes & Lessons Learned </li>
            </ol>
        </nav>

        <div class="content-body">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h4 class="mb-2">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i> Mistakes & Lessons Learned
                    </h4>
                    <p class="text-muted">Learn from past mistakes to prevent future issues</p>
                </div>
                {{-- <div class="col-md-4 text-end">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createMistakeModal">
                        <i class="fas fa-plus me-2"></i> Document a Mistake
                    </button>
                </div> --}}
            </div>

            <!-- Filters & Search -->
            <div class="row g-3 mb-4">
                <form method="GET" action="{{ url()->current() }}">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" value="{{ $q ?? request('q') }}" class="form-control"
                            placeholder="Search...">
                    </div>
                </form>

                {{-- <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Departments</option>
                        <option value="it">IT Department</option>
                        <option value="sales">Sales Department</option>
                        <option value="marketing">Marketing Department</option>
                    </select>
                </div> --}}
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">Impact Level</option>
                        <option value="high">High Impact</option>
                        <option value="medium">Medium Impact</option>
                        <option value="low">Low Impact</option>
                    </select>
                </div>

            </div>

            {{-- <!-- High Impact Mistakes Alert -->
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-exclamation-circle me-2"></i> High Impact Mistakes
                </h5>
                <p class="mb-0">There are <strong>3 high-impact mistakes</strong> documented this month. Review them
                    carefully to prevent recurrence.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div> --}}
            <!-- Mistakes Cards -->
            <div class="row g-4">
                @forelse($entries as $entry)
                    <div class="col-lg-6">
                        <div class="knowledge-card">
                            <div class="knowledge-card-body">
                                <h5 class="card-title-knowledge">{{ $entry->title }}</h5>
                                <p class="card-description">{{ \Illuminate\Support\Str::limit($entry->summary, 170) }}</p>

                                <div class="card-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-building text-primary"></i> {{ $entry->department?->name }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user text-success"></i> {{ $entry->author?->name }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-clock text-muted"></i>
                                        {{ optional($entry->approved_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="knowledge-card-footer">
                                <span class="status-badge status-active">Approved</span>
                                <div class="card-actions">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="openMistakeDetails({{ $entry->id }})">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-4 text-center text-muted">No cards found.</div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Mistake Details Modal -->
    <div class="modal fade" id="mistakeDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-eye me-2"></i> Mistake Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="mistakeDetailsBody">
                    <div class="text-center text-muted py-4">Loading...</div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    async function openMistakeDetails(id) {
        const modalEl = document.getElementById('mistakeDetailsModal');
        const bodyEl  = document.getElementById('mistakeDetailsBody');

        bodyEl.innerHTML = `<div class="text-center text-muted py-4">Loading...</div>`;
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // ✅ route() + replace عشان URL يكون 100% صحيح
        const url = `{{ route('shared.mistakesDetails', ['entry' => '__ID__']) }}`.replace('__ID__', id);

        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const data = await res.json();
            if (!data.ok) throw new Error(data.message || 'Failed');

            bodyEl.innerHTML = data.html;

        } catch (e) {
            bodyEl.innerHTML = `
                <div class="alert alert-danger mb-0">
                    Failed to load details. (${e.message})
                </div>
            `;
        }
    }
</script>
@endsection
