@extends('layouts.template_00')

@section('css')
    <link href="{{asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <style>
        .subtable{
            width: 100%;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('/')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{asset('admin')}}">Menu Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reporte de Pagos por Mes Concentrado</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="main-content">
        <div class="container">
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

            <div class="row">
                <div class="col-lg-10">
                    <div id="search">
                        <form method="GET" role="search" action="{{asset('admin/reportes/concentrado_pagos_por_mes')}}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('yearIni', 'a Partir de:',['class'=>'sr-only']) !!}
                                        {!! Form::select('yearIni', [ '2024' => 'AÑO 2024', '2025' =>' AÑO 2025', '2026' =>'AÑO 2026', '2027' =>'AÑO 2027'  ], $yearIni, ['placeholder' => 'INICIO DE LOS TIEMPOS','class'=>'form-select form-control form-control-lg']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('idStatus', 'Status:',['class'=>'sr-only']) !!}
                                        {!! Form::select('idStatus', [ 1 => 'VIGENTES',2 =>'NO VIGENTES' ], $idStatus, ['placeholder' => 'TODOS LOS USUARIOS','class'=>'form-select form-control form-control-lg']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="input-group input-group-lg mb-1">
                                        <input id="txtBuscar" name="txtBuscar" type="text" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2" value="{{$txtBuscar}}">
                                        <button class="btn btn-dark" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                    <small><em>{{count($data)}} Registros Encontrados</em></small>
                                </div>
                                <div class="col-lg-3 text-end mt-3 mt-lg-0">

                                    <a id="btnExportExcel" href="javascript:void(0)" class="btn btn-dark btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="Exportar a Excel" style="margin: 0 2px;">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  table-hover my-5 align-middle">
                            <thead>
                                <tr class="table-dark">
                                    <th>ID</th>
                                    <th style="width: 250px;">Usuario</th>
                                    <th>Fecha Alta</th>
                                    <th>Status</th>
                                    @foreach($meses as $mes)
                                        <th>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m', $mes)->translatedFormat('M Y') }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $usuario)
                                <tr>
                                    <td>{{ $usuario->idUsuario }}</td>
                                    <td style="width: 250px;">{{ $usuario->usuario }}</td>
                                    <td>{{ date('d/m/Y',strtotime($usuario->fechaAlta))}}</td>
                                    <td>
                                        @if($usuario->fechaVigencia >= \Carbon\Carbon::now())
                                            <span class="badge badge-status bg-success"> <small>VIGENTE</small></span><br/>
                                        @else
                                            <span class="badge badge-status bg-secondary"><small>NO VIGENTE</small></span><br/>
                                        @endif
                                    </td>
                                    @foreach($meses as $mes)
                                        <td class="text-end">
                                            @if(!empty((float)$usuario->$mes))
                                                {{ number_format($usuario->$mes,2) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('javascript')
    <script src="{{asset('libraries/moment-develop/moment.js')}}" type="text/javascript"></script>
    <script src="{{asset('libraries/moment-develop/moment-with-locales.js')}}" type="text/javascript"></script>
    <script src="{{asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js')}}" type="text/javascript" ></script>

    <script src="{{ asset('js/admin/reportes/concentrado_pagos.js') }}"></script>
@endsection
