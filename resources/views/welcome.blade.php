
@extends('layouts.template_01')

@section('title','Inicio')

@section('css')

@endsection

@section('content')
    <div class="main-wrapper">
        <header class="header slider-fade full-screen" data-scroll-index="0">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand logo" href="{{asset('/')}}" data-scroll-nav="0">
                        <img src="{{asset('img/logos/logo-light.png')}}" alt="Alpha Venis - Functional Training & Weighlifting" title="Alpha Venis - Functional Training & Weighlifting">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);" data-scroll-nav="0">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="1">¿Quiénes Somos?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="2">Ejercicios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="3">Horarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="4">Entrenador</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="5">Precios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="6">Contacto</a>
                            </li>
                        </ul>
                        <a href="{{asset('login')}}" class="btn btn-fill btn-sm ml-4 d-none d-xl-inline-block">Miembros</a>
                    </div>

                </div>

                <a href="javascript:void(0)" class="sidemenu_btn d-none d-lg-inline-block" id="sidebar_toggle">
                    <span></span> <span></span> <span></span>
                </a>
            </nav>

            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col">
                        <div class="owl-carousel owl-theme width-100 p-0">
                            <div class="item bg-img" data-overlay-dark="7" data-background="img/banner/slide-01.jpg">
                                <div class="caption">
                                    <div class="overflow-hidden">
                                        <h3>Mante tu cuerpo en forma</h3>
                                        <h1>con entrenamiento funcional</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="item bg-img" data-overlay-dark="7" data-background="img/banner/slide-02.jpg">
                                <div class="caption">
                                    <div class="overflow-hidden">
                                        <h3>Tu condición física como la máxima prioridad.</h3>
                                        <h1>Entrenadores Capacitados</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="item bg-img" data-overlay-dark="7" data-background="img/banner/slide-03.jpg">
                                <div class="caption">
                                    <div class="overflow-hidden">
                                        <h3>Las mejores instalaciones</h3>
                                        <h1>Equipo de alta calidad</h1>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="side-menu black alt-font">
                <div class="inner-wrapper">
                    <span class="btn-close" id="btn_sidebar_colse"></span>
                    <nav class="side-nav width-100">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);" data-scroll-nav="0">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="1">¿Quiénes Somos?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="2">Ejercicios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="3">Horarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="4">Entrenador</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="5">Precios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-scroll-nav="6">Contacto</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="side-footer w-100">
                        <div class="social-links">
                            <a href="https://www.facebook.com/alphavenusfunctionaltraining"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/alphavenus_functionaltraining"><i class="fab fa-instagram"></i></a>
                            <a href="{{env('APP_WHATSAPP')}}"><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <a id="close_sidebar" href="javascript:void(0);"></a>

        </header>

        <section data-scroll-index="1" class="about-wrapper mb-0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-12 mb-lg-0 text-center text-lg-start position-relative">
                        <div class="about-image-one">
                            <img src="{{asset('img/content/about-01.jpg')}}" alt="..." class="rounded">
                        </div>
                        <div class="about-video-box">
                            <a class="popup-video video_btn small" href="https://www.youtube.com/watch?v=DZ2Gkzvndwk">
                                <i class="fas fa-play font-size12"></i>
                            </a>
                        </div>
                        <div class="about-image-two">
                            <img src="{{asset('img/content/about-02.jpg')}}" alt="..." class="rounded">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="pl-lg-1-6">
                            <div class="subtitle alt-font"><span class="text-primary">#02</span><span class="title">Acerca de</span></div>
                            <h2 class="display-18 display-md-16 display-lg-14 mb-1-9">Alpha Venus Functional Training & <span class="text-primary">Weightlifting</span></h2>
                            <p class="text-justify">Somos un centro de entrenamiento funcional y halterofilia, en el cual encontrarás un ambiente motivador, entrenadores apasionados y un enfoque único en el entrenamiento funcional, diseñado para potenciar no solo tu fuerza física, sino también tu agilidad, resistencia y flexibilidad. </p>
                            <p class="text-justify">Ya seas un principiante o un atleta experimentado, nuestro centro está diseñado para desafiar y inspirar a cada individuo. Prepárate para descubrir tu máximo potencial y disfrutar de cada paso en este emocionante viaje hacia el bienestar total.</p>
                            <p class="text-justify">Estamos emocionados de tenerte aquí, listo para embarcarte en un viaje hacia una versión más fuerte, saludable y equilibrada de ti mismo.</p>
                            <p class="lead text-dark"><strong>¡Bienvenido a la familia Alpha Venus, donde el progreso se convierte en un estilo de vida!</strong></p>

                            <ul class="list-style1 mb-2-2">
                                <li>Pierde de peso.</li>
                                <li>Potencia tus fuerza física, agilidad y resistencia.</li>
                                <li>Mantente en buena forma física.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- start counter section -->
        <section class="bg-light md mx-xl-5">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-lg-3 mb-1-9 mb-lg-0">
                        <div class="counter-wrapper text-center">
                            <div class="counter-icon mb-2">
                                <i class="fa-solid fa-users text-primary"></i>
                            </div>
                            <p class="countup alt-font mb-2">100</p>
                            <h4 class="mb-0 h5 font-weight-600">Miembros Felices</h4>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 mb-1-9 mb-lg-0">
                        <div class="counter-wrapper text-center">
                            <div class="counter-icon mb-2">
                                <i class="fa-regular fa-square-check text-primary"></i>
                            </div>
                            <p class="countup alt-font mb-2">100</p>
                            <h4 class="mb-0 h5 font-weight-600">Entrenador Calificado</h4>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="counter-wrapper text-center">
                            <div class="counter-icon mb-2">
                                <i class="fa-solid fa-heart-pulse text-primary"></i>
                            </div>
                            <p class="countup alt-font mb-2">100</p>
                            <h4 class="mb-0 h5 font-weight-600">Costo/Beneficio</h4>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="counter-wrapper text-center">
                            <div class="counter-icon mb-2">
                                <i class="fa-solid fa-dumbbell text-primary"></i>

                            </div>
                            <p class="countup alt-font mb-2">100</p>
                            <h4 class="mb-0 h5 font-weight-600">Equipamiento</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end counter section -->

        <!-- start service section -->
        <section data-scroll-index="2">
            <div class="container-fluid">
                <div class="w-95 w-md-75 w-lg-60 w-xl-40 mx-auto mb-6 text-center">
                    <div class="subtitle alt-font"><span class="text-primary">#03</span><span class="title">Ejercicios</span></div>
                    <h2 class="display-18 display-md-16 display-lg-14 mb-0">Potenciamos no solo tu fuerza física, sino también tu agilidad, resistencia y flexibilidad.  <span class="text-primary">#Ejercicios</span></h2>
                </div>
                <div class="service-carousel owl-carousel owl-theme single-img">
                    <div class="service-wrapper">
                        <img src="{{asset('img/content/service-01.jpg')}}" alt="...">
                        <div class="service-overlay-info">
                            <p class="service-title">Peso</p>
                            <h4 class="text-white mb-0">
                                Sesión de pérdida de peso
                            </h4>
                            <div class="service-overlay-icon">
                                <a href="{{asset('img/content/service-01.jpg')}}" class="popimg"><span class="ti-plus text-white"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="service-wrapper">
                        <img src="{{asset('img/content/service-02.jpg')}}" alt="...">
                        <div class="service-overlay-info">
                            <p class="service-title">Weighlifting</p>
                            <h4 class="text-white mb-0">
                                Sesión de entrenamiento con peso
                            </h4>
                            <div class="service-overlay-icon">
                                <a href="{{asset('img/content/service-02.jpg')}}" class="popimg"><span class="ti-plus text-white"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="service-wrapper">
                        <img src="{{asset('img/content/service-03.jpg')}}" alt="...">
                        <div class="service-overlay-info">
                            <p class="service-title">Calentamiento</p>
                            <h4 class="text-white mb-0">
                                Recuperación Consciente
                            </h4>
                            <div class="service-overlay-icon">
                                <a href="{{asset('img/content/service-03.jpg')}}" class="popimg"><span class="ti-plus text-white"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="service-wrapper">
                        <img src="{{asset('img/content/service-04.jpg')}}" alt="...">
                        <div class="service-overlay-info">
                            <p class="service-title">Energía</p>
                            <h4 class="text-white mb-0">
                                Sesión de explosión de energía
                            </h4>
                            <div class="service-overlay-icon">
                                <a href="{{asset('img/content/service-04.jpg')}}" class="popimg"><span class="ti-plus text-white"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end service section -->

        <!-- start timetable section -->
        <section data-scroll-index="3" class="bg-light mx-xl-5">
            <div class="container">
                <div class="w-95 w-md-75 w-lg-60 w-xl-55 mx-auto mb-6 text-center">
                    <div class="subtitle alt-font"><span class="text-primary">#04</span><span class="title">Horarios</span></div>
                    <h2 class="display-18 display-md-16 display-lg-14 mb-0">Estamos comprometidos contigo y tu <span class="text-primary">#Agenda</span></h2>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="schedule-table">
                            <table class="table bg-white">
                                <thead>
                                <tr>
                                    <th>Rutinas</th>
                                    <th>7:30 am - 10:30 am</th>
                                    <th class="last">5:00 pm - 10:00 pm</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="day">Lunes</td>
                                    <td class="active">
                                        <h4>Funcional</h4>
                                        <p>7:30 am - 8:30 am - 9:30 am</p>
                                        <div class="hover">
                                            <h4>Funcional</h4>
                                            <p>7:30 am - 10:30 am</p>
                                            <span>Alejandra Echeveria</span>
                                        </div>
                                    </td>
                                    <td class="active">
                                        <h4>Funcional / Weightlifting</h4>
                                        <p>5:00 pm - 6:00 pm - 7:00 pm - 8:00 pm - 9:00 pm</p>
                                        <div class="hover">
                                            <h4>Funcional / Weightlifting</h4>
                                            <p>5:00 pm - 10:00 pm</p>
                                            <span>Alejandra Echeverría</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="day">Martes</td>
                                    <td class="active">
                                        <h4>Funcional</h4>
                                        <p>7:30 am - 8:30 am - 9:30 am</p>
                                        <div class="hover">
                                            <h4>Funcional</h4>
                                            <p>7:30 am - 10:30 am</p>
                                            <span>Alejandra Echeveria</span>
                                        </div>
                                    </td>
                                    <td class="active">
                                        <h4>Funcional / Weightlifting</h4>
                                        <p>5:00 pm - 6:00 pm - 7:00 pm - 8:00 pm - 9:00 pm</p>
                                        <div class="hover">
                                            <h4>Funcional / Weightlifting</h4>
                                            <p>5:00 pm - 10:00 pm</p>
                                            <span>Alejandra Echeverría</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="day">Miercoles</td>
                                    <td class="active">
                                        <h4>Funcional</h4>
                                        <p>7:30 am - 8:30 am - 9:30 am</p>
                                        <div class="hover">
                                            <h4>Funcional</h4>
                                            <p>7:30 am - 10:30 am</p>
                                            <span>Alejandra Echeveria</span>
                                        </div>
                                    </td>
                                    <td class="active">
                                        <h4>Funcional / Weightlifting</h4>
                                        <p>5:00 pm - 6:00 pm - 7:00 pm - 8:00 pm - 9:00 pm</p>
                                        <div class="hover">
                                            <h4>Funcional / Weightlifting</h4>
                                            <p>5:00 pm - 10:00 pm</p>
                                            <span>Alejandra Echeverría</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="day">Jueves</td>
                                    <td class="active">
                                        <h4>Funcional</h4>
                                        <p>7:30 am - 8:30 am - 9:30 am</p>
                                        <div class="hover">
                                            <h4>Funcional</h4>
                                            <p>7:30 am - 10:30 am</p>
                                            <span>Alejandra Echeveria</span>
                                        </div>
                                    </td>
                                    <td class="active">
                                        <h4>Funcional / Weightlifting</h4>
                                        <p>5:00 pm - 6:00 pm - 7:00 pm - 8:00 pm - 9:00 pm</p>
                                        <div class="hover">
                                            <h4>Funcional / Weightlifting</h4>
                                            <p>5:00 pm - 10:00 pm</p>
                                            <span>Alejandra Echeverría</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="day">Viernes</td>
                                    <td class="active">
                                        <h4>Funcional</h4>
                                        <p>7:30 am - 8:30 am - 9:30 am</p>
                                        <div class="hover">
                                            <h4>Funcional</h4>
                                            <p>7:30 am - 10:30 am</p>
                                            <span>Alejandra Echeveria</span>
                                        </div>
                                    </td>
                                    <td class="active">
                                        <h4>Funcional / Weightlifting</h4>
                                        <p>5:00 pm - 6:00 pm - 7:00 pm - 8:00 pm - 9:00 pm</p>
                                        <div class="hover">
                                            <h4>Funcional / Weightlifting</h4>
                                            <p>5:00 pm - 10:00 pm</p>
                                            <span>Alejandra Echeverría</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="day">Sabado</td>
                                    <td class="active">
                                        <h4>Funcional</h4>
                                        <p>9:00 am</p>
                                        <div class="hover">
                                            <h4>Funcional</h4>
                                            <p>9:00 am - 11:00 am</p>
                                            <span>Alejandra Echeverría</span>
                                        </div>
                                    </td>
                                    <td> - </td>
                                </tr>
                                <tr>
                                    <td class="day">Domingo</td>
                                    <td> - </td>
                                    <td> - </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end timetable section -->

        <!-- start team section -->
        <section data-scroll-index="4">
            <div class="container">
                <div class="w-95 w-md-75 w-lg-60 w-xl-55 mx-auto mb-6 text-center">
                    <div class="subtitle alt-font"><span class="text-primary">#05</span><span class="title">Entrenador</span></div>
                    <h2 class="display-18 display-md-16 display-lg-14 mb-0">Estamos orgullosos de nuestra <span class="text-primary">#Entrenadora</span></h2>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="team-wrapper">
                            <img src="{{asset('img/team/team-01.jpg')}}" alt="Alejandra Echeverría">
                            <div class="team-content">
                                <h4 class="h5">Alejandra Echeverría</h4>
                                <span class="font-weight-500 display-30 text-capitalize text-black">
                                    Profra. Educación Física <br/>
                                    Halterófila / pesista
                                </span>
                                <p class="team-seprator"></p>
                                <ul class="social-icons">
                                    <li>
                                        <a href="https://www.facebook.com/alejandra.lopezecheverria"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/lalalalita_e"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.tiktok.com/@lalalalita_e"><i class="fa-brands fa-tiktok"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <ul class="list-style2 mb-2-2">
                            <li>
                                2009 / 2019 - Levantamiento de Pesas / Halterofilia
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2012 - Primer lugar  Olimpiada Nacional Irapuato, Guanajuato</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2012 - Segundo lugar Campeonato Panamericano Merída, Yucatán</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2012 - Segundo lugar Campeonato Panamericano Merída, Yucatán</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2013 - Segundo lugar Olimpiada Nacional, Mexicali, Baja California</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2014 - Tercer lugar  Panamericanos Sub 17, Lima, Perú</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2015 - Tercer lugar  Olimpiada Nacional, Monterrey, Nuevo León</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2016 - Segundo lugar Olimpiada Nacional, Mexicali, Baja California</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2017 - Primer lugar  Olimpiada Nacional, Monterrey, Nuevo León</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2017 - Primer lugar  Olimpiada Nacional, Monterrey, Nuevo León</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2019 - Primer lugar  Olimpiada Regional, Chetumal, Quintana Roo</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2019 - Tercer lugar  Olimpiada Nacional, Chetumal, Quintana Roo</li>
                                    <li><span class="fa-li"><i class="fa-solid fa-medal"></i></span>2020 - Primer lugar  Olimpiada Regional, Chetumal, Quintana Roo</li>
                                </ul>
                            </li>

                            <li>2021 - Licenciatura de Educación Física.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end team section -->

        <!-- start pricing section -->
        <section class="bg-light mx-xl-5" data-scroll-index="5">
            <div class="container">
                <div class="w-95 w-md-75 w-lg-60 w-xl-55 mx-auto mb-6 text-center">
                    <div class="subtitle alt-font"><span class="text-primary">#06</span><span class="title">Costos</span></div>
                    <h2 class="display-18 display-md-16 display-lg-14 mb-0">Cuidamos de tu economía con los mejores precios en <span class="text-primary">#membresías</span></h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 mb-1-6 mb-md-1-9 mb-lg-0 d-none">
                        <div class="bg-img cover-background" data-overlay-dark="8" data-background="img/content/pricing-bg-01.jpg">
                            <div class="price-wrapper">
                                <h3 class="h5 text-white text-center mb-1-6">ESTUDIANTES</h3>
                                <div class="price">
                                    <h3><span>$</span>500.00</h3>
                                    <p class="font-weight-700 text-white d-inline-block mb-0">/ mensual</p>
                                </div>
                                <ul class="pricing-list">
                                    <li>Acceso ilimitado al centro de entrenamiento</li>
                                    <li>Clase Funcional</li>
                                    <li>Clase de Halterofilia</li>
                                    <li>5 clases por semana</li>
                                    <li>Entrenador personal</li>
                                </ul>
                                <div class="text-center">
                                    <a href="{{env('APP_WHATSAPP')}}" class="btn btn-fill">Inscríbete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-1-6 mb-md-1-9 mb-lg-0">
                        <div class="bg-img cover-background" data-overlay-dark="8" data-background="img/content/pricing-bg-02.jpg">
                            <div class="price-wrapper">
                                <span class="popular">Popular</span>
                                <h3 class="h5 text-white text-center mb-1-6">INDIVIDUAL</h3>
                                <div class="price">
                                    <h3><span>$</span>650.00</h3>
                                    <p class="font-weight-700 text-white d-inline-block m-0">/ mensual</p>
                                </div>
                                <ul class="pricing-list">
                                    <li>Acceso ilimitado al centro de entrenamiento</li>
                                    <li>Clase Funcional</li>
                                    <li>Clase de Halterofilia</li>
                                    <li>5 clases por semana</li>
                                    <li>Entrenador personal</li>
                                </ul>
                                <div class="text-center">
                                    <a href="{{env('APP_WHATSAPP')}}" class="btn btn-fill">Inscríbete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="bg-img cover-background" data-overlay-dark="8" data-background="img/content/pricing-bg-03.jpg">
                            <div class="price-wrapper">
                                <h3 class="h5 text-white text-center mb-1-6">PAREJAS</h3>
                                <div class="price">
                                    <h3><span>$</span>1,200.00</h3>
                                    <p class="font-weight-700 text-white d-inline-block m-0">/ mensual</p>
                                </div>
                                <ul class="pricing-list">
                                    <li>Acceso ilimitado al centro de entrenamiento</li>
                                    <li>Clase Funcional</li>
                                    <li>Clase de Halterofilia</li>
                                    <li>5 clases por semana</li>
                                    <li>Entrenador personal</li>
                                </ul>
                                <div class="text-center">
                                    <a href="{{env('APP_WHATSAPP')}}" class="btn btn-fill">Inscríbete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end pricing section -->

        <!-- start testimonial section -->
        <section class="testimonials">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="testimonial-carousel owl-carousel owl-theme">
                            <div class="testimonial-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-7 col-xl-8 order-2 order-md-1">
                                        <div class="testimonial-content">
                                            <p class="testimonial-text">"La competencia más grande eres tú. Ganate todos los días."</p>
                                            <div class="testimonial-info">
                                                <p class="mb-0">Saúl "Canelo" Álvarez, <span>Boxeador</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-5 col-xl-4 order-1 order-md-2">
                                        <div class="testimonial-image rounded-circle bg-img" data-overlay-dark="0" data-background="{{asset('img/testmonials/canelo_alvarez.jpg')}}">
                                            <div class="icon-wrapper">
                                                <div class="quote"><i class="fas fa-quote-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-7 col-xl-8 order-2 order-md-1">
                                        <div class="testimonial-content">
                                            <p class="testimonial-text">"Yo creo que en la vida deberías de trabajar en ti mismo hasta el día de tu muerte."</p>
                                            <div class="testimonial-info">
                                                <p class="mb-0">Serena Williams, <span>Tenista</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-5 col-xl-4 order-1 order-md-2">
                                        <div class="testimonial-image rounded-circle bg-img" data-overlay-dark="0" data-background="{{asset('img/testmonials/serena_williams.jpg')}}">
                                            <div class="icon-wrapper">
                                                <div class="quote"><i class="fas fa-quote-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-7 col-xl-8 order-2 order-md-1">
                                        <div class="testimonial-content">
                                            <p class="testimonial-text">"Si sabes lo que vales, ve y consigue lo que mereces, pero tendrás que aguantar los golpes."</p>
                                            <div class="testimonial-info">
                                                <p class="mb-0">Sylvester Stallone, <span>Actor</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-5 col-xl-4 order-1 order-md-2">
                                        <div class="testimonial-image rounded-circle bg-img" data-overlay-dark="0" data-background="{{asset('img/testmonials/sylvester_stallon.jpg')}}">
                                            <div class="icon-wrapper">
                                                <div class="quote"><i class="fas fa-quote-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-lg-7 col-xl-8 order-2 order-md-1">
                                        <div class="testimonial-content">
                                            <p class="testimonial-text">"No es el tamaño de la pesa, es el tamaño de tu motivación."</p>
                                            <div class="testimonial-info">
                                                <p class="mb-0">Soraya Jimenez, <span>Levantadora de peso</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-5 col-xl-4 order-1 order-md-2">
                                        <div class="testimonial-image rounded-circle bg-img" data-overlay-dark="0" data-background="{{asset('img/testmonials/soraya_jimenez.jpg')}}">
                                            <div class="icon-wrapper">
                                                <div class="quote"><i class="fas fa-quote-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end testimonial section -->

        <!-- start blog section -->
        <section class="lg bg-light" data-scroll-index="6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 mb-1-9 mb-lg-0">
                        <div class="bg-light p-1-6 p-lg-2-9 rounded border text-center">
                            <div id="fb-root"></div>
                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v19.0&appId=922039432551754" nonce="vC6P4PGZ"></script>
                            <div class="fb-page" data-href="https://www.facebook.com/alphavenusfunctionaltraining" data-tabs="timeline" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/alphavenusfunctionaltraining" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/alphavenusfunctionaltraining">Alpha Venus</a></blockquote></div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="bg-light p-1-6 p-lg-2-9 ml-lg-1-6 rounded border">
                            <h3 class="mb-1-9">Contáctanos</h3>

                            <p class="lead text-justify"> Si tienes alguna queja o sugerencia por favor contáctanos al siguiente correo:
                                <a href="mailto:alphavenusfunctionaltraining@gmail.com">alphavenusfunctionaltraining@gmail.com</a>
                            </p>
                            <p class="lead text-justify">O bien si lo prefieres envíanos un mensaje de WhatsApp a los siguientes números:</p>
                            <ul>
                                <li><strong>Informes:</strong> <a href="{{env('APP_WHATSAPP')}}">+52 961 231 3700</a></li>
                                <li><strong>Quejas y/o Sugerencias:</strong> <a href="https://api.whatsapp.com/send?phone=529611248699&text=Hola">+52 961 124 8699</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end blog section -->

        <footer class="bg-white">
            <div class="footer-topbar bg-primary">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6 col-lg-7 mb-1-9 mb-md-0 text-center text-md-left">
                            <h4>¿Tienes alguna duda? ¡Contáctanos!</h4>
                            <p>Para nosotros será un placer el atenderte.</p>
                        </div>

                        <div class="col-md-6 col-lg-5">
                            <a href="{{env('APP_WHATSAPP')}}" class="btn btn-light"><i class="fa-brands fa-whatsapp"></i> Contáctanos</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-lg-4 mb-1-9 mb-lg-0">
                            <h3 class="mb-4">Dirección</h3>
                            <address class="w-85 mb-0">Calle Palma Helechos 443, Colonia Las Palmas, Tuxtla Gutiérrez, Mexico, 29040</address>
                        </div>
                        <div class="col-sm-6 col-lg-5 mb-1-9 mb-sm-0">
                            <h3 class="mb-4">Email</h3>
                            <ul class="mb-0 list-unstyled">
                                <li>alphavenusfunctionaltraining@gmail.com</li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <h3 class="mb-4">Social</h3>
                            <div class="footer-social">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/alphavenusfunctionaltraining"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/alphavenus_functionaltraining"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{env('APP_WHATSAPP')}}"><i class="fa-brands fa-whatsapp"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top border-color-light-black py-1-6 bg-light">
                <div class="container text-center">
                    &copy; {{\Carbon\Carbon::now()->year}} Alpha Venus Web Page is Powered by <a href="https://bht.mx">Black Horse Technologies</a>
                </div>
            </div>
        </footer>


    </div>
@endsection

@section('javascript')

@endsection
