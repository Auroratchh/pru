@extends('layouts.template_00')

@section('css')
    <link href="{{ asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
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
                    <li class="breadcrumb-item"><a href="{{ url('admin/usuarios/' . $usuario->idUsuario) }}">Usuario {{ $usuario->idUsuario }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registrar pago</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container admin-usuarios-page">

            <div class="row justify-content-center">
                <div class="col-xl-10">

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

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="fw-bold mb-2">Corrige lo siguiente:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {!! Form::open([
                        'url' => 'admin/usuarios/' . $usuario->idUsuario . '/store_pago',
                        'method' => 'PATCH',
                        'id' => 'FormCreatePago'
                    ]) !!}

                    <div class="user-form-hero mb-4">
                        <div class="user-form-hero-content">
                            <div>
                                <h1 class="user-form-title">Registrar pago</h1>
                                <p class="user-form-subtitle mb-0">
                                    {{ $usuario->nombre_completo }}
                                </p>
                            </div>
                            <div class="user-form-chip">
                                <i class="fa-solid fa-money-bill-wave me-2"></i>Cobranza
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-xl-3">
                            <div class="admin-summary-card">
                                <div class="card-body">
                                    <div class="admin-summary-label">Membresía actual</div>
                                    <div class="admin-summary-value" style="font-size:1.1rem;">
                                        {{ $usuario->membresia?->nombre ?? 'Sin membresía' }}
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                    <div class="admin-summary-value admin-summary-value-success" style="font-size:1.2rem;">
                                        {{ $usuario->fecha_ultimo_pago_texto }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="admin-summary-card">
                                <div class="card-body">
                                    <div class="admin-summary-label">Vigencia actual</div>
                                    <div class="admin-summary-value admin-summary-value-primary" style="font-size:1.2rem;">
                                        {{ $usuario->fecha_vigencia_texto }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="user-form-card mb-4">
                        <div class="user-form-card-header">
                            <h2 class="user-form-card-title">Datos del pago</h2>
                            <p class="user-form-card-subtitle">Selecciona la membresía, forma de pago y periodo de vigencia.</p>
                        </div>

                        <div class="user-form-card-body">
                            <div class="row g-4 user-form-row">

                                <div class="col-md-6">
                                    {!! Form::label('idMembresia', 'Membresía *', ['class' => 'form-label']) !!}
                                    {!! Form::select('idMembresia', $membresiasList, old('idMembresia', $usuario->idMembresia), [
                                        'class' => 'form-control form-select',
                                        'required' => true,
                                        'placeholder' => 'Seleccione',
                                        'id' => 'idMembresia'
                                    ]) !!}
                                </div>

                                <div class="col-md-6">
                                    {!! Form::label('idFormaPago', 'Forma de pago *', ['class' => 'form-label']) !!}
                                    {!! Form::select('idFormaPago', $formasPagoList, old('idFormaPago'), [
                                        'class' => 'form-control form-select',
                                        'required' => true,
                                        'placeholder' => 'Seleccione forma de pago'
                                    ]) !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('fechaPago', 'Fecha de pago *', ['class' => 'form-label']) !!}
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input
                                                id="fechaPago"
                                                name="fechaPago"
                                                type="text"
                                                class="form-control datetimepicker-input"
                                                data-target="#datetimepicker1"
                                                placeholder="Fecha de pago"
                                                value="{{ old('fechaPago', now()->format('d/m/Y')) }}"
                                                readonly
                                        />
                                        <span class="input-group-text" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('fechaVigencia', 'Fecha de vigencia', ['class' => 'form-label']) !!}
                                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                        <input
                                                id="fechaVigencia"
                                                name="fechaVigencia"
                                                type="text"
                                                class="form-control datetimepicker-input"
                                                data-target="#datetimepicker2"
                                                placeholder="Fecha de vigencia"
                                                value="{{ old('fechaVigencia') }}"
                                                readonly
                                        />
                                        <span class="input-group-text" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    </div>
                                    <small class="form-hint">Si la dejas vacía, se calculará según la membresía.</small>
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('monto', 'Monto', ['class' => 'form-label']) !!}
                                    <div class="input-group input-money-group">
                                        <span class="input-group-text">$</span>
                                        {!! Form::number('monto', old('monto'), [
                                            'class' => 'form-control',
                                            'step' => '0.01',
                                            'min' => '0',
                                            'placeholder' => 'Ej. 650.00',
                                            'id' => 'monto'
                                        ]) !!}
                                    </div>
                                    <small class="form-hint">Si lo dejas vacío, se tomará el costo de la membresía.</small>
                                </div>

                                <div class="col-12">
                                    {!! Form::label('observaciones', 'Observaciones', ['class' => 'form-label']) !!}
                                    {!! Form::textarea('observaciones', old('observaciones'), [
                                        'class' => 'form-control',
                                        'rows' => 3,
                                        'placeholder' => 'Notas adicionales del pago'
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="user-form-actions">
                        <a href="{{ url('admin/usuarios/' . $usuario->idUsuario) }}" class="btn btn-outline-secondary btn-lg">
                            Cancelar
                        </a>
                        {!! Form::submit('Guardar pago', ['id' => 'btnGuardar', 'class' => 'btn btn-admin-success btn-lg']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('libraries/moment-develop/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries/moment-develop/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/usuarios/usuarios_create_pago.js') }}" type="text/javascript"></script>

    <script>
        const membresiasData = @json($membresiasData);

        $(document).ready(function () {
            moment.locale('es');

            $("#datetimepicker1").datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY',
                viewMode: 'days',
                useCurrent: false,
                ignoreReadonly: true,
                defaultDate: moment()
            });

            $("#datetimepicker2").datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY',
                viewMode: 'days',
                useCurrent: false,
                ignoreReadonly: true
            });

            function recalcularVigencia() {
                const idMembresia = $('#idMembresia').val();
                const fechaPago = $('#datetimepicker1').datetimepicker('date');

                if (!idMembresia || !membresiasData[idMembresia] || !fechaPago) {
                    return;
                }

                const membresia = membresiasData[idMembresia];
                const diasDuracion = parseInt(membresia.diasDuracion ?? 30);

                let fechaVigencia;

                if (diasDuracion === 30) {
                    // comportamiento tipo mensual, como lo tenías antes
                    fechaVigencia = moment(fechaPago).add(1, 'months');
                } else {
                    // para otras duraciones
                    fechaVigencia = moment(fechaPago).add(diasDuracion, 'days');
                }

                $("#datetimepicker2").datetimepicker('date', fechaVigencia);
            }

            function recalcularMonto() {
                const idMembresia = $('#idMembresia').val();

                if (!idMembresia || !membresiasData[idMembresia]) {
                    return;
                }

                const membresia = membresiasData[idMembresia];

                if (!$('#monto').val()) {
                    $('#monto').val(parseFloat(membresia.costo).toFixed(2));
                }
            }

            $("#datetimepicker1").on("change.datetimepicker", function () {
                recalcularVigencia();
            });

            $('#idMembresia').on('change', function () {
                $('#monto').val('');
                recalcularMonto();
                recalcularVigencia();
            });

            recalcularMonto();
            recalcularVigencia();
        });
    </script>
@endsection