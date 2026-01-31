<!DOCTYPE html>
<html lang="en">
@include('site.layout.head')

<body class="index-page">

    @include('site.layout.header')
    <main class="main ">

        @yield('content')

    </main>


    @if (Route::is('login.create', 'signup.create', 'accessRequest.create', 'register'))
        <div class="container m-5 p-5">
            @yield('content_forms')
        </div>
    @endif


    @include('site.layout.footer')
</body>

</html>
