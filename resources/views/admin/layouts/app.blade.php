<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Admin dashboard for managing client quotes and appointments." />
    <meta name="keywords" content="admin template, dashboard, quotes, appointments, responsive" />
    <meta name="author" content="pixelstrap" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/media/logo.png') }}">
    <!-- Crée une version 16x16 si besoin -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ice-Computer</title>
    <link
        href="https://fonts.googleapis.com/css?family=Rubik:400,500,700&family=Roboto:300,400,500,700,900&display=swap"
        rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}}" />
    <!-- Feather icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/feather-icon.css')}}" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/bootstrap.css')}}" />
    <!-- DataTables css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/jquery.dataTables.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select.bootstrap5.css')}}" />
    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
    <link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}}" media="screen" />
    <!-- Responsive css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/vue@3.2.47/dist/vue.global.min.js"></script>

    @yield('css')

</head>

<body>
    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="11" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </feColorMatrix>
            </filter>
        </svg>
    </div>
    <!-- Tap on top -->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- Page wrapper -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header -->
        <!-- Page Header -->
        @include('admin.layouts.navbar')
        <!-- Page Body -->
        <div class="page-body-wrapper">
            <!-- Sidebar -->
            @include('admin.layouts.sidebar')
            <!-- Page Content -->
            @yield('content')
        </div>
        @include('boutique.layouts.footer')
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Scripts -->
    <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <script src="{{asset('assets/js/scrollbar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/js/scrollbar/custom.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>
    <script src="{{asset('assets/js/theme-customizer/customizer.js')}}"></script>
    <!-- Custom DataTables Initialization -->
    @yield('js')
</body>

</html>