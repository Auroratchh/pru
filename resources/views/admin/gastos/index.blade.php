@extends('layouts.template_00')

@section('css')
    <link href="{{asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('/')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{asset('admin')}}">Menu Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gastos</li>
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
                <div class="col-md-12">

                    <div id="search">
                        <form method="GET" role="search" action="{{asset('admin/gastos')}}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('fechaIni', 'Fecha de Inicio:',['class'=>'sr-only']) !!}
                                        <div style="display: block; position: relative;">
                                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                                <input id="fechaIni" name="fechaIni" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" placeholder="Fecha Inicial" aria-label="Fecha Inicial" aria-describedby="basic-addon2" value="{{date('d/m/Y',strtotime($fechaIni))}}" readonly/>
                                                <span class="input-group-text" id="basic-addon2" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('fechaFin', 'Fecha Fin:',['class'=>'sr-only']) !!}
                                        <div style="display: block; position: relative;">
                                            <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                                <input id="fechaFin" name="fechaFin" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" placeholder="Fecha Fin" aria-label="Fecha Fin" aria-describedby="basic-addon2" value="{{date('d/m/Y',strtotime($fechaFin))}}" readonly/>
                                                <span class="input-group-text" id="basic-addon2" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                        <i class="fa fa-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="input-group input-group-lg mb-1">
                                        <input id="txtBuscar" name="txtBuscar" type="text" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2" value="{{$txtBuscar}}">
                                        <button class="btn btn-dark" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                    <small><em>{{$gastos->total()}} Registros Encontrados</em></small>
                                </div>
                                <div class="col-lg-3 text-end mt-3 mt-lg-0">
                                    <a href="{{asset('admin/gastos/create')}}" class="btn btn-dark btn-lg" data-toggle="tooltip" data-placement="top" title="Nuevo Gasto">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered table-striped  table-hover my-5 align-middle">
                        <thead>
                            <tr class="table-dark">
                                <th class="text-center">ID</th>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Tipo de Gasto</th>
                                <th>Usuario</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($gastos as $gasto)
                            <tr>
                                <td class="text-center">{{$gasto->idGasto}}</td>
                                <td>
                                    <strong> {{ date('d/m/Y',strtotime($gasto->fechaGasto))}}</strong>
                                </td>
                                <td>
                                    <strong>{{$gasto->gasto}}<br/></strong>
                                    <small>{{$gasto->descripcion}}</small>
                                </td>
                                <td> {{$gasto->tipoGasto}} </td>
                                <td> {{$gasto->usuario}} </td>

                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{asset('admin/gastos/'.$gasto->idGasto.'/edit')}}" data-bs-toggle="tooltip" data-bs-title="Editar Gasto">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    {!! Form::open(['url'=>'admin/gastos/'.$gasto->idGasto, 'method' => 'DELETE','class'=>'formDeleteEvento','style'=>'display:inline']) !!}
                                        <button type="button" class="btn btn-danger btn-sm btnDelete" title="Eliminar" data-bs-toggle="tooltip" data-bs-title="Eliminar Gasto">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div style="margin-bottom: 100px; margin-top: 70px;">
                        {!! $gastos->appends([
                                'txtBuscar'     => $txtBuscar,
                                'fechaIni'      => $fechaIni,
                                'fechaFin'      => $fechaFin,
                                ])->links()!!}
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

    <script src="{{ asset('js/admin/gastos/gastos_index.js') }}"></script>
@endsection
