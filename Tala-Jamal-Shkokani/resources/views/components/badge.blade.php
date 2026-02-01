@props(['type' => 'soft'])

<span {{ $attributes->merge(['class' => 'badge badge-' . $type]) }}>
    {{ $slot }}
</span>