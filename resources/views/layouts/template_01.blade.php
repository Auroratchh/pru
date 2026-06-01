<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Black Horse Technologies" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="keywords" content="Entrenamiento Funcional, Gimnasio, Halterofilia, Pesas" />
    <meta name="description" content="Alpha Venus - Entrenamiento Funcional & Weighlifting" />

    <title>Alpha Venus - @yield('title')</title>

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






    <link href="{{asset('libraries/bootstrap-5.3.0/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('libraries/animate/animate.css')}}" rel="stylesheet">
    <link href="{{asset('libraries/fontawesome-free-6.2.1/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('libraries/themify-icons/themify-icons.css')}}" rel="stylesheet">

    <link href="{{asset('libraries/magnific-popup/magnific-popup.css')}}" rel="stylesheet">

    <link href="{{asset('libraries/owl.carousel/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{asset('libraries/owl.carousel/owl.theme.default.css')}}" rel="stylesheet">

    <link href="{{asset('css/default.css')}}" rel="stylesheet">

    <!-- core style css -->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet">

    <!-- custom css -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

    @yield('css')
</head>
<body class="antialiased">

<div id="preloader">
    <div class="row loader">
        <div class="loader-icon"></div>
    </div>
</div>



@yield('content')


<a href="#" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>


<!-- jQuery -->
<script src="{{ asset('libraries/jquery-3.6.0/jquery-3.6.0.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('libraries/jquery-3.6.0/jquery-migrate-3.3.2.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('libraries/modernizr/modernizr.js') }}" type="text/javascript"></script>

<script src="{{asset('libraries/bootstrap-5.3.0/js/bootstrap.bundle.min.js')}}"></script>

<!-- scrollIt -->
<script src="{{asset('libraries/scrollit/scrollIt.min.js')}}"></script>

<!-- owl carousel -->
<script src="{{asset('libraries/owl.carousel/owl.carousel.min.js')}}"></script>

<!-- jquery.counterup.min -->
<script src="{{asset('libraries/jquery.counterup/jquery.counterup.min.js')}}"></script>

<!-- stellar js -->
<script src="{{asset('libraries/jquery.stellar/jquery.stellar.min.js')}}"></script>

<!-- waypoints js -->
<script src="{{asset('libraries/waypoints/waypoints.min.js')}}"></script>

<!-- jquery.magnific-popup js -->
<script src="{{asset('libraries/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

<!-- custom scripts -->
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>

@yield('javascript')

</body>
</html>
