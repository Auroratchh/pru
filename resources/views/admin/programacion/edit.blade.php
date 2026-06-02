@extends('layouts.template_00')

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Administración</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin/programaciones') }}">Programación</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Rutina</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container">
            <h2><i class="fa-solid fa-calendar-lines-pen text-warning"></i> Modificar Rutina Diaria</h2>
            <p class="text-muted">Ajusta los bloques, tiempos o repeticiones de la sesión programada.</p>

            <form action="{{ asset('admin/programaciones/'.$programacion->idProgramacion) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-header bg-warning text-dark font-weight-bold">
                        <h5 class="mb-0 text-uppercase small font-weight-bold">Datos de Encabezado</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Fecha del Entrenamiento</label>
                                <input type="date" name="fecha" class="form-control" required value="{{ $programacion->fecha }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Día de la Planificación</label>
                                <select name="diaPlan" class="form-select text-uppercase" required>
                                    <option value="LUNES" {{ $programacion->diaPlan == 'LUNES' ? 'selected' : '' }}>Lunes</option>
                                    <option value="MARTES" {{ $programacion->diaPlan == 'MARTES' ? 'selected' : '' }}>Martes</option>
                                    <option value="MIERCOLES" {{ $programacion->diaPlan == 'MIERCOLES' ? 'selected' : '' }}>Miércoles</option>
                                    <option value="JUEVES" {{ $programacion->diaPlan == 'JUEVES' ? 'selected' : '' }}>Jueves</option>
                                    <option value="VIERNES" {{ $programacion->diaPlan == 'VIERNES' ? 'selected' : '' }}>Viernes</option>
                                    <option value="SABADO" {{ $programacion->diaPlan == 'SABADO' ? 'selected' : '' }}>Sábado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($programacion->configuraciones as $indexConfig => $conf)
                    <div class="card mb-4 border-dark shadow-sm">
                        <div class="card-header bg-dark text-white font-weight-bold">
                            <h6 class="mb-0 text-uppercase small">Configuración de Etapa / Bloque #{{ $indexConfig + 1 }}</h6>
                            <input type="hidden" name="configuraciones[{{ $indexConfig }}][idConfProg]" value="{{ $conf->idConfProg }}">
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label small font-weight-bold">Etapa Base *</label>
                                    <select name="configuraciones[{{ $indexConfig }}][idEtapas]" class="form-select form-select-sm" required>
                                        @foreach($etapas as $et)
                                            <option value="{{ $et->idEtapas }}" {{ $conf->idEtapas == $et->idEtapas ? 'selected' : '' }}>{{ $et->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small font-weight-bold">Tipo de WOD / Modalidad *</label>
                                    <select name="configuraciones[{{ $indexConfig }}][tiposEntrenamientos]" class="form-select form-select-sm" required>
                                        <option value="AMRAP" {{ $conf->tiposEntrenamientos == 'AMRAP' ? 'selected' : '' }}>AMRAP</option>
                                        <option value="EMOM" {{ $conf->tiposEntrenamientos == 'EMOM' ? 'selected' : '' }}>EMOM</option>
                                        <option value="FOR TIME" {{ $conf->tiposEntrenamientos == 'FOR TIME' ? 'selected' : '' }}>FOR TIME</option>
                                        <option value="TABATA" {{ $conf->tiposEntrenamientos == 'TABATA' ? 'selected' : '' }}>TABATA</option>
                                        <option value="CIRCUIT" {{ $conf->tiposEntrenamientos == 'CIRCUIT' ? 'selected' : '' }}>CIRCUIT / ROUNDS</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small font-weight-bold">Rounds</label>
                                    <input type="number" name="configuraciones[{{ $indexConfig }}][rounds]" class="form-control form-control-sm" value="{{ $conf->rounds }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small font-weight-bold">Tiempo Total</label>
                                    <input type="text" name="configuraciones[{{ $indexConfig }}][tiempoTotal]" class="form-control form-control-sm" value="{{ $conf->tiempoTotal }}">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Tiempo de Trabajo</label>
                                    <input type="text" name="configuraciones[{{ $indexConfig }}][tiempoTrabajo]" class="form-control form-control-sm" value="{{ $conf->tiempoTrabajo }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Tiempo de Descanso</label>
                                    <input type="text" name="configuraciones[{{ $indexConfig }}][tiempoDescanso]" class="form-control form-control-sm" value="{{ $conf->tiempoDescanso }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Repetición Inicio</label>
                                    <input type="number" name="configuraciones[{{ $indexConfig }}][repInicio]" class="form-control form-control-sm" value="{{ $conf->repInicio }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small font-weight-bold">Instrucciones de la pizarra / Etapa *</label>
                                <input type="text" name="configuraciones[{{ $indexConfig }}][descripcion]" class="form-control form-control-sm" value="{{ $conf->descripcion }}" required>
                            </div>

                            <div class="bg-light p-3 border rounded shadow-inner">
                                <strong class="text-secondary small text-uppercase mb-2 d-block"><i class="fa-solid fa-dumbbell"></i> Ejercicios Mapeados</strong>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle bg-white mb-0">
                                        <thead class="table-secondary small text-center text-uppercase">
                                            <tr>
                                                <th>Ejercicio</th>
                                                <th style="width: 10%;">Series</th>
                                                <th style="width: 10%;">Reps</th>
                                                <th style="width: 12%;">Peso Ini</th>
                                                <th style="width: 12%;">Peso Fin</th>
                                                <th>Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($conf->ejerciciosDetalle as $indexEj => $det)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][idDetalle]" value="{{ $det->idDetalle }}">
                                                        <select name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][idEjercicio]" class="form-select form-select-sm" required>
                                                            @foreach($ejercicios as $ej)
                                                                <option value="{{ $ej->idEjercicio }}" {{ $det->idEjercicio == $ej->idEjercicio ? 'selected' : '' }}>{{ $ej->ejercicio }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][series]" class="form-control form-control-sm text-center" value="{{ $det->series }}"></td>
                                                    <td><input type="text" name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][reps]" class="form-control form-control-sm text-center" value="{{ $det->reps }}"></td>
                                                    <td><input type="text" name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][pesoInicial]" class="form-control form-control-sm text-center" value="{{ $det->pesoInicial }}"></td>
                                                    <td><input type="text" name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][pesoFinal]" class="form-control form-control-sm text-center" value="{{ $det->pesoFinal }}"></td>
                                                    <td><input type="text" name="configuraciones[{{ $indexConfig }}][ejercicios][{{ $indexEj }}][notas]" class="form-control form-control-sm" value="{{ $det->notas }}"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary btn-lg w-100 mb-5 shadow-sm">
                    <i class="fa-solid fa-arrows-rotate"></i> Aplicar y Actualizar Rutina Completa
                </button>
            </form>
        </div>
    </section>
@endsection