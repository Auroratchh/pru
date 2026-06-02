@extends('layouts.template_00')

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Programación</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container">
            <div class="row mb-3 align-items-center">
                <div class="col-md-8">
                    <h2><i class="fa-solid fa-calendar-days"></i> Calendario de Programación Diario</h2>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ asset('admin/programaciones/create') }}" class="btn btn-success">
                        <i class="fa-solid fa-calendar-plus"></i> Programar Nueva Rutina
                    </a>
                </div>
            </div>

            @if (session('status_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('status_success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4 bg-light shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ asset('admin/programaciones') }}" class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label small font-weight-bold">Desde:</label>
                            <input type="date" name="fechaIni" class="form-control" value="{{ request('fechaIni', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small font-weight-bold">Hasta:</label>
                            <input type="date" name="fechaFin" class="form-control" value="{{ request('fechaFin', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small font-weight-bold">Filtrar por Día:</label>
                            <select name="diaPlan" class="form-select text-uppercase">
                                <option value="">-- Todos los días --</option>
                                <option value="LUNES" {{ request('diaPlan') == 'LUNES' ? 'selected' : '' }}>Lunes</option>
                                <option value="MARTES" {{ request('diaPlan') == 'MARTES' ? 'selected' : '' }}>Martes</option>
                                <option value="MIERCOLES" {{ request('diaPlan') == 'MIERCOLES' ? 'selected' : '' }}>Miércoles</option>
                                <option value="JUEVES" {{ request('diaPlan') == 'JUEVES' ? 'selected' : '' }}>Jueves</option>
                                <option value="VIERNES" {{ request('diaPlan') == 'VIERNES' ? 'selected' : '' }}>Viernes</option>
                                <option value="SABADO" {{ request('diaPlan') == 'SABADO' ? 'selected' : '' }}>Sábado</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-filter"></i> Filtrar Planificación
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse($programaciones as $prog)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-secondary">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 text-uppercase font-weight-bold">{{ $prog->diaPlan }}</h5>
                                    <small class="text-warning font-monospace">{{ \Carbon\Carbon::parse($prog->fecha)->format('d/m/Y') }}</small>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ asset('admin/programaciones/'.$prog->idProgramacion) }}" class="btn btn-sm btn-info text-white me-1" title="Ver pizarra">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ asset('admin/programaciones/'.$prog->idProgramacion.'/edit') }}" class="btn btn-sm btn-warning text-dark me-1" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ asset('admin/programaciones/'.$prog->idProgramacion) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar por completo la programación de este día?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    @forelse($prog->configuraciones as $conf)
                                        <li class="border-bottom py-2">
                                            <span class="badge bg-primary font-monospace">{{ $conf->tiposEntrenamientos }}</span> 
                                            <strong class="text-secondary small ms-1 text-uppercase">{{ $conf->etapa->nombre ?? 'Bloque' }}</strong>
                                            <p class="text-muted small mb-0 mt-1 font-italic">{{ Str::limit($conf->descripcion, 75) }}</p>
                                        </li>
                                    @empty
                                        <li class="text-muted small text-center py-3">Sin bloques o etapas configuradas.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 card border-dashed">
                        <i class="fa-solid fa-calendar-xmark text-muted fs-1 mb-2"></i>
                        <p class="text-muted fs-5">No se encontraron rutinas diarias guardadas para el rango de fechas seleccionado.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection