<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="admin, dashboard, template, responsive" />
    <meta name="author" content="pixelstrap" />
    <link rel="icon" href="{{asset('frontend/assets/media/logo.png')}}" type="image/x-icon" />
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="language" content="fr">
    @yield('meta')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">

    <!-- Font Awesome (CDN version stable) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Icon Fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/themify.css') }}">
    <link rel=" stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel=" stylesheet" href="{{ asset('assets/css/vendors/feather-icon.css') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/bootstrap.css') }}">

    <!-- App Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel=" stylesheet" href="{{ asset('assets/css/color-1.css') }}" id=" color" media="screen">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    {{-- Vite (si utilisé) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>

<body>
    <div class="container-fluid p-0">
        @include('sweetalert::alert')
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- Feather Icons -->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- Config -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Theme Scripts -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/script1.js') }}"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

    @yield('scripts')
</body>

</html>