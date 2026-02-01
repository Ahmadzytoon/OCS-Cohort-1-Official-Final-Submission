<!DOCTYPE html>
<html lang="en">

@include('admin.layout.head')

<body>
    <div class="wrapper">

        @include('admin.layout.sidebar')

        <div class="main-panel">

            @include('admin.layout.header')

            <div class="container">
                @yield('content')
            </div>

            @include('admin.layout.footer')
        </div>

    </div>
    @include('admin.layout.scripts')

</body>
</html>
