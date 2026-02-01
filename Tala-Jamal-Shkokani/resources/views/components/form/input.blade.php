@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'autofocus' => false, 'autocomplete' => ''])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="small text-muted text-uppercase ls-1 mb-2 d-block fw-semibold">{{ $label }}</label>
    @endif
    <input id="{{ $name }}" type="{{ $type }}"
        class="form-control border-0 bg-light p-3 rounded-4 @error($name) is-invalid @enderror" name="{{ $name }}"
        value="{{ $value ?: old($name) }}" {{ $required ? 'required' : '' }} {{ $autofocus ? 'autofocus' : '' }}
        autocomplete="{{ $autocomplete }}" {{ $attributes }}>
    @error($name)
        <div class="text-danger extra-small mt-2 fw-bold text-uppercase ls-1" style="font-size: 0.7rem;">{{ $message }}
        </div>
    @enderror
</div>