@props(['type' => 'success'])

<div {{ $attributes->merge(['class' => 'alert alert-' . $type . ' border-0 shadow-sm animate-fade-in']) }}
    style="border-radius: 12px; @if($type === 'success') background: rgba(25, 135, 84, 0.1); color: #198754; @endif">
    <div class="d-flex align-items-center">
        @if($type === 'success')
            <i class="fa-solid fa-circle-check me-2"></i>
        @elseif($type === 'danger')
            <i class="fa-solid fa-circle-exclamation me-2"></i>
        @endif
        <div>{{ $slot }}</div>
    </div>
</div>