<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from designing-world.com/affan-v1.7/hero-blocks.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 Nov 2024 08:03:25 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <title>| {{ env('APP_NAME') }}</title>

    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="manifest" href="manifest.json">
</head>

<body>
    {{-- <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div> --}}

    <div class="internet-connection-status" id="internetStatus"></div>

    @yield('content')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/slideToggle.min.js') }}"></script>
    <script src="{{ asset('js/internet-status.js') }}"></script>
    <script src="{{ asset('js/tiny-slider.js') }}"></script>
    <script src="{{ asset('js/venobox.min.js') }}"></script>
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('js/vanilla-dataTables.min.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/dark-rtl.js') }}"></script>
    <script src="{{ asset('js/active.js') }}"></script>
    {{-- <script src="{{ asset('js/pwa.js') }}"></script> --}}

    @yield('scripts')
</body>

</html>
