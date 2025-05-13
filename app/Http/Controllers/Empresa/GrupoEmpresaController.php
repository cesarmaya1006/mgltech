<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\GrupoEmpresaRequest;
use App\Models\Config\TipoDocumento;
use App\Models\Empresa\Empresa;
use App\Models\Empresa\GrupoEmpresa;
use Illuminate\Http\Request;

class GrupoEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = GrupoEmpresa::orderBy('id')->get();
        return view('intranet.empresas.grupo_empresas.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposdocu = TipoDocumento::get();
        return view('intranet.empresas.grupo_empresas.crear', compact('tiposdocu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GrupoEmpresaRequest $request)
    {
        GrupoEmpresa::create($request->all());
        return redirect('dashboard/configuracion_sis/grupo_empresas')->with('mensaje', 'Grupo Empresarial creado con éxito');
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
    public function edit($id)
    {
        $tiposdocu = TipoDocumento::get();
        $grupo_edit = GrupoEmpresa::findOrFail($id);
        return view('intranet.empresas.grupo_empresas.editar', compact('tiposdocu', 'grupo_edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $grupoUpdate = GrupoEmpresa::findOrFail($id);
        if (isset($request['estado'])) {
            $request['estado'] = 1;
            foreach ($grupoUpdate->empresas as $empresa) {
                Empresa::findOrFail($empresa->id)->update(['estado' => 1]);
            }
        } else {
            $request['estado'] = 0;
            foreach ($grupoUpdate->empresas as $empresa) {
                Empresa::findOrFail($empresa->id)->update(['estado' => 0]);
            }
        }
        GrupoEmpresa::findOrFail($id)->update($request->all());
        return redirect('dashboard/configuracion_sis/grupo_empresas')->with('mensaje', 'Grupo Empresarial actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $grupo = GrupoEmpresa::FindOrFail($id);
            if ($grupo->empresas->count()) {
                return response()->json(['mensaje' => 'ng']);
            } else {
                if (GrupoEmpresa::destroy($id)) {
                    return response()->json(['mensaje' => 'ok']);
                } else {
                    return response()->json(['mensaje' => 'ng']);
                }
            }
        } else {
            abort(404);
        }
    }

    public function activar(Request $request, $id)
    {
        if ($request->ajax()) {
            $cambioEstado['estado'] = $request['data_estado'];
            GrupoEmpresa::findOrFail($id)->update($cambioEstado);
            if ($request['data_estado'] == 0) {
                return response()->json(['mensaje' => 'Desactivada']);
            } else {
                return response()->json(['mensaje' => 'Activada']);
            }
        } else {
            abort(404);
        }
    }

    public function getEmpresas(Request $request)
    {
        if ($request->ajax()) {
            if ($_GET['id'] =='x') {
                $empresas = Empresa::with('tipos_docu')->where('emp_grupo_id', null)->get();
            } else {
                $empresas = Empresa::with('tipos_docu')->where('emp_grupo_id', $_GET['id'])->get();
            }

            return response()->json(['empresas' => $empresas]);
        } else {
            abort(404);
        }
    }
}
