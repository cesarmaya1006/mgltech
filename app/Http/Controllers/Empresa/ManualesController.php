<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Area;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\Empresa\ManualFuncion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


class ManualesController extends Controller
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

        return view('intranet.empresa.modulo_archivo.manuales_funcion.index', compact('grupos', 'usuario'));
    }

    public function getAreasManuales(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['areas' => Area::with('cargos')->with('cargos.manual')->where('empresa_id',$_GET['id'])->get()]);
        } else {
            abort(404);
        }
    }

    public function addManual(Request $request)
    {
        if ($request->ajax()) {
            // - - - - - - - - - - - - - - - - - - - - - - - -
            if ($request->hasFile('manual')) {
                $ruta = Config::get('constantes.folder_manuales');
                $ruta = trim($ruta);

                $doc_subido = $request->manual;
                $nombre_doc = time() . '-' . utf8_encode(utf8_decode($doc_subido->getClientOriginalName()));
                $titulo = utf8_encode(utf8_decode($doc_subido->getClientOriginalName()));
                $peso = filesize($doc_subido) / 1000000;
                $doc_subido->move($ruta, $nombre_doc);

            }
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $manual['id'] = $request['id_cargo'];
            $manual['titulo'] = $titulo;
            $manual['url'] = $nombre_doc;
            $manual['peso'] = $peso;
            $manualNew = ManualFuncion::create($manual);
            return response()->json(['mensaje' => 'ok','maual' => $manualNew]);
        } else {
            abort(404);
        }
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
    public function eliminarManual(Request $request, $id)
    {
        if ($request->ajax()) {
            if (ManualFuncion::destroy($id)) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
