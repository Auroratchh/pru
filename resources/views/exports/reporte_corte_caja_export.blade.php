<table>
    <tr>
        <td colspan="2" rowspan="5" style="width: 260px;"></td>
        <td colspan="10" style="text-align:left; font-weight: bold;">ALPHA VENUS</td>
    </tr>
    <tr>
        <td colspan="10" style="text-align:left; font-weight: bold;">ALPHA VENUS FUNCTIONAL TRANING  WEIGHLIFTING</td>
    </tr>
    <tr>
        <td colspan="10" style="text-align:left; font-weight: bold;"> CORREO ELECTRÓNICO: alphavenusfunctionaltraining@gmail.com</td>
    </tr>
    <tr>
        <td colspan="10" style="text-align:left; font-weight: bold;">REPORTE DE CORTE DE CAJA DEL  {{ $fechaIni->format('d/m/Y H:i:s')}} AL {{ $fechaFin->format('d/m/Y H:i:s')}}  </td>
    </tr>
</table>

<table>
    <thead>
    <tr style="">
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FECHA</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">MIEMBRO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">MONTO PAGO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FORMA PAGO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pagos as $pago)
        <tr>
            <td style="width: 120px">{{ date('d/m/Y',strtotime($pago->fechaPago))}}</td>
            <td style="width: 300px;">
                {{$pago->usuario}}
            </td>
            <td>{{(float)$pago->monto}}</td>
            <td> {{$pago->formaPago}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table>
    <thead>
    <tr style="">
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FECHA</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">CONCEPTO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">MONTO GASTO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">TIPO GASTO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($gastos as $gasto)
        <tr>
            <td style="width: 120px">{{ date('d/m/Y',strtotime($gasto->fechaGasto))}}</td>
            <td style="width: 300px;">
                {{$gasto->gasto}}
            </td>
            <td>{{(float)$gasto->monto}}</td>
            <td> {{$gasto->tipoGasto}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
    <tr>
        <td></td>
        <th  style="background-color:#EEEEEE; text-align: right">Pagos en Transferencias:</th>
        <td>{{(float)$totalPagoTransferencias}}</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td style="background-color:#EEEEEE; text-align: right">Pagos en Efectivo:</td>
        <td>{{(float)$totalPagoEfectivo}}</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td style="background-color:#EEEEEE; text-align: right">Pagos en Deposito:</td>
        <td>{{(float)$totalPagoDepositos}}</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td style="background-color:#EEEEEE; font-weight: bold; text-align: right">TOTAL INGRESOS:</td>
        <td style="border-top: 1px solid #000000; font-weight: bold;">{{(float)$totalPagos}}</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td style="background-color:#EEEEEE; font-weight: bold; text-align: right">TOTAL GASTOS:</td>
        <td style="border-top: 1px solid #000000; font-weight: bold;">{{(float)$totalGastos}}</td>
        <td></td>
    </tr>

    @php
        $total = $totalPagos - $totalGastos;
    @endphp
    <tr>
        <td></td>
        <td style="background-color:#EEEEEE; font-weight: bold; text-align: right">UTILIDAD:</td>
        <td style="border-top: 1px solid #000000; font-weight: bold;">{{(float)$total}}</td>
        <td></td>
    </tr>
    </tbody>
</table>
