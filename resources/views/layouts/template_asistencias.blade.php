<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Black Horse Technologies" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="keywords" content="Alpha Venus, Asistencias, Entrenamiento Funcional, Gimnasio, Halterofilia, Pesas" />
    <meta name="description" content="Registro de asistencia - Alpha Venus" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Alpha Venus - Registro de Asistencia')</title>

    <!-- FACEBOOK -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Alpha Venus - Registro de Asistencia">
    <meta property="og:description" content="Confirma tu llegada de forma rápida y sencilla en Alpha Venus.">
    <meta property="og:image" content="{{ asset('img/social_media/social_media.jpg') }}">
    <meta property="og:site_name" content="alphavenus.mx">

    <!-- TWITTER -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="alphavenus.mx" />
    <meta name="twitter:title" content="Alpha Venus - Registro de Asistencia" />
    <meta name="twitter:description" content="Confirma tu llegada de forma rápida y sencilla en Alpha Venus." />
    <meta name="twitter:image" content="{{ asset('img/social_media/social_media.jpg') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon_package/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon_package/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon_package/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon_package/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('img/favicon_package/safari-pinned-tab.svg') }}" color="#000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="theme-color" content="#7B53B3">

    <!-- libraries -->
    <link rel="stylesheet" href="{{ asset('libraries/bootstrap-5.3.0/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libraries/fontawesome-free-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template_00.css') }}">

    <!-- attendance public css -->
    <link rel="stylesheet" href="{{ asset('css/template_asistencias.css') }}">

    @yield('css')
</head>

<body>
<nav class="navbar navbar-expand-lg attendance-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ asset('/') }}">
            <img src="{{ asset('img/logos/logo-light.png') }}" alt="Alpha Venus" class="attendance-navbar-logo">
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#attendanceNavbar" aria-controls="attendanceNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="attendanceNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ asset('/') }}">
                        <i class="fa-solid fa-house me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" href="{{ route('asistencia.index') }}">
                        <i class="fa-solid fa-check-to-slot me-1"></i>Registrar asistencia
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="attendance-page">
    <div class="container attendance-shell">
        @yield('content')
    </div>
</main>

@yield('modal')

<script type='text/javascript' src='{{ asset('libraries/jquery-3.6.0/jquery-3.6.0.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('libraries/jquery-3.6.0/jquery-migrate-3.3.2.min.js') }}'></script>
<script src="{{ asset('libraries/bootstrap-5.3.0/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bootbox-v6.0.0/bootbox.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/jquery-validation-1.19.5/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/jquery-validation-1.19.5/additional-methods.min.js') }}"></script>
<script type='text/javascript' src='{{ asset('js/template_00.js') }}'></script>

@yield('javascript')
</body>
</html>