
@extends('photographer.layout')
    @section('styles')
<style>
   
</style>
@endsection

@section('content')
 {{-- Main Content --}}
        <main class="main-content">
            @yield('content')
        </main>
@endsection




@section('content')
<!-- كل HTML تبع bookings (بدون head/body/doctype) -->
<header class="page-header"> ... </header>
<main class="main-content"> ... </main>
@endsection
