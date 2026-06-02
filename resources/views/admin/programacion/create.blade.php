@extends('layouts.template_00')

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Administración</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('admin/programaciones') }}">Programación</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva Rutina</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <h2><i class="fa-solid fa-calendar-lines-pen"></i> Nueva Estructura de Rutina Diaria</h2>
                    <p class="text-muted">Diseña los bloques de entrenamiento para el día y asigna sus respectivos ejercicios.</p>
                </div>
            </div>

            @if (session('status_fail'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('status_fail') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ asset('admin/programaciones') }}" method="POST" id="formProgramacion">
                @csrf

                <div class="card mb-4 shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Datos Generales del Día</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Fecha del Entrenamiento *</label>
                                <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Día de la Planificación *</label>
                                <select name="diaPlan" class="form-select text-uppercase" required>
                                    <option value="">-- Selecciona el Día --</option>
                                    <option value="LUNES" {{ old('diaPlan') == 'LUNES' ? 'selected' : '' }}>Lunes</option>
                                    <option value="MARTES" {{ old('diaPlan') == 'MARTES' ? 'selected' : '' }}>Martes</option>
                                    <option value="MIERCOLES" {{ old('diaPlan') == 'MIERCOLES' ? 'selected' : '' }}>Miércoles</option>
                                    <option value="JUEVES" {{ old('diaPlan') == 'JUEVES' ? 'selected' : '' }}>Jueves</option>
                                    <option value="VIERNES" {{ old('diaPlan') == 'VIERNES' ? 'selected' : '' }}>Viernes</option>
                                    <option value="SABADO" {{ old('diaPlan') == 'SABADO' ? 'selected' : '' }}>Sábado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="contenedor-bloques"></div>

                <div class="row mt-4 mb-5">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-secondary w-100 shadow-sm mb-2" id="btnAgregarBloque">
                            <i class="fa-solid fa-layer-plus"></i> Añadir Otro Bloque al Día (Etapa)
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success w-100 shadow-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar y Publicar Rutina Completa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <select id="plantilla-ejercicios" style="display:none;">
        <option value="">-- Seleccionar Ejercicio --</option>
        @foreach($ejercicios as $ej)
            <option value="{{ $ej->idEjercicio }}">{{ $ej->ejercicio }}</option>
        @endforeach
    </select>

    <select id="plantilla-etapas" style="display:none;">
        <option value="">-- Seleccionar Etapa --</option>
        @foreach($etapas as $etapa)
            <option value="{{ $etapa->idEtapas }}">{{ $etapa->nombre }}</option>
        @endforeach
    </select>
@endsection

@section('javascript')
<script>
    let contadorBloques = 0;

    document.addEventListener("DOMContentLoaded", function() {
        agregarNuevoBloque();
        document.getElementById('btnAgregarBloque').addEventListener('click', agregarNuevoBloque);
    });

    function agregarNuevoBloque() {
        const contenedor = document.getElementById('contenedor-bloques');
        const opcionesEtapas = document.getElementById('plantilla-etapas').innerHTML;
        const indiceBloque = contadorBloques;
        contadorBloques++;

        const bloqueHtml = `
            <div class="card mb-4 border-dark shadow-sm bloque-entrenamiento" id="bloque-${indiceBloque}">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-uppercase font-weight-bold"><i class="fa-solid fa-cubes"></i> Configuración de Bloque (Etapa)</h6>
                    ${indiceBloque > 0 ? `<button type="button" class="btn btn-sm btn-danger py-1" onclick="eliminarBloque(${indiceBloque})"><i class="fa-solid fa-trash-can"></i> Quitar Bloque</button>` : ''}
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small font-weight-bold">Etapa Base *</label>
                            <select name="configuraciones[${indiceBloque}][idEtapas]" class="form-select form-select-sm" required>
                                ${opcionesEtapas}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small font-weight-bold">Tipo de WOD / Modalidad *</label>
                            <select name="configuraciones[${indiceBloque}][tiposEntrenamientos]" class="form-select form-select-sm" required>
                                <option value="AMRAP">AMRAP</option>
                                <option value="EMOM">EMOM</option>
                                <option value="FOR TIME">FOR TIME</option>
                                <option value="TABATA">TABATA</option>
                                <option value="CIRCUIT">CIRCUIT / ROUNDS</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small font-weight-bold">Rounds</label>
                            <input type="number" name="configuraciones[${indiceBloque}][rounds]" class="form-control form-control-sm" value="1" min="1">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small font-weight-bold">Tiempo Total</label>
                            <input type="text" name="configuraciones[${indiceBloque}][tiempoTotal]" class="form-control form-control-sm" placeholder="00:20:00">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small">Tiempo de Trabajo</label>
                            <input type="text" name="configuraciones[${indiceBloque}][tiempoTrabajo]" class="form-control form-control-sm" placeholder="00:01:00">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Tiempo de Descanso</label>
                            <input type="text" name="configuraciones[${indiceBloque}][tiempoDescanso]" class="form-control form-control-sm" placeholder="00:00:30">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small">Repetición Inicio</label>
                            <input type="number" name="configuraciones[${indiceBloque}][repInicio]" class="form-control form-control-sm" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small font-weight-bold">Instrucciones de la pizarra / Etapa *</label>
                            <input type="text" name="configuraciones[${indiceBloque}][descripcion]" class="form-control form-control-sm" placeholder="Ej: Completar en el menor tiempo" required>
                        </div>
                    </div>

                    <div class="bg-light p-3 border rounded shadow-inner">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="text-secondary small text-uppercase"><i class="fa-solid fa-dumbbell"></i> Ejercicios del Bloque</strong>
                            <button type="button" class="btn btn-xs btn-primary py-1 px-2 text-xs" onclick="agregarEjercicioABloque(${indiceBloque})">
                                <i class="fa-solid fa-plus-circle"></i> Agregar Ejercicio
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0 bg-white shadow-sm">
                                <thead class="table-secondary small text-center text-uppercase fw-bold">
                                    <tr>
                                        <th style="width: 35%;">Ejercicio del Catálogo</th>
                                        <th style="width: 10%;">Series</th>
                                        <th style="width: 10%;">Reps</th>
                                        <th style="width: 12%;">Peso Ini</th>
                                        <th style="width: 12%;">Peso Fin</th>
                                        <th>Notas del Ejercicio</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-ejercicios-bloque-${indiceBloque}"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        contenedor.insertAdjacentHTML('beforeend', bloqueHtml);
        agregarEjercicioABloque(indiceBloque);
    }

    let contadorEjerciciosPorBloque = {};

    function agregarEjercicioABloque(indiceBloque) {
        if (!contadorEjerciciosPorBloque[indiceBloque]) {
            contadorEjerciciosPorBloque[indiceBloque] = 0;
        }

        const tablaBody = document.getElementById(`tabla-ejercicios-bloque-${indiceBloque}`);
        const opcionesEjercicios = document.getElementById('plantilla-ejercicios').innerHTML;
        const indiceEjercicio = contadorEjerciciosPorBloque[indiceBloque];
        contadorEjerciciosPorBloque[indiceBloque]++;

        const filaHtml = `
            <tr id="fila-ejercicio-${indiceBloque}-${indiceEjercicio}">
                <td>
                    <select name="configuraciones[${indiceBloque}][ejercicios][${indiceEjercicio}][idEjercicio]" class="form-select form-select-sm" required>
                        ${opcionesEjercicios}
                    </select>
                </td>
                <td>
                    <input type="text" name="configuraciones[${indiceBloque}][ejercicios][${indiceEjercicio}][series]" class="form-control form-control-sm text-center" placeholder="4">
                </td>
                <td>
                    <input type="text" name="configuraciones[${indiceBloque}][ejercicios][${indiceEjercicio}][reps]" class="form-control form-control-sm text-center" placeholder="12">
                </td>
                <td>
                    <input type="text" name="configuraciones[${indiceBloque}][ejercicios][${indiceEjercicio}][pesoInicial]" class="form-control form-control-sm text-center" value="0">
                </td>
                <td>
                    <input type="text" name="configuraciones[${indiceBloque}][ejercicios][${indiceEjercicio}][pesoFinal]" class="form-control form-control-sm text-center" value="0">
                </td>
                <td>
                    <input type="text" name="configuraciones[${indiceBloque}][ejercicios][${indiceEjercicio}][notas]" class="form-control form-control-sm" placeholder="Descansar 45s">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm text-danger border-0 p-0" onclick="eliminarFilaEjercicio(${indiceBloque}, ${indiceEjercicio})">
                        <i class="fa-solid fa-circle-xmark fs-5"></i>
                    </button>
                </td>
            </tr>
        `;

        tablaBody.insertAdjacentHTML('beforeend', filaHtml);
    }

    function eliminarBloque(id) {
        const elemento = document.getElementById(`bloque-${id}`);
        if(elemento) elemento.remove();
    }

    function eliminarFilaEjercicio(idBloque, idEjercicio) {
        const fila = document.getElementById(`fila-ejercicio-${idBloque}-${idEjercicio}`);
        if(fila) fila.remove();
    }
</script>
@endsection