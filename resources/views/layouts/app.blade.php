<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Foresight</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('theme/assets/images/logo/logo.jpg')}}" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{asset('theme/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/assets/css/LineIcons.3.0.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/assets/css/tiny-slider.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/assets/css/glightbox.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/assets/css/main.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{asset('theme/assets/css/rtl.css')}}" />
    @endif
    <style>
        .navbar-nav .nav-item {
            margin-left: 15px; /* Adds spacing in LTR */
            margin-right: 15px; /* Adds spacing in RTL */
        }

        .navbar-nav .nav-item a {
            padding: 25px 15px; /* Adjusts padding inside the links */
        }

        html[lang="ar"] .navbar-nav .nav-item {
            margin-left: 0; /* Removes left margin in RTL */
        }

        #searchResults {
            list-style-type: none;
            padding: 0;
            margin: 0;
            background: white;
            border: 1px solid #ddd;
        }

        #searchResults li {
            padding: 10px;
            cursor: pointer;
        }

        #searchResults li:hover {
            background-color: #f5f5f5;
        }


    </style>
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-left">
                            <ul class="menu-top-link">
                                <li>
                                    <div class="select-position">
                                        <!-- Language Switcher -->
                                        <div class="language-switcher">
                                            <select id="languageSwitcher" class="custom-dropdown" onchange="window.location.href=this.value;">
                                                <option value="{{ LaravelLocalization::getLocalizedURL('en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                                                <option value="{{ LaravelLocalization::getLocalizedURL('ar') }}" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>العربية</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('lang.menu_home') }}</a></li>
                                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('lang.menu_about') }}</a></li>
                                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('lang.menu_contact') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            <div class="user">
                                <ul class="user-login">
                                    <i class="lni lni-user"></i>
                                    {{ __('lang.header_user_greeting') }}:
                                    @auth
                                        <div class="dropdown d-inline">
                                            <a class="dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ Auth::user()->name }}
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                                @if (Auth::user()->category == 'admin')
                                                    <li><a class="dropdown-item text-dark" href="{{ route('dashboard') }}">{{ __('lang.dashboard') }}</a></li>
                                                @endif
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>

                                                <li>
                                                    <a class="dropdown-item text-dark" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        {{ __('lang.logout') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endauth
                                </ul>
                            </div>

                            @if (!Auth::user())
                                <ul class="user-login">
                                    <li>
                                        <a href="{{ route('login') }}">{{ __('lang.header_sign_in') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}">{{ __('lang.header_register') }}</a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->

        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('theme/assets/images/logo/logo.jpg') }}" style="height: 80px !impprtant; width:80px !important" alt="Logo">
                        </a>
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <div class="main-menu-search">
                            <div class="navbar-search search-style-5">
                                {{-- <div class="search-select">
                                    <div class="select-position">
                                        <select id="searchCategory">
                                            <option value="">{{ __('lang.all') }}</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="search-input">
                                    <input type="text" id="searchInput" placeholder="{{ __('lang.search_placeholder') }}" autocomplete="off">
                                </div>
                                <div class="search-btn">
                                    <button><i class="lni lni-search-alt"></i></button>
                                </div>
                                <!-- Search Results Dropdown -->
                                <ul id="searchResults" class="dropdown-menu" style="display: none; position: absolute; width: 100%; z-index: 1000;">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>{{ __('lang.hotline') }}:
                                    <span  dir="ltr">(+20) 0100 4345405</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->

        <!-- Start Header Bottom -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>{{ __('lang.all_categories') }}</span>
                            <ul class="sub-category">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                            {{ app()->getLocale() === 'ar' ? $category->ar_name : $category->en_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('lang.menu_home') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">{{ __('lang.menu_products') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="nav-social">
                        <h5 class="title">{{ __('lang.follow_us') }}:</h5>
                        <ul>
                            <li><a href="https://www.facebook.com/laboratoriopyam"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="https://www.instagram.com/laboratoriopyam/"><i class="lni lni-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
    </header>
    <!-- End Header Area -->

    @yield('content')

    <!-- Start Footer Area -->
    <footer class="footer">
        <!-- Start Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="footer-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('theme/assets/images/logo/white-logo.svg') }}" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <div class="footer-newsletter">
                                <h4 class="title">
                                    {{ __('lang.footer_newsletter_title') }}
                                    <span>{{ __('lang.footer_newsletter_subtitle') }}</span>
                                </h4>
                                <div class="newsletter-form-head">
                                    <form action="" class="newsletter-form">
                                        <input name="EMAIL" placeholder="{{ __('lang.footer_newsletter_placeholder') }}" type="email">
                                        <div class="button">
                                            <button class="btn">{{ __('lang.footer_newsletter_subscribe') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Top -->

        <!-- Start Footer Middle -->
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>{{ __('lang.footer_contact_title') }}</h3>
                                <p class="phone">Mobile: 002 0100 4345405</p>
                                <ul>
                                    <li><span>{{ __('lang.footer_contact_hours_weekdays') }}: </span> 9:00 AM - 8:00 PM</li>
                                    <li><span>{{ __('lang.footer_contact_hours_weekend') }}: </span> 10:00 AM - 6:00 PM</li>
                                </ul>
                                <p class="mail">
                                    <a href="mailto:Whitetiger.pyam@gmail.com">Whitetiger.pyam@gmail.com</a>
                                </p>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>{{ __('lang.footer_links_title') }}</h3>
                                <ul>
                                    <li><a href="{{ route('home') }}">{{ __('lang.menu_home') }}</a></li>
                                    <li><a href="{{ route('products.index') }}">{{ __('lang.menu_products') }}</a></li>
                                    <li><a href="{{ route('about') }}">{{ __('lang.menu_about') }}</a></li>
                                    <li><a href="{{ route('contact') }}">{{ __('lang.menu_contact') }}</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>{{ __('lang.footer_categories_title') }}</h3>
                                <ul>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                                {{ app()->getLocale() === 'ar' ? $category->ar_name : $category->en_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-social">
                                <h3>{{ __('lang.footer_follow_us') }}</h3>
                                <ul class="socila d-flex">
                                    <li class="p-2"><a href="https://www.facebook.com/laboratoriopyam"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li class="p-2"><a href="https://www.instagram.com/laboratoriopyam/"><i class="lni lni-instagram"></i></a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->

        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
                                <span>{{ __('lang.footer_payment_methods') }}:</span>
                                <img src="{{ asset('theme/assets/images/footer/credit-cards-footer.png') }}" alt="#">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>{{ __('lang.footer_copyright') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            {{-- <ul class="socila d-flex">
                                <li>
                                    <span>{{ __('lang.footer_follow_us') }}:</span>
                                </li>
                                <li><a href="https://www.facebook.com/laboratoriopyam"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="https://www.instagram.com/laboratoriopyam/"><i class="lni lni-instagram"></i></a></li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{asset('theme/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/tiny-slider.js')}}"></script>
    <script src="{{asset('theme/assets/js/glightbox.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        //========= Hero Slider
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
        });

        //======== Brand Slider
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });

    </script>
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value;
            const resultsDropdown = document.getElementById('searchResults');

            if (query.length > 2) {
                fetch(`/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsDropdown.innerHTML = ''; // Clear previous results
                        resultsDropdown.style.display = 'block';

                        if (data.length > 0) {
                            data.forEach(product => {
                                const listItem = document.createElement('li');
                                listItem.className = 'dropdown-item p-0'; // Add padding to parent list item for cleaner appearance

                                // Display the name based on locale (using a backend-provided global JS variable for locale)
                                const locale = document.documentElement.lang || 'en'; // Assuming `lang` attribute is set on <html>
                                const productName = locale === 'ar' ? product.ar_name : product.en_name;

                                listItem.innerHTML = `
                                    <button
                                        onclick="window.location.href='/product/details/${product.id}'"
                                        class="btn btn-link text-start w-100"
                                    >
                                        ${productName}
                                    </button>
                                `;
                                resultsDropdown.appendChild(listItem);
                            });
                        } else {
                            resultsDropdown.innerHTML = `<li class="dropdown-item text-center">No results found</li>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            } else {
                resultsDropdown.style.display = 'none';
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!document.querySelector('.navbar-search').contains(e.target)) {
                document.getElementById('searchResults').style.display = 'none';
            }
        });
    </script>
    @stack('js')
</body>

</html>
