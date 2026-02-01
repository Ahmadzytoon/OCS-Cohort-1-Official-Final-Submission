    <!-- Header Top section start -->
    <div class="header-top-section">
        <div class="container-fluid">
            <div class="header-top-wrapper">
                <ul class="contact-list">
                    <li>
                        <i class="fa-brands fa-facebook-f"></i>
                        7500k Followers
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+40276328246">+402 763 282 46</a>
                    </li>
                </ul>
                <div class="flag-wrapper">
                    <div class="flag-wrap">
                        <div class="nice-select" tabindex="0">
                            <span class="current">
                                English
                            </span>
                            <ul class="list">
                                <li data-value="1" class="option selected focus">
                                    English
                                </li>
                                <li data-value="1" class="option">
                                    Bangla
                                </li>
                                <li data-value="1" class="option">
                                    German
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flag-wrap">
                        <div class="nice-select style-2" tabindex="0">
                            <span class="current">
                                $Usd
                            </span>
                            <ul class="list">
                                <li data-value="1" class="option selected focus">
                                    $Usd
                                </li>
                                <li data-value="1" class="option">
                                    €Eur
                                </li>
                                <li data-value="1" class="option">
                                    ¥Jpy
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        @guest
                            <button id="openButton" class="account-text d-flex align-items-center gap-2">
                                <i class="fa-regular fa-user"></i>
                                Log in
                            </button>
                        @else
                            <a href="{{ route('user.profile') }}" class="account-text d-flex align-items-center gap-2">
                                <i class="fa-regular fa-user"></i>
                                {{ auth()->user()->name }}
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
