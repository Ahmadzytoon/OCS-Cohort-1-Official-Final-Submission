    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="container-fluid container-xl position-relative d-flex align-items-center
            justify-content-center">

            <a href="{{ route('site.index') }}" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.webp" alt=""> -->
                <h1 class="sitename">Arsha</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('site.index') }}" class="active">Home</a></li>
                    <li><a href="{{ route('site.solution') }}">Solution</a></li>
                    <li><a href="{{ route('site.knowledgeModel') }}">Knowledge Model</a></li>
                    <li><a href="{{ route('site.about') }}">About </a></li>
                    <li><a href="{{ route('site.faq') }}">FAQs </a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('site.loging.choose') }}">Get Started</a>

        </div>
    </header>
