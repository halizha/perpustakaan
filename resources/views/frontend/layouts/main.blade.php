<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Perpustakaan')</title>
    <link rel="icon" href="data:,">


    {{--<link href="{{ asset('assets/estartup/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/estartup/img/apple-touch-icon.png') }}" rel="apple-touch-icon">--}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <link href="{{ asset('assets/estartup/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/estartup/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/estartup/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/estartup/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/estartup/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

    @yield('content')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader"></div>

    <script src="{{ asset('assets/estartup/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/estartup/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/estartup/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/estartup/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/estartup/js/main.js') }}"></script>
</body>

</html>
