@extends('layouts.template_asistencias')

@section('title', 'Alpha Venus - Asistencia registrada')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">
            <div class="attendance-card">
                <div class="attendance-card-body text-center">
                    <div class="attendance-success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h1 class="attendance-member-name mb-3">¡Asistencia registrada!</h1>

                    <p class="attendance-member-meta mb-4">
                        Tu llegada ha sido registrada correctamente. Que tengas una gran sesión en Alpha Venus.
                    </p>

                    <a href="{{ route('asistencia.index') }}" class="btn btn-attendance-primary w-100">
                        <i class="fa-solid fa-rotate-right me-2"></i>Registrar otra asistencia
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection