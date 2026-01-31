
  <header
      id="header"
      class="header d-flex align-items-center sticky-top bg-body-secondary"
    >
      <div
        class="container-fluid container-xl position-relative d-flex align-items-center"
      >
        <a href="{{route('pages.home')}}" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.webp" alt=""> -->
          <h1 class="sitename">Mentory</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            {{-- ================= GUEST ================= --}}
    @guest
      <li><a href="{{ route('pages.home') }}">HOME</a></li>
      <li><a href="{{ route('pages.teachers') }}">TEACHERS</a></li>
      <li><a href="{{ route('login') }}">LOGIN</a></li>
    @endguest

    {{-- ================= AUTH ================= --}}
    @auth
      @php($role = auth()->user()->role)

      {{-- STUDENT --}}
      @if($role === 'student')
      <li><a href="{{ route('pages.home') }}">HOME</a></li>
        <li><a href="{{ route('pages.teachers') }}">TEACHERS</a></li>
        <li><a href="{{ route('student.requests') }}">My REQUESTS</a></li>
        <li><a href="{{ route('student.favorites') }}">My FAVORITES</a></li>
        <li><a href="{{ route('pages.account') }}">MY ACCOUNT</a></li>

        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nav-link logout-btn">LOGOUT</button>
          </form>
        </li>
      @endif

      {{-- TEACHER --}}
      @if($role === 'teacher')
          <li><a href="{{ route('pages.home') }}">HOME</a></li>
         <li><a href="{{ route('pages.teachers') }}">TEACHERS</a></li>
        <li><a href="{{ route('teacher.dashboard') }}">TEACHER PANEL</a></li>
        <li><a href="{{ route('pages.account') }}">MY ACCOUNT</a></li>

        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nav-link logout-btn">LOGOUT</button>
          </form>
        </li>
      @endif

      {{-- ADMIN  --}}
      @if($role === 'admin')
          <li><a href="{{ route('pages.home') }}">HOME</a></li>
         <li><a href="{{ route('pages.teachers') }}">TEACHERS</a></li>
        <li><a href="{{ route('admin.dashboard') }}">ADMIN PANEL</a></li>
        <li><a href="{{ route('pages.account') }}">MY ACCOUNT</a></li>

        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link logout-btn">LOGOUT</button>
          </form>
        </li>
      @endif
    @endauth
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

       <a class="btn-getstarted" href="https://wa.me/962795717995">
  <i class="bi bi-telephone-fill me-2"></i>0795717995
</a>

      </div>
    </header>