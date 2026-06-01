@extends('layouts.template_00')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Menú Administración</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/usuarios') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuario {{ $usuario->idUsuario }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-usuarios-page">

            @if (session('status_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('status_success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('status_fail'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {!! session('status_fail') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="user-show-hero mb-4">
                <div class="user-show-hero-content">
                    <div>
                        <div class="user-show-id">ID {{ $usuario->idUsuario }}</div>
                        <h1 class="user-show-title">{{ $usuario->nombre_completo }}</h1>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge-status {{ $usuario->badge_membresia }}">
                            {{ $usuario->estatus_membresia }}
                        </span>

                            <span class="user-show-meta-chip">
                            <i class="fa-solid fa-dumbbell me-2"></i>
                            {{ $usuario->membresia?->nombre ?? 'Sin membresía' }}
                        </span>

                            <span class="user-show-meta-chip">
                            <i class="fa-solid fa-phone me-2"></i>
                            {{ $usuario->celular }}
                        </span>
                        </div>
                    </div>

                    <div class="user-show-actions">
                        <a class="btn btn-admin-dark" href="{{ url('admin/usuarios/' . $usuario->idUsuario . '/edit') }}">
                            <i class="fa-solid fa-user-pen me-2"></i>Editar
                        </a>

                        <a class="btn btn-admin-success" href="{{ url('admin/usuarios/' . $usuario->idUsuario . '/create_pago') }}">
                            <i class="fa-solid fa-plus me-2"></i>Registrar pago
                        </a>

                        @auth
                            @if(auth()->user()->esAdmin() && $usuario->eliminado == 0)
                                {!! Form::open([
                                    'url' => 'admin/usuarios/' . $usuario->idUsuario,
                                    'method' => 'DELETE',
                                    'class' => 'd-inline formDeleteUsuario'
                                ]) !!}
                                <button type="button" class="btn btn-admin-danger btnDeleteUsuario">
                                    <i class="fa-solid fa-trash me-2"></i>Eliminar
                                </button>
                                {!! Form::close() !!}
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Pago esperado</div>
                            <div class="admin-summary-value admin-summary-value-primary">
                                @if(!is_null($usuario->pagoMensualEsperado))
                                    ${{ number_format($usuario->pagoMensualEsperado, 2) }}
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Último pago</div>
                            <div class="admin-summary-value admin-summary-value-success">
                                @if(!is_null($usuario->monto_ultimo_pago))
                                    ${{ number_format($usuario->monto_ultimo_pago, 2) }}
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Vigencia</div>
                            <div class="admin-summary-value admin-summary-value-primary" style="font-size:1.25rem;">
                                {{ $usuario->fecha_vigencia_texto }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Comparativo</div>
                            <div class="d-flex flex-column gap-2">
                            <span class="badge-status {{ $usuario->badge_pago }}">
                                {{ $usuario->estado_pago }}
                            </span>

                                @if(!is_null($usuario->diferencia_pago))
                                    <div class="small {{ $usuario->diferencia_pago < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $usuario->diferencia_pago > 0 ? '+' : '' }}${{ number_format($usuario->diferencia_pago, 2) }}
                                    </div>
                                @else
                                    <div class="small text-muted">Sin referencia</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="user-detail-card">
                        <div class="user-detail-card-header">
                            <h3 class="user-detail-card-title">Información personal</h3>
                        </div>
                        <div class="user-detail-card-body">
                            <dl class="user-detail-list mb-0">
                                <div class="user-detail-row">
                                    <dt>Nombre</dt>
                                    <dd>{{ $usuario->nombre_completo }}</dd>
                                </div>
                                <div class="user-detail-row">
                                    <dt>Fecha nacimiento</dt>
                                    <dd>{{ \Carbon\Carbon::parse($usuario->fechaNacimiento)->format('d/m/Y') }}</dd>
                                </div>
                                <div class="user-detail-row">
                                    <dt>Sexo</dt>
                                    <dd>{{ $usuario->sexo }}</dd>
                                </div>
                                <div class="user-detail-row">
                                    <dt>Celular</dt>
                                    <dd>{{ $usuario->celular }}</dd>
                                </div>
                                <div class="user-detail-row">
                                    <dt>Email</dt>
                                    <dd>{{ $usuario->email }}</dd>
                                </div>
                                <div class="user-detail-row">
                                    <dt>Miembro desde</dt>
                                    <dd>{{ $usuario->created_at ? \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') : '—' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="user-detail-card">
                        <div class="user-detail-card-header d-flex justify-content-between align-items-center">
                            <h3 class="user-detail-card-title mb-0">Acceso al sistema</h3>

                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-admin-success btn-send-password"
                                   href="{{ url('admin/usuarios/send_password/' . $usuario->idUsuario) }}"
                                   data-bs-toggle="tooltip"
                                   data-bs-title="Enviar contraseña">
                                    <i class="fa-solid fa-envelope-circle-check me-1"></i>Enviar
                                </a>

                                <a class="btn btn-sm btn-admin-dark"
                                   href="{{ url('admin/usuarios/' . $usuario->idUsuario . '/edit_password') }}">
                                    <i class="fa-solid fa-key me-1"></i>Cambiar
                                </a>
                            </div>
                        </div>

                        <div class="user-detail-card-body">
                            <dl class="user-detail-list mb-0">
                                <div class="user-detail-row">
                                    <dt>Email</dt>
                                    <dd>{{ $usuario->email }}</dd>
                                </div>
                                <div class="user-detail-row">
                                    <dt>Contraseña visible</dt>
                                    <dd>{{ $usuario->passwordVisible }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

            </div>

            <div class="user-detail-card mt-4">
                <div class="user-detail-card-header d-flex justify-content-between align-items-center">
                    <h3 class="user-detail-card-title mb-0">Historial de pagos</h3>

                    <a class="btn btn-admin-success" href="{{ url('admin/usuarios/' . $usuario->idUsuario . '/create_pago') }}">
                        <i class="fa-solid fa-plus me-2"></i>Registrar pago
                    </a>
                </div>

                <div class="user-detail-card-body p-0">
                    <div class="table-responsive">
                        @php
                            $banco      = env('WHATSAPP_BANCO');
                            $cuenta     = env('WHATSAPP_CUENTA');
                            $titular    = env('WHATSAPP_TITULAR');
                            $clabe      = env('WHATSAPP_CLABE');

                        @endphp
                        <table class="table table-admin-users mb-0">
                            <thead>
                            <tr>
                                <th>Fecha pago</th>
                                <th>Vigencia</th>
                                <th>Membresía</th>
                                <th>Monto</th>
                                <th>Forma pago</th>
                                <th class="text-center">Notificar</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($pagos as $pago)
                                <tr>
                                    <td class="user-date">{{ date('d/m/Y', strtotime($pago->fechaPago)) }}</td>
                                    <td class="user-date">{{ date('d/m/Y', strtotime($pago->fechaVigencia)) }}</td>
                                    <td>
                                        @if($pago->nombreMembresia)
                                            <span class="badge bg-light text-dark border">
                                                {{ $pago->nombreMembresia }}
                                            </span>
                                        @else
                                            —
                                        @endif
                                    </td>

                                    @php
                                        $diff = null;
                                        if(!is_null($usuario->pagoMensualEsperado)) {
                                            $diff = $pago->monto - $usuario->pagoMensualEsperado;
                                        }
                                    @endphp

                                    <td class="user-amount">
                                        ${{ number_format($pago->monto, 2) }}

                                        @if(!is_null($diff))
                                            <div class="small {{ $diff < 0 ? 'text-danger' : ($diff > 0 ? 'text-success' : 'text-muted') }}">
                                                {{ $diff > 0 ? '+' : '' }}${{ number_format($diff, 2) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $pago->formaPago }}</td>

                                    <td class="text-center">
                                        @php
                                            $banco = config('whatsapp.banco');
                                            $cuenta = config('whatsapp.cuenta');
                                            $clabe = config('whatsapp.clabe');
                                            $titular = config('whatsapp.titular');

                                            $telefono = preg_replace('/\D+/', '', $usuario->celular);

                                            $emojiSaludo = "\u{1F44B}";
                                            $emojiCheck = "\u{2705}";
                                            $emojiCalendario = "\u{1F4C5}";
                                            $emojiAlerta = "\u{26A0}\u{FE0F}";
                                            $emojiBanco = "\u{1F3E6}";
                                            $emojiNumeros = "\u{1F522}";
                                            $emojiPersona = "\u{1F464}";
                                            $emojiMensaje = "\u{1F4F2}";
                                            $emojiFuerza = "\u{1F4AA}";


                                            $mensaje = "Hola {$usuario->nombre},\n\n"
                                                . "Tu membresía *" . ($pago->nombreMembresia ?? $usuario->membresia?->nombre ?? 'Alpha Venus') . "* ha sido renovada exitosamente.\n\n"
                                                . "Vigencia hasta: *" . \Carbon\Carbon::parse($pago->fechaVigencia)->format('d/m/Y') . "*\n\n"
                                                . "Recuerda realizar tu pago a tiempo a fin de evitar penalizaciones:\n\n"
                                                . "\$50 a los 5 días después del vencimiento\n"
                                                . "\$100 a partir del 6to día de vencimiento\n\n"
                                                . "Banco: {$banco}\n"
                                                . "Cuenta: {$cuenta}\n"
                                                . "CLABE: {$clabe}\n"
                                                . "Titular: {$titular}\n\n"
                                                . "Envíanos tu comprobante por este medio.\n\n"
                                                . "Gracias por ser parte de Alpha Venus.";

                                            $whatsappUrl = 'https://wa.me/52' . $telefono . '?text=' . rawurlencode($mensaje);
                                        @endphp

                                        <a href="{{ $whatsappUrl }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-sm btn-action btn-action-whatsapp"
                                           data-bs-toggle="tooltip"
                                           data-bs-title="Notificar por WhatsApp">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        @auth
                                            @if(auth()->user()->esAdmin())
                                                {!! Form::open([
                                                    'url' => 'admin/usuarios/' . $usuario->idUsuario . '/pago/' . $pago->idPago . '/delete',
                                                    'method' => 'DELETE',
                                                    'class' => 'formDeleteEvento d-inline',
                                                ]) !!}
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger btnDelete"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Eliminar pago">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            @endif
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fa-solid fa-money-bill-wave"></i>
                                            </div>
                                            <div class="empty-state-title">Sin pagos registrados</div>
                                            <p class="empty-state-text">Todavía no hay movimientos de pago para este usuario.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('javascript')
    <script type='text/javascript' src='{{ asset('js/admin/usuarios/usuarios_show.js') }}'></script>

    <script>
        $(document).on('click', '.btnDeleteUsuario', function () {
            const form = $(this).closest('form');

            bootbox.confirm({
                title: "<strong>Eliminar usuario</strong>",
                message: "¿Seguro que deseas eliminar este usuario?<br><small>Esta acción lo marcará como eliminado.</small>",
                buttons: {
                    confirm: {
                        label: '<i class="fa fa-check"></i> Sí, eliminar',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancelar',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if (result) {
                        form.submit();
                    }
                }
            });
        });
    </script>


@endsection