{{-- Footer Section (من القالب) --}}
@yield('footer')

<!-- Bootstrap Bundle JS (ضروري للـ navbar toggler) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template JS -->
<script src="{{ asset('js/script.js') }}"></script>

@yield('script')
