<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empleado;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\Empresa\SoporteAarchivoEmpleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SoportesAfiliacionController extends Controller
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

        return view('intranet.empresa.modulo_archivo.soportes_afiliacion.index', compact('grupos', 'usuario'));
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
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $soporte = SoporteAarchivoEmpleado::findOrFail($request['id']);
            if (SoporteAarchivoEmpleado::destroy($request['id'])) {
                $ruta = Config::get('constantes.folder_soportes');
                $ruta = trim($ruta);
                unlink($ruta.$soporte->url);
                $empleados = Empleado::with('soportes')->with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($soporte) {
                    $q->whereHas('area', function ($r) use ($soporte) {
                        $r->where('empresa_id', $soporte->empleado->cargo->area->empresa_id);
                    });
                })->get();

                return response()->json(['mensaje' => 'ok','empleados' => $empleados]);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
    public function getCargarEmpleadosEmpresa(Request $request)
    {
        if ($request->ajax()) {
            $empresa_id = $_GET['id'];
            $empleados = Empleado::with('soportes')->with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            return response()->json(['empleados' => $empleados]);
        } else {
            abort(404);
        }
    }
    public function getSoporteAfiliacion(Request $request)
    {
        if ($request->ajax()) {
            $empleado_id = $_GET['id'];
            $soportes = SoporteAarchivoEmpleado::where('tipo','soporteAfiliacion')->where('empleado_id',$empleado_id)->get();
            return response()->json(['soportes' => $soportes]);
        } else {
            abort(404);
        }
    }

    public function setSoporteAfiliacion(Request $request)
    {
        if ($request->ajax()) {
            $empleado = Empleado::findOrFail($request['empleado_id']);
            $empresa_id = $empleado->cargo->area->empresa_id;
            $empleados = Empleado::with('soportes')->with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            // - - - - - - - - - - - - - - - - - - - - - - - -
            if ($request->hasFile('fileToUpload')) {
                $ruta = Config::get('constantes.folder_soportes');
                $ruta = trim($ruta);

                $doc_subido = $request->fileToUpload;
                $nombre_doc = time() . '-' . utf8_encode(utf8_decode($doc_subido->getClientOriginalName()));
                $titulo = utf8_encode(utf8_decode($doc_subido->getClientOriginalName()));
                $peso = filesize($doc_subido) / 1000000;
                $doc_subido->move($ruta, $nombre_doc);

            }
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $soporte['empleado_id'] = $request['empleado_id'];
            $soporte['tipo'] = 'soporteAfiliacion';
            $soporte['titulo'] = $titulo;
            $soporte['url'] = $nombre_doc;
            $soporte['peso'] = $peso;
            $soporteNew = SoporteAarchivoEmpleado::create($soporte);
            return response()->json(['mensaje' => 'ok','maual' => $soporteNew ,'empleados' => $empleados]);


            return response()->json(['respuesta' => 'ok']);
        } else {
            abort(404);
        }
    }
}
