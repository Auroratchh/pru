@php
    $sexos          = App\Models\Sexo::where('eliminado',0)->pluck('sexo','idSexo');
@endphp

@extends('layouts.template_01')

@section('title','Regístro Miembros')

@section('css')
    <link href="{{asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <section class="page-title-section top-position bg-img cover-background" data-overlay-dark="4" data-background="{{asset('img/banner/page-title.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Regístro Miembros</h1>
                </div>
                <div class="col-md-12">
                    <ul>
                        <li><a href="{{asset('/')}}">Inicio</a></li>
                        <li><a href="javascript:void(0);">Regístrarse</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xl-7">
                    <div class="bg-white p-4 border border-width-5">
                        <div class="section-heading mb-5">
                            <h2>Regístro para Miembros Alpha Venus</h2>
                        </div>

                        {!! Form::open(['url'=>'register','method' => 'POST', 'id'=>'FormRegister','class'=>'contact-form'])!!}

                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group mb-2">
                                    {!! Form::label('nombre', 'Nombre:',['class'=>'sr-only']) !!}
                                    {!! Form::text('nombre',null,['class'=>'form-control ','placeholder'=>'Nombre']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    {!! Form::label('apellidoPaterno', 'Apellido Paterno:',['class'=>'sr-only']) !!}
                                    {!! Form::text('apellidoPaterno',null,['class'=>'form-control ','placeholder'=>'Apellido Paterno']) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    {!! Form::label('apellidoMaterno', 'Apellido Materno:',['class'=>'sr-only']) !!}
                                    {!! Form::text('apellidoMaterno',null,['class'=>'form-control ','placeholder'=>'Apellido Materno']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    {!! Form::label('celular', 'Celular:',['class'=>'sr-only']) !!}
                                    {!! Form::text('celular',null,['class'=>'form-control ','placeholder'=>'Celular']) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    {!! Form::label('idSexo', 'Sexo:',['class'=>'sr-only']) !!}
                                    {!!Form::select('idSexo',$sexos,null, ['class' => 'form-control','placeholder'=>'SELECCIONE SEXO'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group mb-2">
                                    {!! Form::label('fechaNacimiento', 'Fecha Nacimiento:',['class'=>'sr-only']) !!}
                                    <div style="display: block; position: relative;">
                                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                            <input id="fechaNacimiento" name="fechaNacimiento" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" placeholder="Fecha Nacimiento" aria-label="Fecha Nacimiento" aria-describedby="basic-addon2" readonly/>
                                            <span class="input-group-text" id="basic-addon2" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                            <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group mb-2">
                                    {!! Form::label('email', 'Email:',['class'=>'sr-only']) !!}
                                    {!! Form::text('email',null,['class'=>'form-control ','placeholder'=>'Email']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group mb-2">
                                    {!! Form::label('password', 'Contraseña:',['class'=>'sr-only']) !!}
                                    {!! Form::password('password',['class'=>'form-control ','placeholder'=>'Contraseña']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group mb-2">
                                    {!! Form::label('password_confirmation', 'Confirmar Contraseña:',['class'=>'sr-only']) !!}
                                    {!! Form::password('password_confirmation',['class'=>'form-control ','placeholder'=>'Confirmar Contraseña']) !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4"><span>Regístrarse</span></button>

                        {!! Form::close()!!}

                        <br/><br/>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <input type="hidden" id="seccion_amc" value="#btn-inicio" />
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('libraries/jquery-validation-1.19.5/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/jquery-validation-1.19.5/additional-methods.min.js') }}"></script>

    <script src="{{asset('libraries/moment-develop/moment.js')}}" type="text/javascript"></script>
    <script src="{{asset('libraries/moment-develop/moment-with-locales.js')}}" type="text/javascript"></script>
    <script src="{{asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js')}}" type="text/javascript" ></script>

    <script src="{{ asset('js/auth/register.js') }}"></script>
@endsection

