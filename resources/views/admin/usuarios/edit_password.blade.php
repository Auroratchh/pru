@extends('layouts.template_00')

@section('css')
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
                    <li class="breadcrumb-item"><a href="{{ url('admin/usuarios/' . $usuario->idUsuario) }}">Usuario {{ $usuario->idUsuario }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar contraseña</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-usuarios-page">

            <div class="row justify-content-center">
                <div class="col-xl-8">

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

                    {!! Form::model($usuario, [
                        'url' => 'admin/usuarios/' . $usuario->idUsuario . '/update_password',
                        'method' => 'PATCH',
                        'id' => 'FormUpdatePassword'
                    ]) !!}

                    <div class="user-form-hero mb-4">
                        <div class="user-form-hero-content">
                            <div>
                                <h1 class="user-form-title">Cambiar contraseña</h1>
                                <p class="user-form-subtitle mb-0">
                                    {{ $usuario->nombre_completo }}
                                </p>
                            </div>
                            <div class="user-form-chip">
                                <i class="fa-solid fa-key me-2"></i>Seguridad
                            </div>
                        </div>
                    </div>

                    <div class="user-form-card mb-4">
                        <div class="user-form-card-header">
                            <h2 class="user-form-card-title">Nueva contraseña</h2>
                            <p class="user-form-card-subtitle">
                                Define una nueva contraseña para el acceso del usuario al sistema.
                            </p>
                        </div>

                        <div class="user-form-card-body">
                            <div class="row g-4 user-form-row">

                                <div class="col-md-6">
                                    {!! Form::label('password', 'Nueva contraseña *', ['class' => 'form-label']) !!}
                                    {!! Form::password('password', [
                                        'class' => 'form-control',
                                        'placeholder' => 'Nueva contraseña'
                                    ]) !!}
                                </div>

                                <div class="col-md-6">
                                    {!! Form::label('password_confirmation', 'Confirmar contraseña *', ['class' => 'form-label']) !!}
                                    {!! Form::password('password_confirmation', [
                                        'class' => 'form-control',
                                        'placeholder' => 'Confirmar nueva contraseña'
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="user-form-actions">
                        <a href="{{ url('admin/usuarios/' . $usuario->idUsuario) }}" class="btn btn-outline-secondary btn-lg">
                            Cancelar
                        </a>
                        {!! Form::submit('Actualizar contraseña', [
                            'id' => 'btnGuardar',
                            'class' => 'btn btn-admin-dark btn-lg'
                        ]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('js/admin/usuarios/usuarios_edit_password.js') }}"></script>
@endsection