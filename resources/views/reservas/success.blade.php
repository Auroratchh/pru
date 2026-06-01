@extends('layouts.template_reservas')

@section('title', 'Alpha Venus - Reserva confirmada')

@section('content')
    <div class="reservas-brand text-center mb-3">
        <img src="{{ asset('img/logos/logo-light.png') }}"
             alt="Alpha Venus"
             class="reservas-brand-logo">
    </div>

    <div class="reservas-screen">
        <div class="reservas-screen-body text-center">
            <div class="reservas-success-icon">
                <i class="fa-solid fa-check"></i>
            </div>

            <h1 class="reservas-title mb-3">¡Reserva confirmada!</h1>

            @if($usuario && $bloque && $fechaCarbon)
                <p class="reservas-subtitle mb-2">{{ $usuario->nombre_completo }}</p>
                <p class="reservas-subtitle mb-2">{{ $bloque->nombreClase }}</p>
                <p class="reservas-subtitle mb-2">{{ $bloque->hora_texto }}</p>
                <p class="reservas-subtitle mb-4">{{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}</p>
            @endif

            <a href="{{ route('reservas.index') }}" class="btn btn-reservas-primary">
                Finalizar
            </a>
        </div>
    </div>
@endsection