<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Restoran - Bootstrap Restaurant Template')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="@yield('keywords', '')" name="keywords">
    <meta content="@yield('description', '')" name="description">

    <!-- Favicon -->
    <link href="{{ asset('asset_landing/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('asset_landing/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_landing/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_landing/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('asset_landing/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('asset_landing/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Header Include -->
    @include('layouts.landing_page.sidenav')

    <!-- Content Section -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Include -->
    @include('layouts.landing_page.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Aktifkan no-conflict mode
        var $j = jQuery.noConflict();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset_landing/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('asset_landing/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('asset_landing/js/main.js') }}"></script>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>
