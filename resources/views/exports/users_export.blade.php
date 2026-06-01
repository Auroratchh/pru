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
        <td colspan="10" style="text-align:left; font-weight: bold;">USUARIOS AL  {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s')}}</td>
    </tr>
</table>

<table>
    <thead>

    <tr style="">
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">ID</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: center">NOMBRE</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">APELLIDO PATERNO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">APELLIDO MATERNO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FECHA NACIMIENTO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">CELULAR</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">SEXO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">EMAIL</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FECHA DE ALTA</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">STATUS USUARIO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FECHA ULTIMO PAGO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">MONTO ULTIMO PAGO</th>
        <th style="background-color:#EEEEEE; font-weight: bold; text-align: left">FECHA VIGENCIA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($usuarios as $u)
        <tr>
            <td style="text-align: center; width: 70px">{{ $u->idUsuario }}</td>
            <td style="text-align: left; width: 200px">{{ $u->nombre }}</td>
            <td>{{ $u->apellidoPaterno }}</td>
            <td>{{ $u->apellidoMaterno }}</td>
            <td>{{ $u->fechaNacimiento }}</td>
            <td>{{ $u->celular }}</td>
            <td>{{ $u->sexo }}</td>
            <td>{{ $u->email }}</td>

            <td>{{ date('d/m/Y',strtotime($u->created_at))  }}</td>

            <td>
                @if($u->fechaVigencia >= \Carbon\Carbon::now())
                    VIGENTE
                @else
                    NO VIGENTE
                @endif
            </td>
            <td>{{ date('d/m/Y',strtotime($u->fechaUltimoPago))  }}</td>
            <td>{{ (float)$u->montoUltimoPago }}</td>
            <td>{{ date('d/m/Y',strtotime($u->fechaVigencia))  }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
