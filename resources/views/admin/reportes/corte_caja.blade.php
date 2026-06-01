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
                    <li class="breadcrumb-item active" aria-current="page">Reporte de Corte de Caja</li>
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
                <div class="col-lg-7">
                    <div id="search" class="bg-secondary p-3 pt-4">
                        <form method="GET" role="search" action="{{asset('admin/reportes/corte_caja')}}">
                            <div class="row">
                                <div class="col-lg-6">
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
                                <div class="col-lg-6">
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
                                <div class="col-lg-12 text-end">
                                    <button class="btn btn-dark btn-lg mr-2" type="submit" id="button-addon2">Buscar</button>

                                    @if(Auth::user()->idRol == 1)
                                    <a id="btnExportExcel" href="javascript:void(0)" class="btn btn-dark btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="Exportar a Excel" style="margin: 0 2px;">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bg-secondary p-3 pt-4">
                        <table class="table text-white">
                            <tr>
                                <td colspan="2" style="padding-left: 15px;">
                                    <table class="subtable">
                                        <tr>
                                            <td>Pagos en Transferencias:</td>
                                            <td class="text-end">
                                                $ {{ number_format($pagoTransferencias,2)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pagos en Efectivo:</td>
                                            <td class="text-end">
                                                $ {{ number_format($pagoEfectivo,2)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pagos en Depositos:</td>
                                            <td class="text-end">
                                                $ {{ number_format($pagoDepositos,2)}}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Pagos:</th>
                                <td class="text-end">
                                    $ {{ number_format($totalPagos,2)}}
                                </td>
                            </tr>
                            <tr>
                                <th>Total Gastos:</th>
                                <td class="text-end">
                                    $ {{ number_format($totalGastos,2)}}
                                </td>
                            </tr>
                            @php
                                $total = $totalPagos - $totalGastos;
                            @endphp
                            <tr>
                                <th>Resultados :</th>
                                <td class="text-end">
                                    $ {{ number_format($total,2)}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  table-hover my-5 align-middle">
                            <thead>
                            <tr class="table-dark">
                                <th>Fecha</th>
                                <th>Miembro</th>
                                <th>Monto Pago</th>
                                <th>Forma de Pago</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pagos as $pago)
                                <tr>
                                    <td style="width: 120px;"><strong> {{ date('d/m/Y',strtotime($pago->fechaPago))}}</strong></td>
                                    <td style="width: 450px;"> MEMBRESIA<br/>
                                        <strong><small>{{$pago->usuario}}</small></strong>
                                    </td>
                                    <td>$ {{number_format($pago->monto,2)}}</td>
                                    <td> {{$pago->formaPago}} </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table class="table table-bordered table-striped  table-hover my-5 align-middle">
                            <thead>
                            <tr class="table-dark">
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Monto Gasto</th>
                                <th>Tipo Gasto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gastos as $gasto)
                                <tr>
                                    <td style="width: 120px;"><strong> {{ date('d/m/Y',strtotime($gasto->fechaGasto))}}</strong></td>
                                    <td style="width: 450px;">
                                        {{$gasto->gasto}}<br/>
                                        <strong><small>{{$gasto->usuario}}</small></strong>
                                    </td>
                                    <td>$ {{number_format($gasto->monto,2)}}</td>
                                    <td> {{$gasto->tipoGasto}} </td>
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

    <script src="{{ asset('js/admin/reportes/corte_caja.js') }}"></script>
@endsection
