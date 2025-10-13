<!DOCTYPE html>
<html lang="ar" dir="rtl" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', config('app.name'))</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', config('app.name'))">
    <meta name="keywords" content="@yield('keywords', 'متجر إلكتروني, منتجات عضوية')">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('themes/torganic/assets/images/favicon.png') }}" type="image/x-icon">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/style.css') }}">
    
    <!-- Custom Styles for RTL -->
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
        .menu-section--style-2 {
            direction: rtl;
        }
        .trk-btn {
            direction: rtl;
        }
        /* Additional RTL adjustments */
        .swiper-button-next {
            left: 10px;
            right: auto;
        }
        .swiper-button-prev {
            right: 10px;
            left: auto;
        }
    </style>
    
    @stack('styles')
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('themes/torganic/assets/images/logo/preloader.png') }}" alt="preloader icon">
    </div>

    <!-- Header -->
    @include('themes.torganic.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('themes.torganic.partials.footer')

    <!-- Scroll to Top -->
    <a href="#" class="scrollToTop scrollToTop--style1">
        <i class="fa-solid fa-arrow-up-from-bracket"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('themes/torganic/assets/js/metismenujs.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/all.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/aos.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/fslightbox.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/trk-menu.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/custom.js') }}"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
    
    @stack('scripts')
</body>

</html>