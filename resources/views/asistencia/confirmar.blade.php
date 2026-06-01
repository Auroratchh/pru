@extends('layouts.template_asistencias')

@section('title', 'Alpha Venus - Confirmar llegada')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="attendance-card">
                <div class="attendance-card-body">
                    <div class="text-center mb-4">
                    <span class="attendance-badge">
                        <i class="fa-solid fa-user-check"></i>
                        Confirmación de llegada
                    </span>

                        <h1 class="attendance-member-name">{{ $usuario->nombre_completo }}</h1>

                        <p class="attendance-member-meta mb-0">
                            Celular con terminación en {{ substr(preg_replace('/\D+/', '', $usuario->celular), -4) }}
                        </p>
                    </div>

                    <div class="attendance-detail-box mb-4">
                        @php
                            use Carbon\Carbon;
                            Carbon::setLocale('es');
                        @endphp
                        <div class="attendance-detail-row">
                            <span class="attendance-detail-label">Último pago</span>
                            <span class="attendance-detail-value">
                            {{ $fechaUltimoPago ? $fechaUltimoPago->translatedFormat('d \d\e F \d\e Y') : 'Sin registro' }}
                        </span>
                        </div>

                        <div class="attendance-detail-row">
                            <span class="attendance-detail-label">Fecha límite de pago</span>
                            <span class="attendance-detail-value">
                            {{ $fechaVigencia ? $fechaVigencia->translatedFormat('d \d\e F \d\e Y') : 'Sin vigencia' }}
                        </span>
                        </div>

                        <div class="attendance-detail-row">
                            <span class="attendance-detail-label">Estatus</span>
                            <span class="attendance-status
                            @if($estatusPago === 'Vigente') status-ok
                            @elseif($estatusPago === 'Vence hoy') status-warning
                            @else status-danger
                            @endif">
                            {{ $estatusPago }}
                        </span>
                        </div>
                    </div>

                    @if($yaRegistroHoy)
                        <div class="alert alert-danger mb-4">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            Ya registraste tu asistencia el día de hoy.
                        </div>
                    @elseif(!$puedeRegistrar)
                        <div class="alert alert-danger mb-4">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            No es posible registrar tu asistencia porque tu membresía no está vigente. Acude a recepción para regularizar tu acceso.
                        </div>
                    @elseif($estatusPago === 'Vence hoy')
                        <div class="alert alert-warning-custom mb-4">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            Tu membresía vence hoy. Puedes registrar tu asistencia, pero es importante renovar tu pago.
                        </div>
                    @endif

                    @if($puedeRegistrar && !$yaRegistroHoy)
                        <form action="{{ route('asistencia.guardar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idUsuario" value="{{ $usuario->idUsuario }}">

                            <button type="submit" class="btn btn-attendance-primary w-100 mb-3">
                                <i class="fa-solid fa-check me-2"></i>Registrar llegada
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn btn-attendance-disabled w-100 mb-3" disabled>
                            <i class="fa-solid fa-ban me-2"></i>No disponible
                        </button>
                    @endif

                    <a href="{{ route('asistencia.index') }}" class="btn btn-attendance-secondary w-100">
                        <i class="fa-solid fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection