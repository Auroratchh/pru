@extends('layouts.template_asistencias')

@section('title', 'Alpha Venus - Registrar asistencia')

@section('content')
    <div class="row g-4 align-items-center">
        <div class="col-lg-6">
            <div class="attendance-card">
                <div class="attendance-card-body">
                    <div class="attendance-brand-block">
                        <img src="{{ asset('img/logos/logo-light.png') }}" alt="Alpha Venus" class="attendance-brand-logo">
                    </div>

                    <span class="attendance-badge">
                    <i class="fa-solid fa-bolt"></i>
                    Check-in rápido
                </span>

                    <h1 class="attendance-title">Registra tu asistencia en segundos</h1>

                    <p class="attendance-subtitle">
                        Ingresa tu número de celular para identificarte y confirmar tu llegada de forma rápida, clara y sin complicaciones.
                    </p>

                    <ul class="attendance-info-list">
                        <li>
                            <i class="fa-solid fa-mobile-screen-button"></i>
                            Proceso simple y directo
                        </li>
                        <li>
                            <i class="fa-solid fa-clock"></i>
                            Registro inmediato con hora exacta
                        </li>
                        <li>
                            <i class="fa-solid fa-shield-halved"></i>
                            Solo se muestra la información necesaria
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="attendance-panel">
                <div class="attendance-form-logo-wrap">
                    <img src="{{ asset('img/logos/logo-light.png') }}" alt="Alpha Venus" class="attendance-form-logo">
                </div>

                <h2 class="attendance-panel-title">Registrar asistencia</h2>
                <p class="attendance-panel-text">Ingresa tu número de celular para continuar.</p>

                @if(session('success'))
                    <div class="alert alert-success mb-3">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mb-3">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('asistencia.buscar') }}" method="POST" id="formBuscarAsistencia">
                    @csrf

                    <div class="mb-3">
                        <label for="celular" class="form-label">Número de celular</label>
                        <input
                                type="text"
                                class="form-control"
                                id="celular"
                                name="celular"
                                placeholder="Ej. 9611234567"
                                autocomplete="off"
                                inputmode="numeric"
                                required
                        >
                    </div>

                    <button type="submit" class="btn btn-attendance-primary w-100">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Buscar mi registro
                    </button>
                </form>

                <div class="attendance-footer-note">
                    Alpha Venus · Functional Training & Weightlifting
                </div>
            </div>
        </div>
    </div>
@endsection