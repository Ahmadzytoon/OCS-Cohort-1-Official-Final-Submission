<div>
    <h4 class="mb-2">{{ $entry->title }}</h4>

    <div class="mb-3 text-muted">
        <span class="me-3"><i class="fas fa-building"></i> {{ $entry->department?->name ?? '—' }}</span>
        <span class="me-3"><i class="fas fa-user"></i> {{ $entry->author?->name ?? '—' }}</span>
        <span><i class="fas fa-clock"></i>
            {{ optional($entry->approved_at ?? $entry->created_at)->diffForHumans() }}</span>
    </div>

    <hr>

    <h6 class="mb-2"><i class="fas fa-align-left text-warning"></i> Full Details</h6>
    <p class="mb-3">{{ $entry->summary }}</p>

    @if (!empty($entry->content))
        <h6 class="mb-2"><i class="fas fa-file-alt text-primary"></i> Content</h6>
        <div class="border rounded p-3 mb-3">{!! nl2br(e($entry->content)) !!}</div>
    @endif

    @if (!empty($attachments) && count($attachments))
        <h6 class="mb-2"><i class="fas fa-paperclip text-secondary"></i> Attachments</h6>
        <ul class="list-group">
            @foreach ($attachments as $att)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $att['original_name'] ?? 'File' }}</strong>
                        <div class="small text-muted">{{ $att['type'] }}</div>
                    </div>
                    @if ($att['url'])
                        <a class="btn btn-sm btn-outline-primary" href="{{ $att['url'] }}" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> Open
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    @if ($entry->tags?->count())
        <div class="mt-3">
            @foreach ($entry->tags as $tag)
                <span class="badge bg-light text-dark border">{{ $tag->name }}</span>
            @endforeach
        </div>
    @endif
</div>
