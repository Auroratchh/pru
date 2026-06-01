<table>
    <tr>
        <td colspan="2" rowspan="5" style="width: 260px;"></td>
        <td colspan="4" style="text-align:left; font-weight: bold;">ALPHA VENUS</td>
    </tr>
    <tr>
        <td colspan="6" style="text-align:left; font-weight: bold;">ALPHA VENUS FUNCTIONAL TRANING  WEIGHLIFTING</td>
    </tr>
    <tr>
        <td colspan="6" style="text-align:left; font-weight: bold;"> CORREO ELECTRÓNICO: alphavenusfunctionaltraining@gmail.com</td>
    </tr>
    <tr>
        <td colspan="6" style="text-align:left; font-weight: bold;">REPORTE DE PAGOS PENDIENTES </td>
    </tr>
</table>

<table>
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Celular</th>
        <th>Último pago</th>
        <th>Fecha límite</th>
        <th>Estatus</th>
        <th>Referencia</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pendientes as $usuario)
        <tr>
            <td>{{ $usuario->nombre_completo }}</td>
            <td>'{{ $usuario->celular }}</td>
            <td>{{ $usuario->fecha_ultimo_pago_texto }}</td>
            <td>{{ $usuario->fecha_vigencia_texto }}</td>
            <td>{{ $usuario->estatus_pago }}</td>
            <td>
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
        </tr>
    @endforeach
    </tbody>
</table>