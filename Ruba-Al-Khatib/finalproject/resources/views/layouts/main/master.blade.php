<!DOCTYPE html>
<html lang="en">
@include('layouts.main.head')

<body>
    @if (!request()->is('signup*') && !request()->is('login*'))
    @include('layouts.main.navbar')
    @endif


    @yield('content')
    {{-- بدل @yield('footer') --}}
    @hasSection('footer')
    @yield('footer')
    @else
    @include('layouts.main.footer')
    @endif

    @yield('script')

</body>

</html>