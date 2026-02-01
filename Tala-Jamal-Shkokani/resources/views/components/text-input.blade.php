@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'form-control search-input bg-light border-0 px-4 py-3 rounded-pill shadow-inner-sm text-dark']) }}>