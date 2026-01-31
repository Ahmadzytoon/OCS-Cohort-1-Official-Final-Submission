@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
    $class = $variant === 'primary' ? 'btn-primary-custom' : ($variant === 'secondary' ? 'btn-secondary-custom' : 'btn-' . $variant);
    $sizeClass = $size === 'lg' ? 'btn-lg' : ($size === 'sm' ? 'btn-sm' : '');
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => 'btn ' . $class . ' ' . $sizeClass]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn ' . $class . ' ' . $sizeClass]) }}>
        {{ $slot }}
    </button>
@endif