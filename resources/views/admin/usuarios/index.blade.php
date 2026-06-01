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
                    <li class="breadcrumb-item active" aria-current="page">Miembros</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-usuarios-page">

            @if(session('status_success'))
                <div class="alert alert-success mb-4">
                    {{ session('status_success') }}
                </div>
            @endif

            @if(session('status_fail'))
                <div class="alert alert-danger mb-4">
                    {{ session('status_fail') }}
                </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Total miembros</div>
                            <div class="admin-summary-value admin-summary-value-primary">
                                {{ $totalMiembros }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Vigentes</div>
                            <div class="admin-summary-value admin-summary-value-success">
                                {{ $totalVigentes }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">No vigentes</div>
                            <div class="admin-summary-value admin-summary-value-danger">
                                {{ $totalNoVigentes }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-summary-card">
                        <div class="card-body">
                            <div class="admin-summary-label">Ingreso esperado/mes vigentes</div>
                            <div class="admin-summary-value admin-summary-value-primary">
                                ${{ number_format($ingresoEsperado, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-filter-card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ url('admin/usuarios') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-3">
                                <label class="form-label">Estatus</label>
                                <select name="idStatus" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="1" {{ $idStatus == '1' ? 'selected' : '' }}>Vigentes</option>
                                    <option value="2" {{ $idStatus == '2' ? 'selected' : '' }}>No vigentes</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="form-label">Membresía</label>
                                <select name="idMembresia" class="form-control form-select">
                                    <option value="">Todas</option>
                                    @foreach($membresias as $membresia)
                                        <option value="{{ $membresia->idMembresia }}" {{ $idMembresia == $membresia->idMembresia ? 'selected' : '' }}>
                                            {{ $membresia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Buscar</label>
                                <input type="text" name="txtBuscar" class="form-control" placeholder="Nombre, celular o correo" value="{{ $txtBuscar }}" />
                            </div>

                            <div class="col-lg-2 d-grid">
                                <button class="btn btn-admin-dark" type="submit">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <a href="{{ url('admin/usuarios/create') }}" class="btn btn-admin-dark">
                                <i class="fa fa-plus me-1"></i> Nuevo
                            </a>

                            @if(Auth::user()->idRol == 1)
                                <a href="{{ url('admin/usuarios/export?idStatusUsuario=' . urlencode($idStatus) . '&txtBuscar=' . urlencode($txtBuscar) . '&idMembresia=' . urlencode($idMembresia)) }}"
                                   class="btn btn-admin-success">
                                    <i class="fa-solid fa-file-excel me-1"></i> Excel
                                </a>
                            @endif
                        </div>

                        <div class="mt-3">
                            <small><em>{{ $usuarios->total() }} registros encontrados</em></small>
                        </div>
                    </form>
                </div>
            </div>

            <div class="admin-table-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-admin-users">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Miembro</th>
                                    <th class="text-center">Cobranza</th>
                                    <th class="text-center">Vigencia</th>
                                    <th class="text-center">Estatus</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($usuarios as $user)
                                <tr>
                                    <td class="text-center user-id">
                                        {{ $user->idUsuario }}
                                    </td>

                                    <td>
                                        <div class="user-name">{{ $user->nombre_completo }}</div>
                                        <div class="user-membership">{{ $user->membresia?->nombre ?? 'Sin membresía' }}</div>
                                        <span class="user-meta"><small><strong>Cel:</strong> {{ $user->celular }}</small></span>
                                        <span class="user-meta"><small><strong>Email:</strong> {{ $user->email }}</small></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="cobranza-box">
                                            <div class="cobranza-main">
                                                <span class="cobranza-label">Esp.</span>
                                                <span class="cobranza-value">
                                                    {{ !is_null($user->pagoMensualEsperado) ? '$' . number_format($user->pagoMensualEsperado, 2) : '—' }}
                                                </span>
                                            </div>
                                            <div class="cobranza-main">
                                                <span class="cobranza-label">Últ.</span>
                                                <span class="cobranza-value">
                                                    {{ !is_null($user->monto_ultimo_pago) ? '$' . number_format($user->monto_ultimo_pago, 2) : '—' }}
                                                </span>
                                            </div>

                                            @if(!is_null($user->diferencia_pago))
                                                <div class="cobranza-diff {{ $user->diferencia_pago < 0 ? 'text-danger' : 'text-success' }}">
                                                    {{ $user->diferencia_pago > 0 ? '+' : '' }}${{ number_format($user->diferencia_pago, 2) }}
                                                </div>
                                            @endif

                                            <span class="badge-status {{ $user->badge_pago }}">
                                                {{ $user->estado_pago }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="text-center user-date">
                                        <div>{{ $user->fecha_vigencia_texto }}</div>
                                        <small class="text-muted d-block">{{ $user->fecha_ultimo_pago_texto }}</small>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-status {{ $user->badge_membresia }}">
                                            {{ $user->estatus_membresia }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="admin-actions">
                                            <a href="{{ url('admin/usuarios/' . $user->idUsuario) }}" class="btn btn-sm btn-action btn-action-view" data-bs-toggle="tooltip" data-bs-title="Ver detalle">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ url('admin/usuarios/' . $user->idUsuario . '/edit') }}" class="btn btn-sm btn-action btn-action-edit" data-bs-toggle="tooltip" data-bs-title="Editar">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <a href="{{ url('admin/usuarios/' . $user->idUsuario . '/create_pago') }}" class="btn btn-sm btn-action {{ $user->estatus_membresia == 'Vencido' ? 'btn-action-danger' : 'btn-action-pay' }}" data-bs-toggle="tooltip" data-bs-title="Registrar pago">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fa-solid fa-users"></i>
                                            </div>
                                            <div class="empty-state-title">Sin resultados</div>
                                            <p class="empty-state-text">No se encontraron miembros con los filtros seleccionados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($usuarios->hasPages())
                <div class="mt-4">
                    {{ $usuarios->links() }}
                </div>
            @endif

        </div>
    </section>
@endsection