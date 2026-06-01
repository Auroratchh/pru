<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UsuarioCreateRequest;
use App\Http\Requests\UsuarioUpdateRequest;


use App\Models\FormaPago;
use App\Models\Gasto;
use App\Models\Pago;

use App\Models\Rol;
use App\Models\Sexo;
use App\Models\TipoGasto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class GastoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');

    }

    public function index( Request $request){

        $txtBuscar      = htmlspecialchars($request->get('txtBuscar'));
        $fechaIni       = $request->get('fechaIni');
        $fechaFin       = $request->get('fechaFin');

        if(!empty($fechaIni)){
            $fechaIni   =  Carbon::CreateFromFormat('d/m/Y', $request->input('fechaIni'));
        }
        else{
            $fechaIni   = Carbon::now()->startOfMonth();
        }
        if(!empty($fechaFin)){
            $fechaFin =  Carbon::CreateFromFormat('d/m/Y', $request->input('fechaFin'));
        }
        else{
            $fechaFin   = Carbon::now()->endOfMonth();
        }


        if(!empty($txtBuscar)){
            $gastos = Gasto::getAllGastosLike($fechaIni,$fechaFin,$txtBuscar);
        }
        else
        {
            $gastos = Gasto::getAllGastos($fechaIni,$fechaFin);
        }


        return view('admin.gastos.index',compact(
            'gastos',
            'txtBuscar',
            'fechaIni',
            'fechaFin'
        ));
    }


    public function create(){

        $tipoGasto  = TipoGasto::where('eliminado',0)->pluck('tipoGasto','idTipoGasto');

        return view('admin.gastos.create',compact('tipoGasto'));
    }
    public function store(Request $request)
    {
        $fechaGasto = $request->input('fechaGasto');

        if(!empty($fechaGasto)){
            $fechaGasto =  Carbon::CreateFromFormat('d/m/Y', $request->input('fechaGasto'));
        }

        try
        {
            $gasto                      = new Gasto();
            $gasto->idUsuario           = Auth::user()->idUsuario;
            $gasto->idTipoGasto           = $request->input('idTipoGasto');
            $gasto->gasto               = mb_strtoupper($request->input('gasto'));
            $gasto->descripcion         = $request->input('descripcion');
            $gasto->fechaGasto          = $fechaGasto;
            $gasto->monto               = $request->input('monto');
            $gasto->eliminado           = 0;
            $gasto->save();

            return redirect('admin/gastos/')->with('status_success','Gasto Guardado Satisfactoriamente.' );

        }

        catch (\Exception $e){
            return back()->withInput()->with('status_fail', 'Whoops! '.$e->getMessage());
        }

    }

    public function edit($idGasto)
    {
        $tipoGasto  = TipoGasto::where('eliminado',0)->pluck('tipoGasto','idTipoGasto');
        $gasto       = Gasto::find($idGasto);

        return view('admin.gastos.edit', compact('gasto','tipoGasto'));
    }


    public function update(Request $request, $idGasto)
    {
        $fechaGasto = $request->input('fechaGasto');

        if(!empty($fechaGasto)){
            $fechaGasto =  Carbon::CreateFromFormat('d/m/Y', $request->input('fechaGasto'));
        }

        try
        {
            $gasto                      = Gasto::find($idGasto);
            $gasto->idUsuario           = Auth::user()->idUsuario;
            $gasto->idTipoGasto         = $request->input('idTipoGasto');
            $gasto->gasto               = mb_strtoupper($request->input('gasto'));
            $gasto->descripcion         = $request->input('descripcion');
            $gasto->fechaGasto          = $fechaGasto;
            $gasto->monto               = $request->input('monto');
            $gasto->eliminado           = 0;
            $gasto->save();

            return redirect('admin/gastos/')->with('status_success','Gasto Actualizado Satisfactoriamente.' );

        }

        catch (\Exception $e){
            return back()->withInput()->with('status_fail', 'Whoops! '.$e->getMessage());
        }

    }

    public function destroy(Request $request, $idGasto){
        try{

            $gasto = Gasto::find($idGasto);
            $gasto->eliminado = 1;
            $gasto->save();

            return redirect('admin/gastos/')->with('status_success','El Gasto se ha eliminado correctamente.' );


        }
        catch (\Exception $e){
            return back()->withInput()->with('status_fail', 'Whoops! '.$e->getMessage());
        }

    }


}
