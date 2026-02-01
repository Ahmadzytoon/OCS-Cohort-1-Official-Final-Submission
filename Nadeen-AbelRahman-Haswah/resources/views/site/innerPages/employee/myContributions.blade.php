@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
        <!-- Page Header -->
        <div class="contributions-header">
            <div class="header-content-contributions">
                <div>
                    <h1><i class="fas fa-file-alt me-3"></i>My Contributions</h1>
                    <p>Track and manage all your knowledge cards</p>
                </div>
                <button class="btn btn-primary btn-lg" onclick="window.location.href='/employee/add-knowledge'">
                    <i class="fas fa-plus-circle me-2"></i> Add New Card
                </button>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="contribution-stat-card total">
                    <div class="stat-icon-contrib">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content-contrib">
                        <h3>{{ $total }}</h3>
                        <p>Total Cards</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contribution-stat-card approved">
                    <div class="stat-icon-contrib">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content-contrib">
                        <h3>{{ $approved }}</h3>
                        <p>Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contribution-stat-card pending">
                    <div class="stat-icon-contrib">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content-contrib">
                        <h3>{{ $pending }}</h3>
                        <p>Pending Review</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contribution-stat-card rejected">
                    <div class="stat-icon-contrib">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-content-contrib">
                        <h3>{{ $rejected }}</h3>
                        <p>Rejected</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="content-card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('knowledge.knowledge.myContributions') }}">
                    <div class="filters-row">
                        <div class="search-box-contrib">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, content, or tags...">
                        </div>

                        <div class="filter-controls">
                            <select class="form-select" name="status">
                                <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Status
                                </option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                    Review
                                </option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>

                            <select class="form-select" name="type">
                                <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>All Types
                                </option>
                                <option value="onboarding" {{ request('type') === 'onboarding' ? 'selected' : '' }}>
                                    Onboarding</option>
                                <option value="mistakes" {{ request('type') === 'mistakes' ? 'selected' : '' }}>Mistakes &
                                    Lessons</option>
                                <option value="operational" {{ request('type') === 'operational' ? 'selected' : '' }}>
                                    Operational</option>
                                <option value="critical" {{ request('type') === 'critical' ? 'selected' : '' }}>Critical &
                                    Strategic</option>
                            </select>

                            <select class="form-select" name="sort">
                                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>
                                    Newest
                                    First</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First
                                </option>
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title A-Z
                                </option>
                            </select>

                            <button class="btn btn-primary" type="submit">Apply</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- Cards List -->
        <div class="row g-4" id="cardsContainer">
            @forelse($entries as $entry)
                <div class="col-lg-6">
                    <div class="contribution-card {{ $entry->status }}-card">

                        {{-- status badge --}}
                        <div class="card-status-badge {{ $entry->status }}-badge">
                            @if ($entry->status === 'approved')
                                <i class="fas fa-check-circle"></i> Approved
                            @elseif($entry->status === 'pending')
                                <i class="fas fa-clock"></i> Pending Review
                            @elseif($entry->status === 'rejected')
                                <i class="fas fa-times-circle"></i> Rejected
                            @else
                                <i class="fas fa-save"></i> Draft
                            @endif
                        </div>

                        <div class="contribution-card-header">
                            <div class="card-type-badge {{ $entry->type }}-badge">
                                {{ ucfirst($entry->type) }}
                            </div>
                        </div>

                        <div class="contribution-card-body">
                            <h4>{{ $entry->title }}</h4>
                            <p>{{ \Illuminate\Support\Str::limit($entry->summary, 140) }}</p>

                            <div class="card-meta-info">
                                <span class="meta-item">
                                    <i class="fas fa-tag"></i>
                                    {{ $entry->tags->pluck('name')->implode(', ') ?: '—' }}
                                </span>

                                <span class="meta-item">
                                    <i class="fas fa-paperclip"></i>
                                    {{ $entry->attachments->count() }} attachments
                                </span>


                            </div>
                        </div>

                        <div class="contribution-card-footer">
                            {{-- VIEW --}}
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#viewEntryModal-{{ $entry->id }}">
                                <i class="fas fa-eye"></i> View
                            </button>

                            {{-- EDIT (فعال فقط اذا مش approved) --}}
                            @if ($entry->status !== 'approved')
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editEntryModal-{{ $entry->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            @endif

                            {{-- DELETE (مودال فورم) --}}
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteEntryModal-{{ $entry->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>


                    </div>
                </div>
                @php
                    $typeLabels = [
                        'onboarding' => 'Onboarding Knowledge',
                        'mistakes' => 'Mistakes & Lessons Learned',
                        'operational' => 'Operational Knowledge',
                        'critical' => 'Critical & Strategic Knowledge',
                    ];

                    $statusLabels = [
                        'approved' => ['text' => 'Approved', 'class' => 'success', 'icon' => 'fa-check-circle'],
                        'pending' => ['text' => 'Pending Review', 'class' => 'warning', 'icon' => 'fa-clock'],
                        'rejected' => ['text' => 'Rejected', 'class' => 'danger', 'icon' => 'fa-times-circle'],
                        'draft' => ['text' => 'Draft', 'class' => 'secondary', 'icon' => 'fa-save'],
                    ];

                    $statusMeta = $statusLabels[$entry->status] ?? $statusLabels['draft'];
                    $typeText = $typeLabels[$entry->type] ?? ucfirst($entry->type);

                    // operational steps parsing (من extra['steps'])
                    $stepsText = data_get($entry->extra, 'steps', '');
                    $stepsLines = collect(preg_split("/\r\n|\n|\r/", (string) $stepsText))
                        ->map(fn($l) => trim($l))
                        ->filter()
                        ->values();
                @endphp

                {{-- view modal --}}
                <div class="modal fade" id="viewEntryModal-{{ $entry->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <h5 class="modal-title">
                                        <i class="fas fa-file-alt me-2"></i> Card Details
                                    </h5>
                                    <small class="text-muted">View full details of this knowledge card</small>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                {{-- Status + Type row --}}
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                    <span class="badge bg-{{ $statusMeta['class'] }}">
                                        <i class="fas {{ $statusMeta['icon'] }} me-1"></i> {{ $statusMeta['text'] }}
                                    </span>

                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="fas fa-layer-group me-1"></i> {{ $typeText }}
                                    </span>

                                    <span class="text-muted ms-auto">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ optional($entry->created_at)->format('Y-m-d H:i') }}
                                    </span>
                                </div>

                                <h4 class="mb-2">{{ $entry->title }}</h4>

                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Summary</h6>
                                    <div class="p-3 bg-light rounded-3">
                                        {{ $entry->summary }}
                                    </div>
                                </div>

                                {{-- TYPE-SPECIFIC DETAILS --}}
                                @if ($entry->type === 'onboarding')
                                    <div class="mb-4">
                                        <h6 class="text-muted mb-2">Main Content</h6>
                                        <div class="p-3 bg-light rounded-3">
                                            {{ $entry->content }}
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Timeline</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'timeline', '—') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Key Takeaways</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'key_takeaways', '—') }}
                                            </div>
                                        </div>
                                    </div>
                                @elseif($entry->type === 'mistakes')
                                    <div class="row g-3 mb-4">
                                        <div class="col-12">
                                            <h6 class="text-muted mb-2">What happened?</h6>
                                            <div class="p-3 bg-light rounded-3">
                                                {{ data_get($entry->extra, 'mistake', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-2">Impact Level</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'impact_level', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <h6 class="text-muted mb-2">Solution</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'solution', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h6 class="text-muted mb-2">Lessons Learned</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'lessons', '—') }}
                                            </div>
                                        </div>
                                    </div>
                                @elseif($entry->type === 'operational')
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Task Name</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'task_name', '—') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Frequency</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'frequency', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h6 class="text-muted mb-2">Step-by-Step Guide</h6>

                                            @if ($stepsLines->count())
                                                <ol class="list-group list-group-numbered">
                                                    @foreach ($stepsLines as $line)
                                                        <li class="list-group-item">{{ $line }}</li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                <div class="p-3 bg-light rounded-3">—</div>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Required Tools</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'tools', '—') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Helpful Links</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'links', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h6 class="text-muted mb-2">Common Issues & Tips</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'common_issues', '—') }}
                                            </div>
                                        </div>
                                    </div>
                                @elseif($entry->type === 'critical')
                                    <div class="mb-4">
                                        <h6 class="text-muted mb-2">Story</h6>
                                        <div class="p-3 bg-light rounded-3">
                                            {{ data_get($entry->extra, 'story', '—') }}
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Category</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'category', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Skills Developed</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'skills', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h6 class="text-muted mb-2">Key Success Factors</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'success_factors', '—') }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h6 class="text-muted mb-2">Advice & Insights</h6>
                                            <div class="p-3 bg-white border rounded-3">
                                                {{ data_get($entry->extra, 'advice', '—') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Tags + Attachments --}}
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-2">Tags</h6>
                                        <div class="p-3 bg-white border rounded-3">
                                            {{ $entry->tags->pluck('name')->implode(', ') ?: '—' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-2">Attachments</h6>
                                        <div class="p-3 bg-white border rounded-3">
                                            @if ($entry->attachments->count())
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($entry->attachments as $att)
                                                        <li class="mb-2">
                                                            <i class="fas fa-paperclip me-1"></i>
                                                            @if ($att->url)
                                                                <a href="{{ $att->url }}"
                                                                    target="_blank">{{ $att->original_name ?? $att->url }}</a>
                                                            @else
                                                                <a href="{{ asset('storage/' . $att->path) }}"
                                                                    target="_blank">
                                                                    {{ $att->original_name ?? 'Attachment' }}
                                                                </a>
                                                                <small class="text-muted">({{ $att->type }})</small>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                —
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                @if ($entry->status !== 'approved')
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                                        data-bs-toggle="modal" data-bs-target="#editEntryModal-{{ $entry->id }}">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-lock me-1"></i> Approved (Locked)
                                    </button>
                                @endif

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- edit modal  --}}
                <div class="modal fade" id="editEntryModal-{{ $entry->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">

                            <form method="POST" action="{{ route('knowledge.knowledge.update', $entry) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title">
                                            <i class="fas fa-edit me-2"></i> Edit Knowledge Card
                                        </h5>
                                        <small class="text-muted">You can edit draft/pending cards only</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    {{-- keep type --}}
                                    <input type="hidden" name="type" value="{{ $entry->type }}">

                                    {{-- action --}}
                                    <input type="hidden" name="action" id="editActionInput-{{ $entry->id }}"
                                        value="submit">

                                    <div class="mb-3">
                                        <label class="form-label required">Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $entry->title }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Summary</label>
                                        <textarea name="summary" class="form-control" rows="3" required>{{ $entry->summary }}</textarea>
                                    </div>

                                    {{-- TYPE FIELDS --}}
                                    @if ($entry->type === 'onboarding')
                                        <div class="mb-3">
                                            <label class="form-label required">Main Content</label>
                                            <textarea name="content" class="form-control" rows="6" required>{{ $entry->content }}</textarea>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Timeline</label>
                                                <select class="form-select" name="extra[timeline]">
                                                    @php $timeline = data_get($entry->extra,'timeline'); @endphp
                                                    <option value="" {{ $timeline ? '' : 'selected' }}>Select
                                                        timeframe</option>
                                                    <option value="first-day"
                                                        {{ $timeline === 'first-day' ? 'selected' : '' }}>
                                                        First Day</option>
                                                    <option value="first-week"
                                                        {{ $timeline === 'first-week' ? 'selected' : '' }}>First Week
                                                    </option>
                                                    <option value="first-month"
                                                        {{ $timeline === 'first-month' ? 'selected' : '' }}>First Month
                                                    </option>
                                                    <option value="first-quarter"
                                                        {{ $timeline === 'first-quarter' ? 'selected' : '' }}>First 3
                                                        Months
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Key Takeaways</label>
                                                <textarea class="form-control" name="extra[key_takeaways]" rows="3">{{ data_get($entry->extra, 'key_takeaways') }}</textarea>
                                            </div>
                                        </div>
                                    @elseif($entry->type === 'mistakes')
                                        <div class="mb-3">
                                            <label class="form-label required">What happened?</label>
                                            <textarea class="form-control" name="extra[mistake]" rows="3" required>{{ data_get($entry->extra, 'mistake') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Impact Level</label>
                                            @php $impact = data_get($entry->extra,'impact_level'); @endphp
                                            <select class="form-select" name="extra[impact_level]" required>
                                                <option value="">Select impact</option>
                                                <option value="low" {{ $impact === 'low' ? 'selected' : '' }}>Low
                                                </option>
                                                <option value="medium" {{ $impact === 'medium' ? 'selected' : '' }}>Medium
                                                </option>
                                                <option value="high" {{ $impact === 'high' ? 'selected' : '' }}>High
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Solution</label>
                                            <textarea class="form-control" name="extra[solution]" rows="3" required>{{ data_get($entry->extra, 'solution') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Lessons Learned</label>
                                            <textarea class="form-control" name="extra[lessons]" rows="3" required>{{ data_get($entry->extra, 'lessons') }}</textarea>
                                        </div>
                                    @elseif($entry->type === 'operational')
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label required">Task Name</label>
                                                <input type="text" class="form-control" name="extra[task_name]"
                                                    value="{{ data_get($entry->extra, 'task_name') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Frequency</label>
                                                @php $freq = data_get($entry->extra,'frequency'); @endphp
                                                <select class="form-select" name="extra[frequency]">
                                                    <option value="" {{ $freq ? '' : 'selected' }}>Select</option>
                                                    <option value="daily" {{ $freq === 'daily' ? 'selected' : '' }}>Daily
                                                    </option>
                                                    <option value="weekly" {{ $freq === 'weekly' ? 'selected' : '' }}>
                                                        Weekly
                                                    </option>
                                                    <option value="monthly" {{ $freq === 'monthly' ? 'selected' : '' }}>
                                                        Monthly
                                                    </option>
                                                    <option value="as-needed"
                                                        {{ $freq === 'as-needed' ? 'selected' : '' }}>As
                                                        Needed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Step-by-Step Guide</label>
                                            <textarea class="form-control" name="extra[steps]" rows="7" required>{{ data_get($entry->extra, 'steps') }}</textarea>
                                            <div class="form-text">Write each step in a new line for best display.</div>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Required Tools</label>
                                                <input type="text" class="form-control" name="extra[tools]"
                                                    value="{{ data_get($entry->extra, 'tools') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Helpful Links</label>
                                                <textarea class="form-control" name="extra[links]" rows="2">{{ data_get($entry->extra, 'links') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Common Issues & Tips</label>
                                            <textarea class="form-control" name="extra[common_issues]" rows="3">{{ data_get($entry->extra, 'common_issues') }}</textarea>
                                        </div>
                                    @elseif($entry->type === 'critical')
                                        <div class="mb-3">
                                            <label class="form-label required">Story</label>
                                            <textarea class="form-control" name="extra[story]" rows="5" required>{{ data_get($entry->extra, 'story') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            @php $cat = data_get($entry->extra,'category'); @endphp
                                            <select class="form-select" name="extra[category]">
                                                <option value="" {{ $cat ? '' : 'selected' }}>Select</option>
                                                <option value="promotion" {{ $cat === 'promotion' ? 'selected' : '' }}>
                                                    Career
                                                    Promotion</option>
                                                <option value="project" {{ $cat === 'project' ? 'selected' : '' }}>Major
                                                    Project
                                                </option>
                                                <option value="decision" {{ $cat === 'decision' ? 'selected' : '' }}>
                                                    Strategic
                                                    Decision</option>
                                                <option value="challenge" {{ $cat === 'challenge' ? 'selected' : '' }}>
                                                    Overcoming Challenge</option>
                                                <option value="other" {{ $cat === 'other' ? 'selected' : '' }}>Other
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Key Success Factors</label>
                                            <textarea class="form-control" name="extra[success_factors]" rows="3" required>{{ data_get($entry->extra, 'success_factors') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Advice & Insights</label>
                                            <textarea class="form-control" name="extra[advice]" rows="3" required>{{ data_get($entry->extra, 'advice') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Skills Developed</label>
                                            <input type="text" class="form-control" name="extra[skills]"
                                                value="{{ data_get($entry->extra, 'skills') }}">
                                        </div>
                                    @endif

                                    {{-- tags --}}
                                    <div class="mb-3">
                                        <label class="form-label">Tags</label>
                                        <input type="text" name="tags" class="form-control"
                                            value="{{ $entry->tags->pluck('name')->implode(', ') }}">
                                    </div>

                                    {{-- new attachments optional --}}
                                    <div class="mb-2">
                                        <label class="form-label">Add Attachments (Optional)</label>
                                        <input type="file" name="attachments[]" class="form-control" multiple>
                                        <div class="form-text">Uploading new files will add to existing attachments.</div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cancel</button>

                                    <button type="submit" class="btn btn-outline-primary"
                                        onclick="document.getElementById('editActionInput-{{ $entry->id }}').value='draft'">
                                        <i class="fas fa-save me-2"></i> Save as Draft
                                    </button>

                                    <button type="submit" class="btn btn-primary"
                                        onclick="document.getElementById('editActionInput-{{ $entry->id }}').value='submit'">
                                        <i class="fas fa-paper-plane me-2"></i> Submit for Approval
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- delete modal --}}
                <div class="modal fade" id="deleteEntryModal-{{ $entry->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Confirm Delete
                                </h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p class="mb-2">Are you sure you want to delete this knowledge card?</p>
                                <div class="p-3 bg-light rounded-3">
                                    <strong>{{ $entry->title }}</strong>
                                    <div class="text-muted small mt-1">This action cannot be undone.</div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                <form method="POST" action="{{ route('knowledge.knowledge.destroy', $entry) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state" style="display:block;">
                        <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                        <h4>No cards found</h4>
                        <p>Try adjusting your filters or create a new knowledge card</p>
                        <button class="btn btn-primary"
                            onclick="window.location.href='{{ route('knowledge.knowledge.create') }}'">
                            <i class="fas fa-plus-circle me-2"></i> Add Your First Card
                        </button>
                    </div>
                </div>
            @endforelse
        </div>


        <!-- Empty State (Hidden by default) -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h4>No cards found</h4>
            <p>Try adjusting your filters or create a new knowledge card</p>
            <button class="btn btn-primary" onclick="window.location.href='/employee/add-knowledge'">
                <i class="fas fa-plus-circle me-2"></i> Add Your First Card
            </button>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="pagination-info">
                Showing
                <strong>{{ $entries->firstItem() ?? 0 }}-{{ $entries->lastItem() ?? 0 }}</strong>
                of <strong>{{ $entries->total() }}</strong> cards
            </div>

            {{ $entries->links() }}
        </div>

    </div>

    <!-- View Card Modal -->
    <div class="modal fade" id="viewCardModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt me-2"></i> Card Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="card-detail-view">
                        <div class="detail-status-badge approved-badge mb-3">
                            <i class="fas fa-check-circle"></i> Approved
                        </div>
                        <h3>Git Workflow Best Practices</h3>
                        <div class="detail-meta mb-4">
                            <span class="badge bg-primary-subtle text-primary">
                                <i class="fas fa-graduation-cap me-1"></i> Onboarding Knowledge
                            </span>
                            <span class="text-muted">
                                <i class="fas fa-calendar me-1"></i> Created 2 hours ago
                            </span>
                            <span class="text-muted">
                                <i class="fas fa-eye me-1"></i> 0 views
                            </span>
                        </div>
                        <div class="detail-content">
                            <h6>Summary</h6>
                            <p>Essential guide for new developers on how to use Git effectively in our team. Covers
                                branching strategies, commit messages, and pull request guidelines.</p>

                            <h6>Main Content</h6>
                            <p>This is the full detailed content of the knowledge card...</p>

                            <h6>Tags</h6>
                            <div class="tags-list">
                                <span class="badge bg-light text-dark">git</span>
                                <span class="badge bg-light text-dark">workflow</span>
                                <span class="badge bg-light text-dark">best-practices</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete this knowledge card? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: "{{ session('swal.type') }}",
                    title: "{{ session('swal.title') }}",
                    text: "{{ session('swal.text') }}",
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif


    <script>
        // My Contributions Page JavaScript

        let currentDeleteCardId = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            initializeSearch();
            initializeFilters();
            animateCards();
        });

        // Initialize Search
        function initializeSearch() {
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterCardsBySearch(searchTerm);
            });
        }

        // Filter Cards by Search
        function filterCardsBySearch(searchTerm) {
            const cards = document.querySelectorAll('[data-status]');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.querySelector('h4').textContent.toLowerCase();
                const content = card.querySelector('p').textContent.toLowerCase();
                const tags = card.querySelector('.meta-item').textContent.toLowerCase();

                if (title.includes(searchTerm) || content.includes(searchTerm) || tags.includes(searchTerm)) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            toggleEmptyState(visibleCount === 0);
        }

        // Initialize Filters
        function initializeFilters() {
            // No additional initialization needed as onchange is inline
        }

        // Filter Cards
        function filterCards() {
            const statusFilter = document.getElementById('statusFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const cards = document.querySelectorAll('[data-status]');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                const cardType = card.getAttribute('data-type');

                let showCard = true;

                if (statusFilter !== 'all' && cardStatus !== statusFilter) {
                    showCard = false;
                }

                if (typeFilter !== 'all' && cardType !== typeFilter) {
                    showCard = false;
                }

                if (showCard) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            toggleEmptyState(visibleCount === 0);
        }

        // Sort Cards
        function sortCards() {
            const sortValue = document.getElementById('sortFilter').value;
            const container = document.getElementById('cardsContainer');
            const cards = Array.from(container.children);

            cards.sort((a, b) => {
                if (sortValue === 'newest') {
                    // Sort by date (newest first) - simplified
                    return 0;
                } else if (sortValue === 'oldest') {
                    // Sort by date (oldest first) - simplified
                    return 0;
                } else if (sortValue === 'title') {
                    const titleA = a.querySelector('h4').textContent.toLowerCase();
                    const titleB = b.querySelector('h4').textContent.toLowerCase();
                    return titleA.localeCompare(titleB);
                }
                return 0;
            });

            // Re-append sorted cards
            cards.forEach(card => container.appendChild(card));
        }

        // Toggle Empty State
        function toggleEmptyState(show) {
            const emptyState = document.getElementById('emptyState');
            const cardsContainer = document.getElementById('cardsContainer');
            const paginationContainer = document.getElementById('paginationContainer');

            if (show) {
                emptyState.style.display = 'block';
                cardsContainer.style.display = 'none';
                paginationContainer.style.display = 'none';
            } else {
                emptyState.style.display = 'none';
                cardsContainer.style.display = 'flex';
                paginationContainer.style.display = 'flex';
            }
        }

        // Animate Cards on Load
        function animateCards() {
            const cards = document.querySelectorAll('.contribution-card');

            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });
        }

        // View Card
        function viewCard(cardId) {
            // Show modal with card details
            const modal = new bootstrap.Modal(document.getElementById('viewCardModal'));
            modal.show();

            // In real app, load card details via API
            console.log('Viewing card:', cardId);
        }

        // Edit Card
        function editCard(cardId) {
            // Redirect to edit page
            window.location.href = `/employee/edit-knowledge/${cardId}`;

            console.log('Editing card:', cardId);
            showNotification('Redirecting to edit page...', 'info');
        }

        // Delete Card
        function deleteCard(cardId) {
            currentDeleteCardId = cardId;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Confirm Delete
        function confirmDelete() {
            if (currentDeleteCardId) {
                // Remove card from DOM
                const cards = document.querySelectorAll('.contribution-card');
                const cardToDelete = Array.from(cards).find((card, index) => index + 1 === currentDeleteCardId);

                if (cardToDelete) {
                    // Animate deletion
                    cardToDelete.style.transition = 'all 0.3s ease';
                    cardToDelete.style.opacity = '0';
                    cardToDelete.style.transform = 'translateX(-20px)';

                    setTimeout(() => {
                        cardToDelete.closest('.col-lg-6').remove();
                        updateStatistics();
                        showNotification('Knowledge card deleted successfully', 'success');
                    }, 300);
                }

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                modal.hide();

                currentDeleteCardId = null;
            }
        }

        // Update Statistics
        function updateStatistics() {
            // Count cards by status
            const allCards = document.querySelectorAll('[data-status]');
            const pendingCards = document.querySelectorAll('[data-status="pending"]');
            const approvedCards = document.querySelectorAll('[data-status="approved"]');
            const rejectedCards = document.querySelectorAll('[data-status="rejected"]');

            // Update stat cards
            const statCards = document.querySelectorAll('.contribution-stat-card');

            if (statCards[0]) {
                const totalCount = statCards[0].querySelector('h3');
                animateNumber(totalCount, parseInt(totalCount.textContent), allCards.length);
            }

            if (statCards[2]) {
                const pendingCount = statCards[2].querySelector('h3');
                animateNumber(pendingCount, parseInt(pendingCount.textContent), pendingCards.length);
            }
        }

        // Animate Number
        function animateNumber(element, from, to) {
            const duration = 500;
            const steps = 20;
            const stepDuration = duration / steps;
            const increment = (to - from) / steps;
            let current = from;
            let stepCount = 0;

            const timer = setInterval(() => {
                current += increment;
                stepCount++;
                element.textContent = Math.round(current);

                if (stepCount >= steps) {
                    clearInterval(timer);
                    element.textContent = to;
                }
            }, stepDuration);
        }

        // Show Notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} notification-toast`;
            notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    `;

            const icons = {
                success: 'fa-check-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle',
                danger: 'fa-times-circle'
            };

            notification.innerHTML = `
        <i class="fas ${icons[type]} me-2"></i>
        ${message}
    `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Export Quick Stats
        function exportStats() {
            const stats = {
                total: document.querySelectorAll('[data-status]').length,
                pending: document.querySelectorAll('[data-status="pending"]').length,
                approved: document.querySelectorAll('[data-status="approved"]').length,
                rejected: document.querySelectorAll('[data-status="rejected"]').length
            };

            console.log('Statistics:', stats);
            showNotification('Statistics exported successfully', 'success');
        }

        // Filter by Status Quick Action
        function filterByStatus(status) {
            document.getElementById('statusFilter').value = status;
            filterCards();
        }

        // Clear All Filters
        function clearFilters() {
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('typeFilter').value = 'all';
            document.getElementById('sortFilter').value = 'newest';
            document.getElementById('searchInput').value = '';

            filterCards();
            showNotification('All filters cleared', 'info');
        }

        // Export functions for global use
        window.MyContributions = {
            filterCards,
            sortCards,
            viewCard,
            editCard,
            deleteCard,
            confirmDelete,
            exportStats,
            filterByStatus,
            clearFilters
        };

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
        document.head.appendChild(style);
    </script>
@endsection
