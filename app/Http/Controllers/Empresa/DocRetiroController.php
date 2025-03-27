<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empleado;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\Empresa\SoporteAarchivoEmpleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DocRetiroController extends Controller
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

        return view('intranet.empresa.modulo_archivo.doc_retiro.index', compact('grupos', 'usuario'));
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

    public function getSoportes(Request $request)
    {
        if ($request->ajax()) {
            $empleado_id = $_GET['id'];
            $soportes = SoporteAarchivoEmpleado::where('tipo','DocRetiro')->where('empleado_id',$empleado_id)->get();
            return response()->json(['soportes' => $soportes]);
        } else {
            abort(404);
        }
    }

    public function setSoportes(Request $request)
    {
        if ($request->ajax()) {
            $empleado = Empleado::findOrFail($request['empleado_id']);
            $empresa_id = $empleado->cargo->area->empresa_id;
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
            $soporte['tipo'] = 'DocRetiro';
            $soporte['titulo'] = $titulo;
            $soporte['url'] = $nombre_doc;
            $soporte['peso'] = $peso;
            $soporteNew = SoporteAarchivoEmpleado::create($soporte);
            $empleados = Empleado::with('soportes')->with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            return response()->json(['mensaje' => 'ok','empleados' => $empleados]);
        } else {
            abort(404);
        }
    }
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
}
