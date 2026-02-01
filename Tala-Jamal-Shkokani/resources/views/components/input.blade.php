@props(['label' => null, 'name', 'type' => 'text', 'value' => '', 'placeholder' => ''])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--color-soft-gray);">
            {{ $label }}
        </label>
    @endif
    
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-control border-0 shadow-sm px-3 py-2']) }}
        style="background: rgba(0,0,0,0.02); border-radius: 10px;"
    >
    
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
