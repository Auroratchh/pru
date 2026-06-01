@extends('layouts.template_00')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/reservas.css') }}">
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Menú Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reservas</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content" style="padding-top: 10px;">
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

                <div class="d-flex justify-content-end mb-3">
                    @php
                        $linkReservas = route('reservas.index', ['fecha' => $fecha]);

                        $mensajeWhatsapp = "Hola, ya puedes reservar tu lugar en Alpha Venus para el "
                            . $fechaCarbon->translatedFormat('d \d\e F \d\e Y')
                            . ".\n\n"
                            . "Recuerda que el cupo es limitado a 10 personas por horario.\n\n"
                            . "Reserva aquí:\n"
                            . $linkReservas;

                        $whatsAppUrl = 'https://wa.me/?text=' . urlencode($mensajeWhatsapp);
                    @endphp

                    <a href="{{ $whatsAppUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn btn-whatsapp-share">
                        <i class="fa-brands fa-whatsapp me-2"></i>Compartir por WhatsApp
                    </a>
                </div>



            <div class="admin-page-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                    <div>
                        <h1 class="admin-page-title">Control de reservas</h1>
                        <p class="admin-page-subtitle">
                            Resumen del día {{ $fechaCarbon->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                    </div>

                    <form method="GET" action="{{ route('admin.reservas.index') }}" class="admin-filter-box d-flex gap-2 align-items-center">
                        <input type="date" name="fecha" class="form-control" value="{{ $fecha }}">
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fa-solid fa-filter me-1"></i>Filtrar
                        </button>
                    </form>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Bloques del día</div>
                            <div class="metric-value metric-value-primary">{{ $totalBloques }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Reservas</div>
                            <div class="metric-value metric-value-success">{{ $totalReservas }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Disponibles</div>
                            <div class="metric-value metric-value-danger">{{ $totalDisponibles }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Capacidad total</div>
                            <div class="metric-inline metric-inline-highlight">
                                <i class="fa-solid fa-users me-2"></i>
                                {{ $capacidadTotal }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach($bloques as $bloque)
                    @php
                        $hora = \Carbon\Carbon::parse($bloque->horaInicio)->format('H');

                        if ($hora < 12) {
                            $bgClass = 'bloque-manana';
                        } elseif ($hora < 18) {
                            $bgClass = 'bloque-tarde';
                        } else {
                            $bgClass = 'bloque-noche';
                        }
                    @endphp

                    <div class="col-lg-6">
                        <div class="admin-section-card">
                            <div class="admin-section-header {{ $bgClass }}">
                                <div>
                                    <h2 class="admin-section-title">{{ $bloque->nombreClase }}</h2>
                                    <span class="admin-section-time">{{ $bloque->hora_texto }}</span>
                                </div>

                                <span class="admin-section-count">
                                {{ $bloque->total_reservas }}/{{ $bloque->cupoMaximo }}
                            </span>
                            </div>

                            <div class="px-4 pt-3">
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Ocupación</span>
                                    <span>{{ $bloque->ocupacion_porcentaje }}%</span>
                                </div>

                                <div class="progress" style="height: 10px; border-radius: 999px;">
                                    <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: {{ $bloque->ocupacion_porcentaje }}%; background: #7B53B3;"
                                            aria-valuenow="{{ $bloque->ocupacion_porcentaje }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-3 mb-2 small">
                                    <span class="text-muted">Reservados: <strong>{{ $bloque->total_reservas }}</strong></span>
                                    <span class="text-muted">Disponibles: <strong>{{ $bloque->disponibles }}</strong></span>
                                </div>
                            </div>

                            @if($bloque->reservas_del_dia->count())
                                <div class="table-responsive">
                                    <table class="table table-admin">
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Celular</th>
                                            <th>Vigencia</th>
                                            <th>Reserva</th>
                                            <th class="text-end">Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($bloque->reservas_del_dia as $reserva)
                                            <tr>
                                                <td class="member-name">{{ $reserva->usuario->nombre_completo }}</td>
                                                <td class="member-phone">{{ $reserva->usuario->celular }}</td>
                                                <td>
                                                    <span class="badge-status {{ $reserva->usuario->badge_vigencia }}">
                                                        {{ $reserva->usuario->estatus_vigencia }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge-status {{ $reserva->badge_reserva_class }}">
                                                        {{ $reserva->estatus_texto }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    @if($reserva->estatus === 'reservada')
                                                        <form action="{{ route('admin.reservas.cancelar', $reserva->idReservaClase) }}" method="POST" onsubmit="return confirm('¿Deseas cancelar esta reserva?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                Cancelar
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted small">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fa-solid fa-calendar-xmark"></i>
                                    </div>
                                    <div class="empty-state-title">Sin reservas</div>
                                    <p class="empty-state-text">Este bloque no tiene reservas para la fecha seleccionada.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection