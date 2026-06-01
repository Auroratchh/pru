@extends('layouts.template_00')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/asistencias.css') }}">
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('/')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{asset('admin')}}">Menu Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reporte de Pagos Pendientes</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-asistencias-page">

            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Pendientes de pago</h1>
                    <p class="admin-page-subtitle">Reporte mensual de cobranza</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-2">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Vence hoy</div>
                            <div class="metric-value metric-value-warning">
                                {{ $totalVenceHoy }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-2">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Vence mañana</div>
                            <div class="metric-value metric-value-warning">
                                {{ $totalVenceManana }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-2">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Vence pronto</div>
                            <div class="metric-value metric-value-soon">
                                {{ $totalVencePronto }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-2">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Vencidos</div>
                            <div class="metric-value metric-value-danger">
                                {{ $totalVencidos }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-2">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Sin vigencia</div>
                            <div class="metric-value metric-value-secondary">
                                {{ $totalSinVigencia }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-2">
                    <div class="metric-card">
                        <div class="card-body">
                            <div class="metric-label">Vigentes</div>
                            <div class="metric-value metric-value-success">
                                {{ $totalVigentes }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="admin-tab-pane-card">
                <div class="admin-tab-pane-header">
                    <div>
                        <h2 class="admin-tab-pane-title">Miembros con pago pendiente o próximo a vencer</h2>
                    </div>
                </div>

                <div class="row py-4">
                    <div class="col-lg-8 px-4">
                        <div class="admin-tab-pane-card mb-4 bg-secondary">
                            <div class="card-body p-4">
                                <form method="GET" action="{{ route('admin.reportes.pagos_pendientes') }}" class="row g-3 align-items-end">
                                    <div class="col-md-5">
                                        <label class="form-label text-white">Filtrar por estatus:</label>
                                        <select name="estatus" class="form-control form-select form-select-lg">
                                            <option value="">Todos</option>
                                            <option value="Vence hoy" {{ request('estatus') === 'Vence hoy' ? 'selected' : '' }}>Vence hoy</option>
                                            <option value="Vence mañana" {{ request('estatus') === 'Vence mañana' ? 'selected' : '' }}>Vence mañana</option>
                                            <option value="Vence pronto" {{ request('estatus') === 'Vence pronto' ? 'selected' : '' }}>Vence pronto</option>
                                            <option value="Vencido" {{ request('estatus') === 'Vencido' ? 'selected' : '' }}>Vencido</option>
                                            <option value="Sin vigencia" {{ request('estatus') === 'Sin vigencia' ? 'selected' : '' }}>Sin vigencia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7 d-flex gap-2">
                                        <button type="submit" class="btn btn-dark btn-lg mr-2">
                                            <i class="fa-solid fa-filter me-2"></i> Buscar
                                        </button>

                                        <a href="{{ route('admin.reportes.pagos_pendientes.exportar', ['estatus' => request('estatus')]) }}" class="btn btn-dark btn-lg"  data-bs-toggle="tooltip" data-bs-placement="top" title="Exportar a Excel" style="margin: 0 2px;">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-admin">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th>Último pago</th>
                            <th>Fecha límite</th>
                            <th>Estatus</th>
                            <th>Referencia</th>
                            <th>Recordar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pendientes as $usuario)
                            <tr>
                                <td class="member-name">{{ $usuario->nombre_completo }}</td>
                                <td class="member-phone">{{ $usuario->celular }}</td>
                                <td class="date-friendly">{{ $usuario->fecha_ultimo_pago_texto }}</td>
                                <td class="date-friendly">{{ $usuario->fecha_vigencia_texto }}</td>
                                <td>
                                    <span class="badge-status {{ $usuario->badge_cobranza }}">
                                        {{ $usuario->estatus_pago }}
                                    </span>
                                </td>
                                <td class="date-friendly">
                                    @if($usuario->estatus_pago === 'Vencido')
                                        {{ $usuario->dias_referencia }} {{ $usuario->dias_referencia == 1 ? 'día' : 'días' }} de atraso
                                    @elseif($usuario->estatus_pago === 'Vence hoy')
                                        Hoy
                                    @elseif($usuario->estatus_pago === 'Vence mañana')
                                        1 día restante
                                    @elseif($usuario->estatus_pago === 'Vence pronto')
                                        {{ $usuario->dias_referencia }} {{ $usuario->dias_referencia == 1 ? 'día' : 'días' }} restantes
                                    @elseif($usuario->estatus_pago === 'Sin vigencia')
                                        Sin vigencia
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                                        $banco      = env('WHATSAPP_BANCO');
                                                        $cuenta     = env('WHATSAPP_CUENTA');
                                                        $titular    = env('WHATSAPP_TITULAR');
                                                        $clabe      = env('WHATSAPP_CLABE');

                                                        $mensaje = "Hola {$usuario->nombre}, 👋\n\n"
                                                        . "Te recordamos tu pago de *Alpha Venus*.\n\n"
                                                        . "📌 *Estatus:* {$usuario->estatus_pago}\n"
                                                        . "📅 *Fecha límite:* {$usuario->fecha_vigencia_texto}\n"
                                                        . (!is_null($usuario->pagoMensualEsperado)
                                                            ? "💰 *Monto:* $" . number_format($usuario->pagoMensualEsperado, 2) . "\n\n"
                                                            : "\n"
                                                        )
                                                        . "Puedes realizar tu pago por transferencia:\n\n"
                                                        . "🏦 *Banco:* {$banco}\n"
                                                        . "🔢 *Cuenta:* {$cuenta}\n"
                                                        . "🔢 *CLABE:* {$clabe}\n"
                                                        . "👤 *Titular:* {$titular}\n\n"
                                                        . "📲 Envíanos tu comprobante por este medio.\n\n"
                                                        . "¡Gracias! 🙌";
                                    @endphp


                                    @php
                                        $telefono = preg_replace('/\D+/', '', $usuario->celular);
                                        $whatsappUrl = 'https://wa.me/52' . $telefono . '?text=' . urlencode($mensaje);
                                    @endphp

                                    @if(Auth::user()->esAdmin())
                                        <a href="{{ $whatsappUrl }}"
                                           target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-whatsapp-share">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="empty-state-title">Sin pendientes</div>
                                        <p class="empty-state-text">No hay pagos pendientes para mostrar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </section>
@endsection
