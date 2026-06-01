<?php

namespace App\Http\Controllers;


use App\Exports\UsersExport;
use App\Http\Requests\UsuarioUpdateRequest;


use App\Models\FormaPago;
use App\Models\Membresia;
use App\Models\Pago;

use App\Models\Rol;
use App\Models\Sexo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');

    }

    public function index(Request $request)
    {

        $txtBuscar      = trim((string) $request->get('txtBuscar'));
        $idStatus       = trim((string) $request->get('idStatus'));
        $idMembresia    = trim((string) $request->get('idMembresia'));


        $query = User::query()->with(['membresia', 'pagos' => function ($q) {
            $q->where('eliminado', 0)->latest('fechaPago');
            }])
            ->where('eliminado', 0);


        if ($idStatus !== '') {
            if ((int) $idStatus === 1) {
                $query->whereNotNull('fechaVigencia')->whereDate('fechaVigencia', '>=', now()->toDateString());
            }

            if ((int) $idStatus === 2) {
                $query->where(function ($q) {
                    $q->whereNull('fechaVigencia')->orWhereDate('fechaVigencia', '<', now()->toDateString());
                });
            }
        }

        if ($idMembresia !== '') {
            $query->where('idMembresia', $idMembresia);
        }

        if ($txtBuscar !== '') {
            $query->where(function ($q) use ($txtBuscar) {
                $q->where('nombre', 'like', "%{$txtBuscar}%")
                    ->orWhere('apellidoPaterno', 'like', "%{$txtBuscar}%")
                    ->orWhere('apellidoMaterno', 'like', "%{$txtBuscar}%")
                    ->orWhere('celular', 'like', "%{$txtBuscar}%")
                    ->orWhere('email', 'like', "%{$txtBuscar}%");
            });
        }

        $usuarios = $query
            ->orderBy('idUsuario', 'desc')
            ->orderBy('apellidoPaterno')
            ->orderBy('apellidoMaterno')
            ->orderBy('nombre')
            ->paginate(20)
            ->appends([
                'txtBuscar'     => $txtBuscar,
                'idStatus'      => $idStatus,
                'idMembresia'   => $idMembresia,
            ]);

        $membresias = Membresia::where('activo', 1)->orderBy('nombre')->get();
        $totalMiembros = User::where('eliminado', 0)->count();
        $totalVigentes = User::where('eliminado', 0)
            ->whereNotNull('fechaVigencia')
            ->whereDate('fechaVigencia', '>=', now()->toDateString())
            ->count();
        $totalNoVigentes = User::where('eliminado', 0)
            ->where(function ($q) {
                $q->whereNull('fechaVigencia')
                    ->orWhereDate('fechaVigencia', '<', now()->toDateString());
            })
            ->count();

        $ingresoEsperado = User::query()->where('eliminado', 0)
            ->whereNotNull('fechaVigencia')
            ->whereDate('fechaVigencia', '>=', now()->toDateString())
            ->sum('pagoMensualEsperado');

        return view('admin.usuarios.index', compact(
            'usuarios',
            'txtBuscar',
            'idStatus',
            'idMembresia',
            'membresias',
            'totalMiembros',
            'totalVigentes',
            'totalNoVigentes',
            'ingresoEsperado'
        ));
    }

    public function create()
    {
        $roles          = Rol::where('eliminado',0)->where('idRol',2)->pluck('rol','idRol');
        $sexos          = Sexo::where('eliminado', 0)->pluck('sexo', 'idSexo');

        $membresias     = Membresia::where('activo', 1)->orderBy('nombre')->get();
        $membresiasList = $membresias->pluck('nombre', 'idMembresia');

        $membresiasData = $membresias->mapWithKeys(function ($m) {
            return [
                $m->idMembresia => [
                    'nombre' => $m->nombre,
                    'costo' => $m->costo,
                    'diasDuracion' => $m->diasDuracion,
                ]
            ];
        });

        return view('admin.usuarios.create', compact(
            'roles',
            'sexos',
            'membresias',
            'membresiasList',
            'membresiasData'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'idRol'             => ['required', 'integer'],
            'idMembresia'       => ['nullable', 'integer'],
            'nombre'            => ['required', 'string', 'max:255'],
            'apellidoPaterno'   => ['required', 'string', 'max:255'],
            'apellidoMaterno'   => ['nullable', 'string', 'max:255'],
            'fechaNacimiento'   => ['required', 'date_format:d/m/Y'],
            'celular'           => ['required', 'string', 'max:255'],
            'idSexo'            => ['nullable', 'integer'],
            'email'             => ['required', 'email', 'max:255', 'unique:tbl_usuarios,email'],
            'password'              => ['required', 'confirmed', 'min:6'],
            'pagoMensualEsperado'   => ['nullable', 'numeric', 'min:0'],
        ]);

        try
        {

            $fechaNacimiento = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fechaNacimiento)->format('Y-m-d');

            $montoEsperado = $request->pagoMensualEsperado;

            if ((is_null($montoEsperado) || $montoEsperado === '') && !empty($request->idMembresia)) {
                $membresia = Membresia::where('activo', 1)->where('idMembresia', $request->idMembresia)->first();
                if ($membresia) {
                    $montoEsperado = $membresia->costo;
                }
            }



            $usuario = new User();
            $usuario->idRol                     = $request->idRol;
            $usuario->idMembresia               = $request->idMembresia ?: null;
            $usuario->nombre                    = mb_strtoupper(trim($request->nombre));
            $usuario->apellidoPaterno           = mb_strtoupper(trim($request->apellidoPaterno));
            $usuario->apellidoMaterno           = mb_strtoupper(trim($request->apellidoMaterno));
            $usuario->fechaNacimiento           = $fechaNacimiento;
            $usuario->celular                   = trim($request->celular);
            $usuario->idSexo                    = $request->idSexo ?: null;
            $usuario->email                     = mb_strtolower(trim($request->email));
            $usuario->password                  = bcrypt($request->password);
            $usuario->passwordVisible           = $request->password;
            $usuario->pagoMensualEsperado       = $montoEsperado;
            $usuario->eliminado = 0;
            $usuario->save();


            return redirect('admin/usuarios/' . $usuario->idUsuario)->with('status_success', 'El usuario se ha creado correctamente.');

        }

        catch (\Exception $e){
            return back()->withInput()->with('status_fail', 'Whoops! '.$e->getMessage());
        }

    }

    public function show($idUsuario)
    {
        $usuario = User::with(['membresia', 'pagos' => function ($q) {$q->where('eliminado', 0)->orderByDesc('fechaPago');}])->findOrFail($idUsuario);

        $pagos = Pago::query()
            ->leftJoin('cat_formas_pago as fp', 'fp.idFormaPago', '=', 'tbl_pagos.idFormaPago')
            ->leftJoin('cat_membresias as m', 'm.idMembresia', '=', 'tbl_pagos.idMembresia')
            ->where('tbl_pagos.eliminado', 0)
            ->where('tbl_pagos.idUsuario', $idUsuario)
            ->orderByDesc('tbl_pagos.fechaPago')
            ->select(
                'tbl_pagos.*',
                'fp.formaPago',
                'm.nombre as nombreMembresia'
            )
            ->get();


        return view('admin.usuarios.show', compact(
            'usuario',
            'pagos'
        ));
    }

    public function edit($idUsuario)
    {
        $usuario = User::findOrFail($idUsuario);

        $roles      = Rol::where('eliminado',0)->where('idRol',2)->pluck('rol','idRol');
        $sexos      = Sexo::where('eliminado', 0)->pluck('sexo', 'idSexo');

        $membresias = Membresia::where('activo', 1)->orderBy('nombre')->get();

        $membresiasList = $membresias->pluck('nombre', 'idMembresia');

        $membresiasData = $membresias->mapWithKeys(function ($m) {
            return [
                $m->idMembresia => [
                    'nombre' => $m->nombre,
                    'costo' => $m->costo,
                    'diasDuracion' => $m->diasDuracion,
                ]
            ];
        });

        return view('admin.usuarios.edit', compact(
            'usuario',
            'roles',
            'sexos',
            'membresias',
            'membresiasList',
            'membresiasData'
        ));
    }
    public function update($idUsuario, Request $request)
    {
        $usuario = User::findOrFail($idUsuario);

        $rules = [
            'nombre'            => ['required', 'string', 'max:255'],
            'apellidoPaterno'   => ['required', 'string', 'max:255'],
            'apellidoMaterno'   => ['nullable', 'string', 'max:255'],
            'fechaNacimiento'   => ['required', 'date_format:d/m/Y'],
            'celular'           => ['required', 'string', 'max:255'],
            'idSexo'            => ['nullable', 'integer'],
            'email'             => ['required', 'email', 'max:255', 'unique:tbl_usuarios,email,' . $usuario->idUsuario . ',idUsuario'],
            'password'          => ['nullable', 'confirmed', 'min:6'],
        ];

        if (auth()->user()->idRol == 1) {
            $rules['idRol']                 = ['required', 'integer'];
            $rules['idMembresia']           = ['nullable', 'integer'];
            $rules['pagoMensualEsperado']   = ['nullable', 'numeric', 'min:0'];
        }

        $request->validate($rules);

        try {

            $fechaNacimiento = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fechaNacimiento)->format('Y-m-d');

            $montoEsperado = $request->pagoMensualEsperado;

            if ((is_null($montoEsperado) || $montoEsperado === '' || (float)$montoEsperado <= 0) && !empty($request->idMembresia)) {
                $membresia = Membresia::where('activo', 1)->where('idMembresia', $request->idMembresia)->first();

                if ($membresia) {
                    $montoEsperado = $membresia->costo;
                }
            }

            $usuario->nombre                = mb_strtoupper(trim($request->nombre));
            $usuario->apellidoPaterno       = mb_strtoupper(trim($request->apellidoPaterno));
            $usuario->apellidoMaterno       = mb_strtoupper(trim($request->apellidoMaterno));
            $usuario->fechaNacimiento       = $fechaNacimiento;
            $usuario->celular               = trim($request->celular);
            $usuario->idSexo                = $request->idSexo ?: null;
            $usuario->email                 = mb_strtolower(trim($request->email));

            if (auth()->user()->esAdmin()) {
                $usuario->idRol             = $request->idRol;
                $usuario->idMembresia       = $request->idMembresia ?: null;
                $usuario->pagoMensualEsperado = $montoEsperado;
            }
            if (!empty($request->password)) {
                $usuario->password = bcrypt($request->password);
                $usuario->passwordVisible = $request->password;
            }

            $usuario->save();

            return redirect('admin/usuarios/' . $usuario->idUsuario)->with('status_success', 'El usuario se ha actualizado correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('status_fail', 'Whoops! ' . $e->getMessage());
        }
    }

    public function edit_password($idUsuario){

        $usuario = User::find($idUsuario);

        return view('admin.usuarios.edit_password',compact('usuario'));
    }
    public function update_password($idUsuario, Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        try {
            $usuario = User::findOrFail($idUsuario);

            $passwordPlano = $request->input('password');

            $usuario->password = Hash::make($passwordPlano);
            $usuario->passwordVisible = $passwordPlano;
            $usuario->save();

            return redirect('admin/usuarios/' . $usuario->idUsuario)->with('status_success', 'La contraseña ha sido actualizada.');
        } catch (\Exception $e) {
            return back()->withInput()->with('status_fail', 'Whoops! ' . $e->getMessage());
        }
    }

    public function create_pago($idUsuario)
    {
        $usuario = User::with('membresia')->findOrFail($idUsuario);

        $formasPagoList = FormaPago::where('eliminado', 0)->orderBy('formaPago')->pluck('formaPago', 'idFormaPago');

        $membresias = Membresia::where('activo', 1)->orderBy('nombre')->get();

        $membresiasList = $membresias->pluck('nombre', 'idMembresia');

        $membresiasData = $membresias->mapWithKeys(function ($m) {
            return [
                $m->idMembresia => [
                    'nombre' => $m->nombre,
                    'costo' => $m->costo,
                    'diasDuracion' => $m->diasDuracion,
                ]
            ];
        });

        return view('admin.usuarios.create_pago', compact(
            'usuario',
            'formasPagoList',
            'membresiasList',
            'membresiasData'
        ));
    }
    public function store_pago($idUsuario, Request $request)
    {
        $request->validate([
            'idMembresia'       => ['required', 'integer'],
            'idFormaPago'       => ['required', 'integer'],
            'fechaPago'         => ['required', 'date_format:d/m/Y'],
            'fechaVigencia'     => ['nullable', 'date_format:d/m/Y'],
            'monto'             => ['nullable', 'numeric', 'min:0'],
            'observaciones'     => ['nullable', 'string'],
        ]);

        try {
            $usuario = User::findOrFail($idUsuario);
            $idUsuarioRecepcion = Auth::user()->idUsuario;

            $membresia = Membresia::where('activo', 1)->where('idMembresia', $request->idMembresia)->firstOrFail();

            $fechaPago = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fechaPago)->startOfDay();

            if (!empty($request->fechaVigencia)) {
                $fechaVigencia = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fechaVigencia)->endOfDay();
            } else {
                $fechaVigencia = $membresia->calcularFechaVigencia($fechaPago);
            }

            $monto = $request->monto;

            if (is_null($monto) || $monto === '' || (float)$monto <= 0) {
                $monto = $membresia->costo;
            }

            $pago                       = new Pago();
            $pago->idUsuario            = $idUsuario;
            $pago->idUsuarioRecepcion   = $idUsuarioRecepcion;
            $pago->idMembresia          = $membresia->idMembresia;
            $pago->idFormaPago          = $request->idFormaPago;
            $pago->fechaPago            = $fechaPago;
            $pago->fechaVigencia        = $fechaVigencia;
            $pago->monto                = $monto;
            $pago->observaciones        = $request->observaciones;
            $pago->eliminado            = 0;
            $pago->save();

            $ultimoPago = Pago::where('eliminado', 0)->where('idUsuario', $idUsuario)->orderByDesc('fechaPago')->first();

            $usuario->idMembresia           = $ultimoPago?->idMembresia;
            $usuario->fechaUltimoPago       = $ultimoPago?->fechaPago;
            $usuario->fechaVigencia         = $ultimoPago?->fechaVigencia;
            $usuario->pagoMensualEsperado   = $membresia->costo;
            $usuario->save();

            return redirect('admin/usuarios/' . $usuario->idUsuario)->with('status_success', 'El pago se ha registrado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('status_fail', 'Whoops! ' . $e->getMessage());
        }
    }
    public function delete_pago($idUsuario, $idPago)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        try {
            \DB::beginTransaction();

            $usuario = User::findOrFail($idUsuario);

            $pago = Pago::where('idPago', $idPago)->where('idUsuario', $idUsuario)->where('eliminado', 0)->firstOrFail();
            $pago->eliminado = 1;
            $pago->save();

            $ultimoPago = Pago::with('membresia')->where('eliminado', 0)->where('idUsuario', $idUsuario)->orderByDesc('fechaPago')->orderByDesc('idPago')->first();

            if ($ultimoPago) {
                $usuario->fechaUltimoPago   = $ultimoPago->fechaPago;
                $usuario->fechaVigencia     = $ultimoPago->fechaVigencia;
                $usuario->idMembresia       = $ultimoPago->idMembresia;

                if ($ultimoPago->membresia) {
                    $usuario->pagoMensualEsperado = $ultimoPago->membresia->costo;
                } else {
                    $usuario->pagoMensualEsperado = $ultimoPago->monto;
                }
            }
            else {
                $usuario->fechaUltimoPago       = null;
                $usuario->fechaVigencia         = null;
                $usuario->idMembresia           = null;
                $usuario->pagoMensualEsperado   = null;
            }

            $usuario->save();

            \DB::commit();

            return redirect('admin/usuarios/' . $usuario->idUsuario)->with('status_success', 'El pago se ha eliminado correctamente.');
        } catch (\Exception $e) {
            \DB::rollBack();

            return back()
                ->withInput()
                ->with('status_fail', 'Whoops! ' . $e->getMessage());
        }
    }


    public function delete($idUsuario)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403,'No autorizado.');
        }

        try {
            $usuario = User::where('eliminado', 0)->findOrFail($idUsuario);

            if ((int) auth()->user()->idUsuario === (int) $usuario->idUsuario) {
                return back()->with('status_fail', 'No puedes eliminar tu propio usuario.');
            }

            $usuario->eliminado = 1;
            $usuario->remember_token = null;
            $usuario->save();

            return redirect('admin/usuarios')->with('status_success', 'El usuario ha sido eliminado correctamente.');
        }
        catch (\Exception $e) {
            return back()->with('status_fail', 'Whoops! ' . $e->getMessage());
        }

    }



    public function send_password_by_email($idUsuario){

        $usuario = User::find($idUsuario);

        try{
            Mail::to([$usuario->email])->send(new SendPasswordMail($usuario));

            //return (new SendPasswordMail($usuario))->render();

            $msj = "Correo Enviado a [".$usuario->idUsuario."] ".$usuario->apellidoPaterno." ".$usuario->apellidoMaterno." ".$usuario->nombre;

            return \redirect('admin/usuarios/'.$usuario->idUsuario)->with('status_success',$msj);
        }
        catch (\Exception $e){
            return \redirect('admin/usuarios/'.$usuario->idUsuario)->with('status_fail',$e->getMessage());
        }
    }
    public function export(Request $request)
    {
        $fecha              = Carbon::now();

        $idStatusUsuario     = $request->get('idStatusUsuario');
        $txtBuscar           = $request->get('txtBuscar');

        return Excel::download(new UsersExport($idStatusUsuario,$txtBuscar), 'usuarios_'.$fecha.'.xlsx');
    }
}
