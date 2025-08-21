<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Perpustakaan')</title>
    <link rel="icon" href="data:,">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



    <style>
        body {
            background-color: #f8f9fa;
        }

        footer {
            background: #343a40;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>


<body>
    {{-- Navbar --}}


    {{-- Konten --}}


    @yield('content')


    {{-- <footer>
        <p class="mb-0">© {{ date('Y') }} Perpustakaan SMA Negeri 1</p>
    </footer> --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
