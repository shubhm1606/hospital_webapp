<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hospital</title>

    <!-- Favicons -->
    <link href="http://localhost/laravel_setup/public/img/hospitalLogo.png" rel="icon">
    <link href="http://localhost/laravel_setup/public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="http://localhost/laravel_setup/public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/laravel_setup/public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="http://localhost/laravel_setup/public/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="http://localhost/laravel_setup/public/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="http://localhost/laravel_setup/public/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="http://localhost/laravel_setup/public/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="http://localhost/laravel_setup/public/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Template Main CSS File -->
    <link href="http://localhost/laravel_setup/public/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        @if(Auth::check()) {{-- Check if user is authenticated --}}
        @include('layouts.navbar')
        @include('layouts.sidebar')
        @endif

        <main class="py-4">
            @yield('content')
        </main>

        @if(Auth::check())
        @include('layouts.footer')
        @endif
    </div>

    <script src="http://localhost/laravel_setup/public/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/echarts/echarts.min.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/quill/quill.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="http://localhost/laravel_setup/public/assets/vendor/php-email-form/validate.js"></script>

    <!-- Add Print.js from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Template Main JS File -->
    <script src="http://localhost/laravel_setup/public/assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @stack('scripts')
</body>

</html>