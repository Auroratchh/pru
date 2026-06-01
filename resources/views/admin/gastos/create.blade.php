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
                    <li class="breadcrumb-item"><a href="{{asset('admin/gastos')}}">Gastos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo Gasto</li>
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

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::open(['url'=>'admin/gastos/','method' => 'POST', 'id'=>'FormCreate', 'class'=>'form-amc'])!!}
                    <div class="panel-result">
                        <div class="panel-result-heading">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 class="panel-title">Detalle de nuevo Gasto</h3>
                                </div>
                                <div class="col-sm-4 text-end">
                                    <span class="help-block">* Campos requeridos</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-result-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    <div class="form-group row">
                                        {!! Form::label('idTipoGasto', 'Tipo Gasto:',['class'=>'col-lg-2 col-form-label']) !!}
                                        <div class="col-lg-4">
                                            {!! Form::select('idTipoGasto',$tipoGasto,null,['class'=>'form-control','placeholder'=>'SELECCIONE EL TIPO DE GASTO']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {!! Form::label('gasto', 'Concepto de Gasto:',['class'=>'col-lg-2 col-form-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::text('gasto',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('descripcion', 'Descripción:',['class'=>'col-lg-2 col-form-label']) !!}
                                        <div class="col-lg-8">
                                            {!! Form::textArea('descripcion',null,['class'=>'form-control','rows'=>'4']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {!! Form::label('fechaGasto', 'Fecha Gasto:',['class'=>'col-lg-2 col-form-label']) !!}
                                        <div class="col-lg-3">
                                            <div style="display: block; position: relative;">
                                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                                    <input id="fechaGasto" name="fechaGasto" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" placeholder="Fecha Gasto" aria-label="Fecha Gasto" aria-describedby="basic-addon2" value="" readonly/>
                                                    <span class="input-group-text" id="basic-addon2" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                            <i class="fa fa-calendar"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('monto', 'Monto:',['class'=>'col-lg-2 col-form-label']) !!}
                                        <div class="col-lg-3">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">$</span>
                                                {!! Form::text('monto',null,['class'=>'form-control','aria-describedby'=>'basic-addon1']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        {!! Form::submit('CREAR', ['id'=>'btnGuardar','class' => 'btn btn-dark btn-lg']) !!}
                    </div>

                    {!! Form::close()!!}
                </div>
        </div>
    </section>

@endsection

@section('javascript')

    <script src="{{asset('libraries/moment-develop/moment.js')}}" type="text/javascript"></script>
    <script src="{{asset('libraries/moment-develop/moment-with-locales.js')}}" type="text/javascript"></script>
    <script src="{{asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js')}}" type="text/javascript" ></script>

    <script src="{{ asset('js/admin/gastos/gastos_create.js') }}"></script>

@endsection
