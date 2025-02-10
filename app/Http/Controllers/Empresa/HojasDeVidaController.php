<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empleado;
use App\Models\Empresa\Empresa;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\User;
use Illuminate\Http\Request;

class HojasDeVidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = User::findOrFail(session('id_usuario'));
        if (session('rol_principal_id') < 3) {
            $grupos = GrupoEmpresa::get();
        } else {
            if ($usuario->empleado->empresas_tranv->count() > 0) {
                $idEmpresas = [];
                foreach ($usuario->empleado->empresas_tranv as $empresas) {
                    array_push($idEmpresas, $empresas->id);
                }
                $grupos = GrupoEmpresa::whereHas('empresas', function ($q) use ($idEmpresas) {
                    $q->whereIn('id', $idEmpresas);
                })->get();
            } else {
                $grupos = GrupoEmpresa::where('id', $usuario->empleado->cargo->area->empresa->grupo->id)->get();
            }
        }

        return view('intranet.empresa.modulo_archivo.hojas_de_vida.index', compact('grupos', 'usuario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getUsuariosHojasVida(Request $request)
    {
        if ($request->ajax()) {
            $empresa_id = $_GET['id'];
            $empleados = Empleado::with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use($empresa_id) {
                $q->whereHas('area', function ($r) use($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            return response()->json(['empleados' => $empleados]);
        } else {
            abort(404);
        }
    }
}
