<?php

namespace App\Http\Controllers;

use App\Models\CategoriaCarga;
use App\Models\CategoriaMov;
use App\Models\CategoriaZona;
use App\Models\Ejercicio;
use App\Models\Etapa;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }

    public function index(Request $request)
    {
        $txtBuscar= trim((string) $request->get('txtBuscar'));
        $idEtapa = trim((string) $request->get('idEtapa'));
        $idCategoriaZona = trim((string) $request->get('idCategoriaZona'));
        $idCategoriaCarga = trim((string) $request->get('idCategoriaCarga'));
        $idCategoriaMov = trim((string) $request->get('idCategoriaMov'));
        $idStatus = trim((string) $request->get('idStatus'));

        $query = Ejercicio::query()
            ->with(['etapas', 'categoriaZona', 'categoriaCarga', 'categoriaMov']);

        if ($idEtapa !== '') {
            $query->where('idEtapas', $idEtapa);
        }

        if ($idCategoriaZona !== '') {
            $query->where('idCategoriaZona', $idCategoriaZona);
        }

        if ($idCategoriaCarga !== '') {
            $query->where('idCategoriaCarga', $idCategoriaCarga);
        }

        if ($idCategoriaMov !== '') {
            $query->where('idCategoriaMov', $idCategoriaMov);
        }

        if ($idStatus !== '') {
            $query->where('activo', $idStatus);
        }

        if ($txtBuscar !== '') {
            $query->where('ejercicio', 'like', '%' . $txtBuscar . '%');
        }

        $ejercicios = $query->orderBy('ejercicio', 'ASC')->paginate(50);

        $etapas = Etapa::where('activo', 1)->orderBy('nombre', 'ASC')->get();
        $categoriasZona = CategoriaZona::orderBy('descripcion', 'ASC')->get();
        $categoriasCarga = CategoriaCarga::orderBy('descripcion', 'ASC')->get();
        $categoriasMov = CategoriaMov::orderBy('descripcion', 'ASC')->get();

        return view('admin.ejercicios.index', compact('ejercicios', 'etapas', 'categoriasZona', 'categoriasCarga', 'categoriasMov'));
    }

    public function create()
    {
        $etapas = Etapa::where('activo', 1)->orderBy('nombre', 'ASC')->get();
        $categoriasZona = CategoriaZona::orderBy('descripcion', 'ASC')->get();
        $categoriasCarga = CategoriaCarga::orderBy('descripcion', 'ASC')->get();
        $categoriasMov = CategoriaMov::orderBy('descripcion', 'ASC')->get();

        return view('admin.ejercicios.create', compact('etapas', 'categoriasZona', 'categoriasCarga', 'categoriasMov'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idEtapas'   => ['required', 'integer'],
            'idCategoriaZona' => ['required', 'integer'],
            'idCategoriaCarga' => ['required', 'integer'],
            'idCategoriaMov' => ['required', 'integer'],
            'ejercicio'  => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            $ejercicio = new Ejercicio();
            $ejercicio->idEtapas = $request->idEtapas;
            $ejercicio->idCategoriaZona = $request->idCategoriaZona;
            $ejercicio->idCategoriaCarga = $request->idCategoriaCarga;
            $ejercicio->idCategoriaMov = $request->idCategoriaMov;
            $ejercicio->ejercicio = mb_strtoupper(trim($request->ejercicio));
            $ejercicio->descripcion = $request->descripcion;
            $ejercicio->activo = 1;
            $ejercicio->save();

            return redirect('admin/ejercicios')
                ->with('status_success', 'Ejercicio creado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('status_fail', $e->getMessage());
        }
    }

    public function show($idEjercicio)
    {
        $ejercicio = Ejercicio::with(['etapas', 'categoriaZona', 'categoriaCarga', 'categoriaMov'])->findOrFail($idEjercicio);
        return view('admin.ejercicios.show', compact('ejercicio'));
    }

    public function edit($idEjercicio)
    {
        $ejercicio = Ejercicio::findOrFail($idEjercicio);
        $etapas = Etapa::where('activo', 1)->orderBy('nombre', 'ASC')->get();
        $categoriasZona = CategoriaZona::orderBy('descripcion', 'ASC')->get();
        $categoriasCarga = CategoriaCarga::orderBy('descripcion', 'ASC')->get();
        $categoriasMov = CategoriaMov::orderBy('descripcion', 'ASC')->get();

        return view('admin.ejercicios.edit', compact('ejercicio', 'etapas', 'categoriasZona', 'categoriasCarga', 'categoriasMov'));
    }

    public function update(Request $request, $idEjercicio)
    {
        $request->validate([
            'idEtapas'   => ['required', 'integer'],
            'idCategoriaZona' => ['required', 'integer'],
            'idCategoriaCarga' => ['required', 'integer'],
            'idCategoriaMov' => ['required', 'integer'],
            'ejercicio'  => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:100'],
            'activo'   => ['required', 'in:0,1'],
        ]);

        try {
            $ejercicio  = Ejercicio::findOrFail($idEjercicio);
            $ejercicio->idEtapas = $request->idEtapas;
            $ejercicio->idCategoriaZona = $request->idCategoriaZona;
            $ejercicio->idCategoriaCarga = $request->idCategoriaCarga;
            $ejercicio->idCategoriaMov = $request->idCategoriaMov;
            $ejercicio->ejercicio  = mb_strtoupper(trim($request->ejercicio));
            $ejercicio->descripcion  = $request->descripcion;
            $ejercicio->activo  = $request->activo;
            $ejercicio->save();

            return redirect('admin/ejercicios/' . $ejercicio->idEjercicio)
                ->with('status_success', 'Ejercicio actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('status_fail', $e->getMessage());
        }
    }

    public function destroy($idEjercicio)
    {
        try {
            $ejercicio = Ejercicio::findOrFail($idEjercicio);
            $ejercicio->activo = 0;
            $ejercicio->save();

            return redirect('admin/ejercicios')
                ->with('status_success', 'Ejercicio desactivado correctamente.');
        } catch (\Exception $e) {
            return back()->with('status_fail', $e->getMessage());
        }
    }
}