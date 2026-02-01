<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary-custom px-5 py-3 rounded-full text-uppercase ls-1 fw-bold border-0 shadow-sm transition-premium hover-scale']) }}>
    {{ $slot }}
</button>