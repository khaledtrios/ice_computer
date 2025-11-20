<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Admin dashboard for managing client quotes and appointments." />
    <meta name="keywords" content="admin template, dashboard, quotes, appointments, responsive" />
    <meta name="author" content="pixelstrap" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}" />
    <link rel="icon" href="{{asset('frontend/assets/media/logo.png')}}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Model-Itech</title>
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

    <style>
        .step-card {
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
            transition: transform 0.3s ease !important;
        }

        .step-card:hover {
            transform: translateY(-5px) !important;
        }

        .step-header {
            background: linear-gradient(135deg, #46D8D5, #00d4ff) !important;
            color: white !important;
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
        }

        .select-card {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .select-card:hover {
            border-color: #46D8D5;
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.2);
        }

        .select-card.selected {
            border-color: #28a745;
            background-color: #e9f7ef;
        }

        .select-img {
            height: 150px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .nav-tabs .nav-link {
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px 8px 0 0;
        }

        .nav-tabs .nav-link.active {
            background-color: #46D8D5;
            color: white;
            border-color: #46D8D5;
        }

        .btn-primary {
            background-color: #46D8D5;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #46D8D5;
        }

        .alert-success {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .fade-enter-active,
        .fade-leave-active {
            transition: opacity 0.3s ease;
        }

        .fade-enter-from,
        .fade-leave-to {
            opacity: 0;
        }
    </style>
    <style scoped>
        .cursor-pointer {
            cursor: pointer;
        }

        /* Style général du switch */
        .form-check-input {
            width: 3rem;
            height: 1.5rem;
            background-color: #dee2e6;
            border: 1px solid #ced4da;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            /* Required for ::before positioning */
            appearance: none;
            /* Remove default checkbox appearance */
            border-radius: 0.75rem;
            /* Rounded edges for toggle */
        }

        /* Position du rond à l'intérieur (par défaut OFF) */
        .form-check-input::before {
            content: "";
            display: block;
            width: 1.2rem;
            height: 1.2rem;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 0.15rem;
            left: 0.2rem;
            transition: transform 0.3s ease;
        }

        /* Quand le switch est activé (ON) */
        .form-check-input:checked {
            background-color: #46D8D5;
            border-color: #46D8D5;
        }

        /* Rond en position droite (ON) */
        .form-check-input:checked::before {
            transform: translateX(1.4rem);
        }

        /* Supprimer l'ombre bleue par défaut */
        .form-check-input:focus {
            box-shadow: none;
            outline: none;
        }

        /* Label styling */
        .form-check-label {
            margin-left: 0.5rem;
            font-size: 1rem;
            color: #333;
        }

        /* Disabled input styling */
        .form-control:disabled {
            background-color: #f8f8f8;
            opacity: 0.7;
        }

        /* Card styling */
        .card-body {
            padding: 1rem;
        }
    </style>
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
        @include('boutique.layouts.navbar')
        <!-- Page Body -->
        <div class="page-body-wrapper">
            <!-- Sidebar -->
            @include('boutique.layouts.sidebar')
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