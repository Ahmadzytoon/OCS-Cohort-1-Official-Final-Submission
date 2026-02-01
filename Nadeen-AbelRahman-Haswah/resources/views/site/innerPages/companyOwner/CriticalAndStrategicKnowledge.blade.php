@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Knowledge Center</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Knowledge Center</a></li>
                <li class="breadcrumb-item active">Critical & Strategic Knowledge</li>
            </ol>
        </nav>
    </div>

    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">
                    <i class="fas fa-star text-danger me-2"></i> Critical & Strategic Knowledge
                </h4>
                <p class="text-muted">High-level decisions, promotion stories, and leadership insights</p>
            </div>
            {{-- <div class="col-md-4 text-end">
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createCriticalModal">
                    <i class="fas fa-plus me-2"></i> Add Strategic Insight
                </button>
            </div> --}}
        </div>

        <!-- Filters & Search -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <form method="GET" action="{{ url()->current() }}">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Search strategic knowledge...">
                    </div>
                </form>
            </div>

            <div class="col-md-6 text-end d-flex align-items-center justify-content-end">
                <span class="text-muted">Showing: <strong>{{ $entries->total() }}</strong></span>
            </div>
        </div>


        <!-- Critical Knowledge Cards -->
        <div class="row g-4">
            @forelse($entries as $entry)
                <div class="col-lg-6">
                    <div class="critical-card decision-card">
                        <div class="critical-card-header">
                            <div class="card-type-badge type-critical">
                                <i class="fas fa-star"></i> Critical
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item" type="button"
                                            onclick="openCriticalDetails({{ $entry->id }})">
                                            <i class="fas fa-eye me-2"></i> View
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="critical-card-body">
                            <h5 class="card-title-critical">{{ $entry->title }}</h5>

                            <div class="decision-meta">
                                <span class="meta-badge">
                                    <i class="fas fa-building"></i> {{ $entry->department?->name ?? '—' }}
                                </span>

                                <span class="meta-badge">
                                    <i class="fas fa-user"></i> {{ $entry->author?->name ?? '—' }}
                                </span>

                                <span class="meta-badge">
                                    <i class="fas fa-calendar"></i>
                                    {{ optional($entry->approved_at ?? $entry->created_at)->diffForHumans() }}
                                </span>

                                @if (($entry->visibility ?? null) === 'confidential')
                                    <span class="meta-badge confidential-badge">
                                        <i class="fas fa-lock"></i> Confidential
                                    </span>
                                @endif
                            </div>

                            <div class="decision-section mt-3">
                                <h6><i class="fas fa-align-left text-primary"></i> Summary</h6>
                                <p class="mb-0">{{ \Illuminate\Support\Str::limit($entry->summary, 220) }}</p>
                            </div>

                            @if ($entry->tags?->count())
                                <div class="mt-3">
                                    @foreach ($entry->tags as $tag)
                                        <span class="skill-tag">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="critical-card-footer">
                            <span class="status-badge status-active">Approved</span>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="openCriticalDetails({{ $entry->id }})">
                                <i class="fas fa-eye me-1"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="p-4 text-center text-muted">No critical knowledge cards found.</div>
                </div>
            @endforelse
        </div>
        <!-- Details Modal -->
        <div class="modal fade" id="criticalDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-eye me-2"></i> Critical Knowledge Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="criticalDetailsBody">
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
            async function openCriticalDetails(id) {
                const modalEl = document.getElementById('criticalDetailsModal');
                const bodyEl = document.getElementById('criticalDetailsBody');

                bodyEl.innerHTML = `<div class="text-center text-muted py-4">Loading...</div>`;
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                // ✅ نطلع URL من لارافيل ونستبدل :id
                const url = `{{ route('shared.criticalDetails', ['entry' => '__ID__']) }}`.replace('__ID__', id);

                try {
                    const res = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    // ✅ إذا في خطأ HTTP (404/403/500) قبل ما نعمل json
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
