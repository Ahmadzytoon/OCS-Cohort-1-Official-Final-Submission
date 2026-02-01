<div class="mb-3">
    <span class="badge bg-warning text-dark me-2">{{ strtoupper($entry->status) }}</span>
    <span class="badge bg-secondary">{{ $entry->type }}</span>
</div>

<h4 class="mb-3 fw-bold">{{ $entry->title }}</h4>
<p class="text-muted mb-4">{{ $entry->summary }}</p>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-user-circle text-primary me-2 fs-5"></i>
                    <small class="text-muted text-uppercase">Author</small>
                </div>
                <h6 class="mb-1">{{ $entry->author?->name }}</h6>
                <small class="text-muted">{{ $entry->author?->email }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-building text-primary me-2 fs-5"></i>
                    <small class="text-muted text-uppercase">Department</small>
                </div>
                <h6 class="mb-1">{{ $entry->department?->name }}</h6>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    {{ optional($entry->submitted_at)->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <div class="d-flex align-items-center mb-3">
        <i class="fas fa-file-alt text-primary me-2"></i>
        <h5 class="mb-0">Content</h5>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body bg-light">
            <p class="mb-0">{!! nl2br(e($entry->content)) !!}</p>
        </div>
    </div>
</div>

@if(!empty($entry->extra))
    <div class="mb-4">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-info-circle text-primary me-2"></i>
            <h5 class="mb-0">Extra Details</h5>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            @foreach($entry->extra as $key => $value)
                                <tr>
                                    <td class="text-muted fw-bold" style="width: 30%;">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    <td>
                                        @if(is_array($value))
                                            <span class="badge bg-secondary me-1">{{ implode(', ', $value) }}</span>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

@if($attachments->count())
    <div class="mb-3">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-paperclip text-primary me-2"></i>
            <h5 class="mb-0">Attachments ({{ $attachments->count() }})</h5>
        </div>
        <div class="card border-0 shadow-sm">
            <ul class="list-group list-group-flush">
                @foreach($attachments as $att)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded p-2">
                                <i class="fas fa-file text-primary fs-5"></i>
                            </div>
                            <div>
                                @if($att['url'])
                                    <a href="{{ $att['url'] }}" target="_blank" class="text-decoration-none fw-semibold">
                                        {{ $att['original_name'] }}
                                    </a>
                                @else
                                    <span class="fw-semibold">{{ $att['original_name'] }}</span>
                                @endif
                                <div>
                                    <span class="badge bg-light text-dark border mt-1">{{ $att['type'] }}</span>
                                </div>
                            </div>
                        </div>
                        @if($att['url'])
                            <a href="{{ $att['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download me-1"></i> Download
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <small class="text-muted d-block mt-2">
            <i class="fas fa-info-circle me-1"></i>
            Click file name to open in a new tab.
        </small>
    </div>
@endif
