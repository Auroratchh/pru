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
        <td colspan="10" style="text-align:left; font-weight: bold;">REPORTE CONCENTRADO DE PAGOS A PARTIR DE  {{$yearIni}} </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">ID</th>
            <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">Usuario</th>
            <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">Fecha Alta</th>
            <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">Status</th>
            @foreach($meses as $mes)
                <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $mes)->translatedFormat('M Y') }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach($data as $usuario)
        <tr>
            <td style="width: 70px; text-align: center;">{{ $usuario->idUsuario }}</td>
            <td style="width: 300px;">{{ $usuario->usuario }}</td>
            <td>{{ date('d/m/Y',strtotime($usuario->fechaAlta))}}</td>
            <td style="text-align: center;">
                @if($usuario->fechaVigencia >= \Carbon\Carbon::now())
                    VIGENTE
                @else
                    NO VIGENTE
                @endif
            </td>
            @foreach($meses as $mes)
                <td style="text-align: right;">
                    @if(!empty((float)$usuario->$mes))
                        {{ (float)$usuario->$mes }}
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
