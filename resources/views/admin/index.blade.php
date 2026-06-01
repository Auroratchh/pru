@extends('layouts.template_00')

@section('content')

    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('/')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Menu Administración</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="main-content">
        <div id="menu-principal" class="container">
            <div class="row justify-content-start">
                <div class="col-md-10">
                    @if (session('status_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('status_success')  !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('status_fail'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {!! session('status_fail')  !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/usuarios')}}">
                            <i class="fa-solid fa-users"></i>
                            <div class="item-body">
                                <h3>Miembros</h3>
                                <p>Administra los usuarios registrados. Verifica sus datos.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/gastos')}}">
                            <i class="fa-solid fa-money-bill"></i>
                            <div class="item-body">
                                <h3>Gastos</h3>
                                <p>Gestión de Gastos</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/programaciones')}}">
                            <i class="fa-solid fa-pencil"></i>
                            <div class="item-body">
                                <h3>Programación</h3>
                                <p>Configuración de Clases</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/reservas')}}">
                            <i class="fa-solid fa-check"></i>
                            <div class="item-body">
                                <h3>Reservas</h3>
                                <p>Control de Reservaciones</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/asistencias')}}">
                            <i class="fa-solid fa-list"></i>
                            <div class="item-body">
                                <h3>Asistencias</h3>
                                <p>Lista de Asistencias</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('registrar-asistencia')}}">
                            <i class="fa-solid fa-check-double"></i>
                            <div class="item-body">
                                <h3>Registrar Asistencia</h3>
                                <p>Marca tu Asistencia</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/reportes/corte_caja')}}">
                            <i class="fa-solid fa-chart-simple"></i>
                            <div class="item-body">
                                <h3>Corte Caja</h3>
                                <p>Reporte</p>
                            </div>
                        </a>
                    </div>
                </div>

                @if(Auth::user()->esAdmin())
                    <div class="col-sm-6 col-md-3">
                        <div class="administracion-item">
                            <a href="{{asset('admin/reportes/concentrado_pagos_por_mes')}}">
                                <i class="fa-solid fa-chart-simple"></i>
                                <div class="item-body">
                                    <h3>Concentrado de Pagos</h3>
                                    <p>Reporte</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif

                <div class="col-sm-6 col-md-3">
                    <div class="administracion-item">
                        <a href="{{asset('admin/reportes/pagos_pendientes')}}">
                            <i class="fa-solid fa-chart-simple"></i>
                            <div class="item-body">
                                <h3>Pagos Pendientes</h3>
                                <p>Reporte</p>
                            </div>
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </section>

@endsection

@section('javascript')

@endsection
