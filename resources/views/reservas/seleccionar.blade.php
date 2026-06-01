@extends('layouts.template_reservas')

@section('title', 'Alpha Venus - Seleccionar horario')

@section('content')

    <div class="reservas-brand text-center mb-3">
        <img src="{{ asset('img/logos/logo-light.png') }}"
             alt="Alpha Venus"
             class="reservas-brand-logo">
    </div>

    <div class="reservas-screen">
        <div class="reservas-screen-body">
        <span class="reservas-step">
            <i class="fa-solid fa-list-check"></i>
            Paso 2 de 2
        </span>
            @if($fechaCarbon->dayOfWeek === \Carbon\Carbon::SATURDAY)
                <div class="alert alert-success mb-3">
                    <i class="fa-solid fa-star me-2"></i>
                    Hoy solo está disponible la clase especial de sábado.
                </div>
            @endif

            <h1 class="reservas-title">Elige tu horario</h1>
            <p class="reservas-subtitle">
                Selecciona el bloque que deseas apartar para el {{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}.
            </p>

            <div class="reservas-user-box">
                <div class="reservas-user-name">{{ $usuario->nombre_completo }}</div>
                <p class="reservas-user-meta mb-3">Celular: {{ $usuario->celular }}</p>

                <ul class="reservas-info-list">
                    <li>
                        <span class="reservas-info-label">Último pago</span>
                        <span class="reservas-info-value">{{ $usuario->fecha_ultimo_pago_texto }}</span>
                    </li>
                    <li>
                        <span class="reservas-info-label">Fecha límite</span>
                        <span class="reservas-info-value">{{ $usuario->fecha_vigencia_texto }}</span>
                    </li>
                    <li>
                        <span class="reservas-info-label">Estatus</span>
                        <span class="reservas-info-value">{{ $usuario->estatus_vigencia }}</span>
                    </li>
                </ul>
            </div>

            @if(!$puedeReservar)
                <div class="alert alert-danger mb-3">
                    Tu membresía no está vigente para reservar en esta fecha.
                </div>
            @elseif($yaTieneReservaEseDia)
                <div class="alert alert-danger mb-3">
                    Ya cuentas con una reserva para esta fecha.
                </div>
            @endif

            @foreach($bloques as $bloque)
                @php
                    $lleno = $bloque->disponibles <= 0;
                    $ultimos = $bloque->disponibles > 0 && $bloque->disponibles <= 3;
                    $bloqueado = !$puedeReservar || $yaTieneReservaEseDia || $lleno || $bloque->usuario_ya_reservo;
                @endphp

                <div class="reservas-block-card">
                    <div class="reservas-block-title">{{ $bloque->nombreClase }}</div>
                    <div class="reservas-block-time">{{ $bloque->hora_texto }}</div>
                    <div class="reservas-block-meta">
                        Reservados: {{ $bloque->reservados }}/{{ $bloque->cupoMaximo }} ·
                        Disponibles: {{ $bloque->disponibles }}
                    </div>

                    @if($lleno)
                        <div class="reservas-badge reservas-badge-danger">Lleno</div>
                    @elseif($ultimos)
                        <div class="reservas-badge reservas-badge-warning">Últimos lugares</div>
                    @else
                        <div class="reservas-badge reservas-badge-success">Disponible</div>
                    @endif

                    @if($bloqueado)
                        <button type="button" class="btn btn-reservas-disabled">
                            No disponible
                        </button>
                    @else
                        <form action="{{ route('reservas.guardar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idUsuario" value="{{ $usuario->idUsuario }}">
                            <input type="hidden" name="idClaseBloque" value="{{ $bloque->idClaseBloque }}">
                            <input type="hidden" name="fechaClase" value="{{ $fecha }}">

                            <button type="submit" class="btn btn-reservas-primary">
                                Reservar lugar
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach

            <div class="mt-3">
                <a href="{{ route('reservas.index', ['fecha' => $fecha]) }}" class="btn btn-reservas-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
@endsection