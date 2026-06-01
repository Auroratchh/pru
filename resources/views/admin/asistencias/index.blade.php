@extends('layouts.template_00')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/asistencias.css') }}">
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Menú Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Asistencias</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-asistencias-page">

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

            <div class="admin-page-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                    <div>
                        <h1 class="admin-page-title">Control de asistencias</h1>
                        <p class="admin-page-subtitle">
                            Resumen del día {{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-lg-row gap-2 align-items-stretch align-items-lg-center">
                        <form method="GET" action="{{ route('admin.asistencias.index') }}" class="admin-filter-box d-flex gap-2 align-items-center">
                            <input type="date" name="fecha" class="form-control" value="{{ $fecha }}">
                            <button type="submit" class="btn btn-admin-primary">
                                <i class="fa-solid fa-filter me-1"></i>Filtrar
                            </button>
                        </form>

                        @if(!$diaCerrado)
                            <form method="POST" action="{{ route('admin.asistencias.cerrarDia') }}" onsubmit="return confirm('¿Deseas cerrar el día? Las reservas pendientes se marcarán como no asistió.');">
                                @csrf
                                <input type="hidden" name="fecha" value="{{ $fecha }}">
                                <button type="submit" class="btn btn-outline-light admin-close-day-btn">
                                    <i class="fa-solid fa-lock me-2"></i>Cerrar día
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-outline-light admin-close-day-btn" disabled>
                                <i class="fa-solid fa-check me-2"></i>Día cerrado
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Total miembros</div>
                            <div class="metric-value metric-value-primary">{{ $totalMiembros }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Asistieron</div>
                            <div class="metric-value metric-value-success">{{ $totalAsistieron }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">No Asistieron Con / Sin reserva</div>
                            <div class="metric-inline">
                                <span class="text-danger">{{ $totalNoAsistieronConReserva }}</span>
                                <span class="text-muted"> / </span>
                                <span class="text-primary">{{ $totalNoAsistieronSinReserva }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Vigentes / Vencidos</div>
                            <div class="metric-inline">
                                <span class="text-success">{{ $vigentes }}</span>
                                <span class="text-muted"> / </span>
                                <span class="text-danger">{{ $vencidos }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-tabs-wrap">
                <ul class="nav admin-tabs-nav" id="asistenciasTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                                class="nav-link active"
                                id="asistieron-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#asistieron-pane"
                                type="button"
                                role="tab"
                                aria-controls="asistieron-pane"
                                aria-selected="true"
                        >
                            <i class="fa-solid fa-calendar-check me-2"></i>
                            Asistieron
                            <span class="admin-tab-count">{{ $asistieron->count() }}</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                                class="nav-link"
                                id="no-show-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#no-show-pane"
                                type="button"
                                role="tab"
                                aria-controls="no-show-pane"
                                aria-selected="false"
                        >
                            <i class="fa-solid fa-user-clock me-2"></i>
                            No asistieron con reserva
                            <span class="admin-tab-count">{{ $noAsistieronConReserva->count() }}</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                                class="nav-link"
                                id="sin-reserva-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#sin-reserva-pane"
                                type="button"
                                role="tab"
                                aria-controls="sin-reserva-pane"
                                aria-selected="false"
                        >
                            <i class="fa-solid fa-user-xmark me-2"></i>
                            No asistieron sin reserva
                            <span class="admin-tab-count">{{ $noAsistieronSinReserva->count() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="asistenciasTabsContent">

                <div class="tab-pane fade show active" id="asistieron-pane" role="tabpanel" aria-labelledby="asistieron-tab" tabindex="0">
                    <div class="admin-tab-pane-card">
                        <div class="admin-tab-pane-header">
                            <div>
                                <h2 class="admin-tab-pane-title">Miembros que sí asistieron</h2>
                                <p class="admin-tab-pane-subtitle">
                                    Registros confirmados para {{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}
                                </p>
                            </div>

                            <span class="admin-summary-chip admin-summary-chip-success">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ $asistieron->count() }} asistencia(s)
                        </span>
                        </div>

                        @if($asistieron->count())
                            <div class="table-responsive">
                                <table class="table table-admin">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Hora llegada</th>
                                        <th>Reservó</th>
                                        <th>Clase / Horario</th>
                                        <th>Último pago</th>
                                        <th>Fecha límite</th>
                                        <th>Estatus</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($asistieron as $asistencia)
                                        <tr>
                                            <td class="member-name">{{ $asistencia->usuario->nombre_completo }}</td>
                                            <td class="member-phone">{{ $asistencia->usuario->celular }}</td>
                                            <td>
                                                <span class="arrival-time">
                                                    <i class="fa-regular fa-clock"></i>
                                                    {{ $asistencia->hora_asistencia_texto }}
                                                </span>
                                            </td>
                                            <td class="reserva-status">
                                                @if($asistencia->reserva)
                                                    <span class="badge-status badge-status-success">Sí reservó</span>
                                                @else
                                                    <span class="badge-status badge-status-secondary">Sin reserva</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($asistencia->reserva && $asistencia->reserva->bloque)
                                                    <span class="reserva-block-name">{{ $asistencia->reserva->bloque->nombreClase }}</span>
                                                    <span class="reserva-block-time">{{ $asistencia->reserva->bloque->hora_texto }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="date-friendly">{{ $asistencia->usuario->fecha_ultimo_pago_texto }}</td>
                                            <td class="date-friendly">{{ $asistencia->usuario->fecha_vigencia_texto }}</td>
                                            <td>
                                                <span class="badge-status {{ $asistencia->usuario->badge_vigencia }}">
                                                    {{ $asistencia->usuario->estatus_vigencia }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div class="empty-state-title">Sin asistencias registradas</div>
                                <p class="empty-state-text">No hay registros para la fecha seleccionada.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="no-show-pane" role="tabpanel" aria-labelledby="no-show-tab" tabindex="0">
                    <div class="admin-tab-pane-card">
                        <div class="admin-tab-pane-header">
                            <div>
                                <h2 class="admin-tab-pane-title">No asistieron pero sí reservaron</h2>
                                <p class="admin-tab-pane-subtitle">
                                    Personas que apartaron lugar y no llegaron el {{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}
                                </p>
                            </div>

                            <span class="admin-summary-chip admin-summary-chip-danger">
                            <i class="fa-solid fa-user-clock"></i>
                            {{ $noAsistieronConReserva->count() }} No asistieron
                        </span>
                        </div>

                        @if($noAsistieronConReserva->count())
                            <div class="table-responsive">
                                <table class="table table-admin">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Clase</th>
                                        <th>Horario</th>
                                        <th>Último pago</th>
                                        <th>Fecha límite</th>
                                        <th>Estatus</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($noAsistieronConReserva as $reserva)
                                        <tr>
                                            <td class="member-name">{{ $reserva->usuario->nombre_completo }}</td>
                                            <td class="member-phone">{{ $reserva->usuario->celular }}</td>
                                            <td class="date-friendly">{{ $reserva->bloque?->nombreClase ?? '—' }}</td>
                                            <td class="date-friendly">{{ $reserva->bloque?->hora_texto ?? '—' }}</td>
                                            <td class="date-friendly">{{ $reserva->usuario->fecha_ultimo_pago_texto }}</td>
                                            <td class="date-friendly">{{ $reserva->usuario->fecha_vigencia_texto }}</td>
                                            <td>
                                                <span class="badge-status badge-status-danger">No asistió</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <div class="empty-state-title">Sin no-shows</div>
                                <p class="empty-state-text">Nadie reservó y faltó en esta fecha.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="sin-reserva-pane" role="tabpanel" aria-labelledby="sin-reserva-tab" tabindex="0">
                    <div class="admin-tab-pane-card">
                        <div class="admin-tab-pane-header">
                            <div>
                                <h2 class="admin-tab-pane-title">No asistieron y no reservaron</h2>
                                <p class="admin-tab-pane-subtitle">
                                    Miembros que no llegaron ni apartaron lugar el {{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}
                                </p>
                            </div>

                            <span class="admin-summary-chip admin-summary-chip-primary">
                            <i class="fa-solid fa-user-xmark"></i>
                            {{ $noAsistieronSinReserva->count() }} faltante(s)
                        </span>
                        </div>

                        @if($noAsistieronSinReserva->count())
                            <div class="table-responsive">
                                <table class="table table-admin">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Último pago</th>
                                        <th>Fecha límite</th>
                                        <th>Estatus</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($noAsistieronSinReserva as $usuario)
                                        <tr>
                                            <td class="member-name">{{ $usuario->nombre_completo }}</td>
                                            <td class="member-phone">{{ $usuario->celular }}</td>
                                            <td class="date-friendly">{{ $usuario->fecha_ultimo_pago_texto }}</td>
                                            <td class="date-friendly">{{ $usuario->fecha_vigencia_texto }}</td>
                                            <td>
                                                <span class="badge-status {{ $usuario->badge_vigencia }}">
                                                    {{ $usuario->estatus_vigencia }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <div class="empty-state-title">Todos participaron</div>
                                <p class="empty-state-text">No hay miembros en este grupo para la fecha seleccionada.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection