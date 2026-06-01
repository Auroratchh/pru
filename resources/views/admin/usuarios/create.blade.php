@extends('layouts.template_00')

@section('css')
    <link href="{{ asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Menú Administración</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/usuarios') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo usuario</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-usuarios-page">

            <div class="row justify-content-center">
                <div class="col-xl-10">

                    @if (session('status_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('status_success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('status_fail'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {!! session('status_fail') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="fw-bold mb-2">Corrige lo siguiente:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {!! Form::open(['url' => 'admin/usuarios', 'method' => 'POST', 'id' => 'FormCreate']) !!}

                    <div class="user-form-hero mb-4">
                        <div class="user-form-hero-content">
                            <div>
                                <h1 class="user-form-title">Nuevo usuario / miembro</h1>
                                <p class="user-form-subtitle mb-0">
                                    Capture la información del miembro y configure su membresía desde el alta.
                                </p>
                            </div>
                            <div class="user-form-chip">
                                <i class="fa-solid fa-user-plus me-2"></i>Alta de miembro
                            </div>
                        </div>
                    </div>

                    {{-- INFORMACIÓN PERSONAL --}}
                    <div class="user-form-card mb-4">
                        <div class="user-form-card-header">
                            <h2 class="user-form-card-title">Información personal</h2>
                            <p class="user-form-card-subtitle">Datos generales del miembro.</p>
                        </div>

                        <div class="user-form-card-body">
                            <div class="row g-4 user-form-row">

                                <div class="col-md-4">
                                    {!! Form::label('nombre', 'Nombre *', ['class' => 'form-label']) !!}
                                    {!! Form::text('nombre', old('nombre'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'Nombre'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('apellidoPaterno', 'Apellido paterno *', ['class' => 'form-label']) !!}
                                    {!! Form::text('apellidoPaterno', old('apellidoPaterno'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'Apellido paterno'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('apellidoMaterno', 'Apellido materno', ['class' => 'form-label']) !!}
                                    {!! Form::text('apellidoMaterno', old('apellidoMaterno'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'Apellido materno'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('fechaNacimiento', 'Fecha de nacimiento *', ['class' => 'form-label']) !!}
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input
                                                id="fechaNacimiento"
                                                name="fechaNacimiento"
                                                type="text"
                                                class="form-control datetimepicker-input"
                                                data-target="#datetimepicker1"
                                                placeholder="Fecha de nacimiento"
                                                value="{{ old('fechaNacimiento') }}"
                                                readonly
                                        />
                                        <span class="input-group-text" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('celular', 'Celular *', ['class' => 'form-label']) !!}
                                    {!! Form::text('celular', old('celular'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'Ej. 9611234567'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('idSexo', 'Sexo', ['class' => 'form-label']) !!}
                                    {!! Form::select('idSexo', $sexos, old('idSexo'), [
                                        'class' => 'form-select',
                                        'placeholder' => 'Seleccione sexo'
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- MEMBRESÍA Y COBRANZA --}}
                    <div class="user-form-card mb-4">
                        <div class="user-form-card-header">
                            <h2 class="user-form-card-title">Membresía y cobranza</h2>
                            <p class="user-form-card-subtitle">Configuración inicial del plan y del monto esperado.</p>
                        </div>

                        <div class="user-form-card-body">
                            <div class="row g-4 user-form-row">

                                <div class="col-md-4">
                                    {!! Form::label('idRol', 'Rol *', ['class' => 'form-label']) !!}
                                    {!! Form::select('idRol', $roles, old('idRol', 2), [
                                        'class' => 'form-select',
                                        'placeholder' => 'Seleccione rol'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('idMembresia', 'Membresía', ['class' => 'form-label']) !!}
                                    {!! Form::select('idMembresia', $membresiasList, old('idMembresia'), [
                                        'class' => 'form-select',
                                        'placeholder' => 'Seleccione membresía',
                                        'id' => 'idMembresia'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('pagoMensualEsperado', 'Pago mensual esperado', ['class' => 'form-label']) !!}
                                    <div class="input-group input-money-group">
                                        <span class="input-group-text">$</span>
                                        {!! Form::number('pagoMensualEsperado', old('pagoMensualEsperado'), [
                                            'class' => 'form-control',
                                            'step' => '0.01',
                                            'min' => '0',
                                            'placeholder' => 'Ej. 650.00',
                                            'id' => 'pagoMensualEsperado'
                                        ]) !!}
                                    </div>
                                    <small class="form-hint">
                                        Se llena automáticamente al elegir una membresía, pero puedes ajustarlo manualmente.
                                    </small>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ACCESO AL SISTEMA --}}
                    <div class="user-form-card mb-4">
                        <div class="user-form-card-header">
                            <h2 class="user-form-card-title">Acceso al sistema</h2>
                            <p class="user-form-card-subtitle">Credenciales para ingresar al sistema.</p>
                        </div>

                        <div class="user-form-card-body">
                            <div class="row g-4 user-form-row">

                                <div class="col-md-6">
                                    {!! Form::label('email', 'Email *', ['class' => 'form-label']) !!}
                                    {!! Form::text('email', old('email'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'correo@dominio.com'
                                    ]) !!}
                                </div>

                                <div class="col-md-3">
                                    {!! Form::label('password', 'Contraseña *', ['class' => 'form-label']) !!}
                                    {!! Form::password('password', [
                                        'class' => 'form-control',
                                        'placeholder' => 'Contraseña'
                                    ]) !!}
                                </div>

                                <div class="col-md-3">
                                    {!! Form::label('password_confirmation', 'Confirmar contraseña *', ['class' => 'form-label']) !!}
                                    {!! Form::password('password_confirmation', [
                                        'class' => 'form-control',
                                        'placeholder' => 'Confirmar contraseña'
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="user-form-actions">
                        <a href="{{ url('admin/usuarios') }}" class="btn btn-outline-secondary btn-lg">
                            Cancelar
                        </a>
                        {!! Form::submit('Crear usuario', ['id' => 'btnGuardar', 'class' => 'btn btn-admin-dark btn-lg']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('libraries/moment-develop/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries/moment-develop/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/usuarios/usuarios_create.js') }}" type="text/javascript"></script>

    <script>
        const membresiasData = @json($membresiasData);

        $(function () {
            moment.locale('es');

            $("#datetimepicker1").datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY',
                viewMode: 'years',
                useCurrent: false,
                ignoreReadonly:true
            });

            $('#idMembresia').on('change', function () {
                const idMembresia = $(this).val();

                if (idMembresia && membresiasData[idMembresia]) {
                    const costo = parseFloat(membresiasData[idMembresia].costo);
                    $('#pagoMensualEsperado').val(costo.toFixed(2));
                }
            });

            @if(old('idMembresia') && old('pagoMensualEsperado') == null)
            $('#idMembresia').trigger('change');
            @endif
        });
    </script>
@endsection