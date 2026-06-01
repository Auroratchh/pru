@extends('layouts.template_reservas')

@section('title', 'Alpha Venus - Reservar clase')

@section('content')

    <div class="reservas-brand text-center mb-3">
        <img src="{{ asset('img/logos/logo-light.png') }}"
             alt="Alpha Venus"
             class="reservas-brand-logo">
    </div>

    <div class="reservas-screen">
        <div class="reservas-screen-body">

        <span class="reservas-step">
            <i class="fa-solid fa-calendar-days"></i>
            Paso 1 de 2
        </span>

            <h1 class="reservas-title">Reserva tu clase</h1>
            <p class="reservas-subtitle">
                Ingresa tu celular, selecciona la fecha y aparta tu lugar. Cupo limitado a 10 personas por horario.
            </p>

            @if(session('error'))
                <div class="alert alert-danger mb-3">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="reservas-form-card">
                <form action="{{ route('reservas.buscar') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date"
                               name="fecha"
                               class="form-control"
                               value="{{ $fecha }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de celular</label>
                        <input type="tel"
                               name="celular"
                               class="form-control"
                               placeholder="Ej. 9611234567"
                               inputmode="numeric"
                               required>
                    </div>

                    <button type="submit" class="btn btn-reservas-primary">
                        <i class="fa-solid fa-arrow-right me-2"></i>
                        Continuar
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection