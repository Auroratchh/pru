@extends('layouts.template_00')

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Administración</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin/programaciones') }}">Programación</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pizarra</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container">
            <div class="card shadow border-dark mb-5">
                <div class="card-header bg-dark text-white p-4 text-center border-bottom border-warning border-3">
                    <h1 class="display-5 mb-0 font-weight-bold text-uppercase tracking-wide">{{ $programacion->diaPlan }}</h1>
                    <p class="lead mb-0 text-warning font-monospace">{{ \Carbon\Carbon::parse($programacion->fecha)->format('l, d F Y') }}</p>
                </div>
                <div class="card-body p-4 bg-light">
                    @foreach($programacion->configuraciones as $conf)
                        <div class="card mb-4 shadow-sm border-0 rounded-3">
                            <div class="card-body p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary p-2 fs-6 font-monospace me-3 text-uppercase shadow-sm">{{ $conf->tiposEntrenamientos }}</span>
                                    <h3 class="mb-0 font-weight-bold text-secondary text-uppercase tracking-tight">{{ $conf->etapa->nombre ?? 'Bloque' }}</h3>
                                </div>

                                @if($conf->rounds || $conf->tiempoTotal || $conf->tiempoTrabajo || $conf->tiempoDescanso)
                                    <div class="row bg-light p-3 rounded g-2 text-center mx-0 mb-3 border font-monospace small">
                                        @if($conf->rounds) <div class="col-6 col-md-3"><strong>ROUNDS:</strong><br><span class="fs-6 text-primary fw-bold">{{ $conf->rounds }}</span></div> @endif
                                        @if($conf->tiempoTotal) <div class="col-6 col-md-3"><strong>TIEMPO TOTAL:</strong><br><span class="fs-6 text-dark fw-bold">{{ $conf->tiempoTotal }}</span></div> @endif
                                        @if($conf->tiempoTrabajo) <div class="col-6 col-md-3"><strong>TRABAJO:</strong><br><span class="fs-6 text-success fw-bold">{{ $conf->tiempoTrabajo }}</span></div> @endif
                                        @if($conf->tiempoDescanso) <div class="col-6 col-md-3"><strong>DESCANSO:</strong><br><span class="fs-6 text-danger fw-bold">{{ $conf->tiempoDescanso }}</span></div> @endif
                                    </div>
                                @endif

                                <div class="bg-dark text-warning p-3 rounded-2 font-monospace fs-5 mb-3 shadow-sm border-start border-warning border-4">
                                    <i class="fa-solid fa-chalkboard-user me-2"></i> {{ $conf->descripcion }}
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle bg-white mb-0">
                                        <thead class="table-secondary text-center small text-uppercase fw-bold">
                                            <tr>
                                                <th class="text-start ps-3">Movimiento / Ejercicio</th>
                                                <th style="width: 15%;">Estructura Sets</th>
                                                <th style="width: 18%;">Carga Objetivo</th>
                                                <th class="text-start ps-3">Notas Clave</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($conf->ejerciciosDetalle as $det)
                                                <tr>
                                                    <td class="font-weight-bold fs-6 text-dark ps-3">
                                                        <i class="fa-solid fa-circle-play text-muted me-2 small"></i>{{ $det->ejercicio->ejercicio ?? 'N/A' }}
                                                    </td>
                                                    <td class="text-center font-monospace fw-bold text-secondary">
                                                        @if($det->series) {{ $det->series }}s @endif
                                                        @if($det->reps) x {{ $det->reps }}r @endif
                                                    </td>
                                                    <td class="text-center font-monospace bg-light text-primary fw-bold">
                                                        {{ $det->pesoInicial ?? '0' }} -> {{ $det->pesoFinal ?? '0' }}
                                                    </td>
                                                    <td class="text-muted small ps-3">
                                                        @if($det->notas)
                                                            <span class="text-secondary"><i class="fa-solid fa-comment-dots me-1 text-xs"></i> {{ $det->notas }}</span>
                                                        @else
                                                            <span class="text-neutral-400 font-italic">Sin comentarios adicionales.</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white text-end p-3 border-top">
                    <a href="{{ asset('admin/programaciones') }}" class="btn btn-secondary shadow-sm">
                        <i class="fa-solid fa-arrow-left"></i> Regresar al Calendario
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection