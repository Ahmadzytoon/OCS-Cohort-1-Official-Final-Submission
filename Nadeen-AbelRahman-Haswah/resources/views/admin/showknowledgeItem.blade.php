@extends('admin.layout.master')

@section('title', 'Knowledge Item')

@section('content')
    <div class="page-inner">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">{{ $item->title }}</h4>
                <a href="{{ route('admin.knowledgeItems.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Category:</strong> {{ $item->type }}</div>
                    <div class="col-md-3"><strong>Status:</strong> {{ $item->status }}</div>
                    <div class="col-md-3"><strong>Company:</strong> {{ $item->company?->workspace_name }}</div>
                    <div class="col-md-3"><strong>Department:</strong> {{ $item->department?->name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Created By:</strong> {{ $item->author?->name }}
                        ({{ $item->author?->email }})</div>
                    <div class="col-md-6"><strong>Submitted At:</strong>
                        {{ optional($item->submitted_at)->format('Y-m-d H:i') ?? '-' }}</div>
                </div>

                <hr>

                <h5>Summary</h5>
                <p>{{ $item->summary }}</p>

                <h5>Main Content</h5>
                <div class="border rounded p-3">
                    {!! nl2br(e($item->content)) !!}
                </div>

                <hr>

                <h5>Extra (Type Fields)</h5>
                @if (!empty($item->extra))
                    <pre class="bg-light p-3 rounded">{{ json_encode($item->extra, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                @else
                    <p class="text-muted">No extra fields.</p>
                @endif

                <hr>

                <h5>Tags</h5>
                @if ($item->tags->count())
                    @foreach ($item->tags as $tag)
                        <span class="badge bg-info">{{ $tag->name }}</span>
                    @endforeach
                @else
                    <p class="text-muted">No tags.</p>
                @endif

                <hr>

                <h5>Attachments</h5>
                @if ($item->attachments->count())
                    <ul class="list-group">
                        @foreach ($item->attachments as $att)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $att->type }}</strong>
                                    <div class="text-muted small">{{ $att->original_name ?? ($att->url ?? $att->path) }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No attachments.</p>
                @endif
            </div>
        </div>

    </div>
@endsection
