<div class="mb-3">
    <h4 class="mb-1">{{ $entry->title }}</h4>
    <div class="text-muted">
        <span class="me-3"><i class="fas fa-building"></i> {{ $entry->department?->name ?? '—' }}</span>
        <span class="me-3"><i class="fas fa-user"></i> {{ $entry->author?->name ?? '—' }}</span>
        <span><i class="fas fa-clock"></i>
            {{ optional($entry->approved_at ?? $entry->created_at)->diffForHumans() }}</span>
    </div>
</div>

<hr>

<div class="mb-3">
    <h6 class="fw-bold"><i class="fas fa-align-left text-primary me-1"></i> Summary</h6>
    <p class="mb-0">{{ $entry->summary ?: '—' }}</p>
</div>

<div class="mb-3">
    <h6 class="fw-bold"><i class="fas fa-file-alt text-success me-1"></i> Full Content</h6>
    <div class="p-3 bg-light rounded">
        {!! nl2br(e($entry->content ?? '—')) !!}
    </div>
</div>

@if ($entry->tags?->count())
    <div class="mb-3">
        <h6 class="fw-bold"><i class="fas fa-tags text-warning me-1"></i> Tags</h6>
        <div>
            @foreach ($entry->tags as $tag)
                <span class="skill-tag">{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>
@endif

@if ($entry->attachments?->count())
    <div class="mb-2">
        <h6 class="fw-bold"><i class="fas fa-paperclip text-secondary me-1"></i> Attachments</h6>
        <ul class="list-group">
            @foreach ($entry->attachments as $att)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file me-2"></i>
                        {{ $att->original_name ?? $att->path }}
                        <span class="badge bg-light text-dark ms-2">{{ $att->type }}</span>
                    </div>
                    @php
                        $url = $att->path ? Storage::disk('public')->url($att->path) : null;
                    @endphp
                    @if ($url)
                        <a class="btn btn-sm btn-outline-primary" href="{{ $url }}" target="_blank">
                            View
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
