<!DOCTYPE html>
<html lang="en">
@include('site.innerPages.layout.head')

<body>

    @include('site.innerPages.layout.sidebar')

    <div class="main-wrapper">

        @include('site.innerPages.layout.header')

        <div class="main-content">
            @yield('content')
        </div>

    </div>

    @include('site.innerPages.layout.scripts')

</body>

</html>
