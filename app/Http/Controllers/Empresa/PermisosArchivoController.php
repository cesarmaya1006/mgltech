<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empleado;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisosArchivoController extends Controller
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

        return view('intranet.empresa.modulo_archivo.permisosarchivo.index', compact('grupos', 'usuario'));
    }

    public function getCargarEmpleadosEmpresa(Request $request)
    {
        if ($request->ajax()) {
            $empresa_id = $_GET['id'];
            $empleados = Empleado::with('usuario')->with('usuario.permissions')->with('cargo')->with('cargo.area')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            return response()->json(['empleados' => $empleados]);
        } else {
            abort(404);
        }
    }
    public function getPermisosEmpleado(Request $request)
    {
        if ($request->ajax()) {
            $permisos = [
                ['name' =>'hojas_vida.index','nombre' => 'Hojas de vida',],
                ['name' =>'manuales.index','nombre' => 'Manuales de funciones',],
                ['name' =>'soportes_afiliacion.index','nombre' => 'Soportes de Afiliación',],
                ['name' =>'documentos_contractuales.index','nombre' => 'Documentos contractuales',],
                ['name' =>'sit_lab_gen.index','nombre' => 'Situaciones laborales generales',],
                ['name' =>'histclinicasocup.index','nombre' => 'Historias clínicas ocupacionales',],
                ['name' =>'dotaciones.index','nombre' => 'Entrega de dotación, elementos de trabajo y de protección',],
                ['name' =>'proceso_discip.index','nombre' => 'Proceso disciplinario, faltas y sanciones',],
                ['name' =>'evaluacion_desemp.index','nombre' => 'Evaluaciones de desempeño',],
                ['name' =>'vacaciones.index','nombre' => 'Vacaciones y licencias',],
                ['name' =>'doc_retiro.index','nombre' => 'Documentos de Retiro',],
                ['name' =>'capacitacion.index','nombre' => 'Capacitaciones y certificaciones',],
                ['name' =>'permisosarchivo.index','nombre' => 'Permisos Archivo',],
            ];
            $empleado_id = $_GET['id'];
            $empleado = Empleado::findOrFail($empleado_id);
            $permisosList = [];
            foreach ($permisos as $key => $permiso) {
                if ($empleado->usuario->hasPermissionTo($permiso['name'])) {
                    $permisosList[]=['name'=>$permiso['name'],'permiso'=>$permiso['nombre'],"valor" => 1];
                } else {
                    $permisosList[]=['name'=>$permiso['name'],'permiso'=>$permiso['nombre'],"valor" => 0];
                }

            }


            $permisos = $empleado->usuario->permissions->whereIn('name', $permisosList);
            return response()->json(['permisosList' => $permisosList]);
        } else {
            abort(404);
        }
    }
}
