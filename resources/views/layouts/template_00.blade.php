<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Black Horse Technologies" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="keywords" content="Entrenamiento Funcional, Gimnasio, Halterofilia, Pesas" />
    <meta name="description" content="Alpha Venus - Entrenamiento Funcional & Weighlifting" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- title  -->
    <title>Alpha Venus - Functional Training</title>

    <!-- FACEBOOK-->
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Alpha Venus">
    <meta property="og:description" content="Centro de entrenamiento funcional y halterofilia">
    <meta property="og:image" content="{{asset('img/social_media/social_media.jpg')}}">
    <meta property="og:site_name" content="alphavenus.mx">

    <!-- TWITTER-->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="alphavenus.mx" />
    <meta name="twitter:title" content="Alpha Venus" />
    <meta name="twitter:description" content="Centro de entrenamiento funcional y halterofilia" />
    <meta name="twitter:image" content="{{asset('img/social_media/social_media.jpg')}}" />


    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon_package/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon_package/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon_package/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('img/favicon_package/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('img/favicon_package/safari-pinned-tab.svg')}}" color="#000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="theme-color" content="#ffffff">



    <!-- libraries -->
    <link rel="stylesheet" href="{{asset('libraries/bootstrap-5.3.0/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('libraries/fontawesome-free-6.2.1/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/template_00.css')}}">


    @yield('css')

</head>

<body>
<div id="preloader"></div>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{asset('/')}}">ALPHA VENUS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{asset('/')}}">Regresar a Pagina</a>
                </li>

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         {{ Auth::user()->nombre }} {{ Auth::user()->apellidoPaterno }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="main-wrapper">

    @yield('content')

</div>

@yield('modal')


<script type='text/javascript' src='{{ asset('libraries/jquery-3.6.0/jquery-3.6.0.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('libraries/jquery-3.6.0/jquery-migrate-3.3.2.min.js') }}'></script>
<script src="{{asset('libraries/bootstrap-5.3.0/js/bootstrap.bundle.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('libraries/bootbox-v6.0.0/bootbox.all.js') }}"></script>

<script type="text/javascript" src="{{ asset('libraries/jquery-validation-1.19.5/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/jquery-validation-1.19.5/additional-methods.min.js') }}"></script>


<script type='text/javascript' src='{{ asset('js/template_00.js') }}'></script>



@yield('javascript')

</body>

</html>
