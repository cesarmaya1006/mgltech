<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Area;
use App\Models\Empresa\Cargo;
use App\Models\Empresa\Empleado;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisoEmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = GrupoEmpresa::get();
        $usuario = User::findOrFail(session('id_usuario'));
        if (session('rol_principal_id')>2) {
            $empleadoPrueba = Empleado::findOrFail(session('id_usuario'));
        }else{
            $empleadosPrueba = Empleado::get();
        $empleadoPrueba = $empleadosPrueba->first();
        }


        return view('intranet.config.permiso_empleados.index',compact('grupos','usuario','empleadoPrueba'));
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

    public function getAreas(Request $request){
        if ($request->ajax()) {
            return response()->json(['areas' => Area::with('cargos')->with('cargos.cargos_permisos')->where('empresa_id',$_GET['id'])->get()]);
        } else {
            abort(404);
        }
    }
    public function getCargos(Request $request){
        if ($request->ajax()) {

            return response()->json(['areas' => Area::where('id',$_GET['id'])->with('cargos')->with('cargos.cargos_permisos')->get()]);
        } else {
            abort(404);
        }
    }
    public function getEmpleadosCargos(Request $request){
        if ($request->ajax()) {
            return response()->json(['empleados' => Empleado::where('cargo_id',$_GET['cargo_id'])
                                                                    ->with('usuario.permissions')
                                                                    ->with('cargo')->get(),
                                            'permiso' => Permission::findOrFail($_GET['permiso_id'])]);
        } else {
            abort(404);
        }
    }
    public function getCambioCargo(Request $request){
        if ($request->ajax()) {
            $cargos = new Cargo();
            if ($request['estado'] == 0) {
                $cargo = Cargo::findOrFail($request['cargo_id']);
                $permiso = Permission::findorFail($request['permiso_id']);
                foreach ($cargo->empleados as $empleado) {
                    if (!$empleado->usuario->hasPermissionTo($permiso)) {
                        $empleado->usuario->givePermissionTo($permiso);
                    }
                }
                $cargos->find($request['cargo_id'])->cargos_permisos()->where('permission_id',$request['permiso_id'])->update(['estado'=>1]);
                return response()->json(['mensaje' => 'ok','respuesta' => 'El permiso se asigno correctamente','tipo'=> 'success']);
            } else {
                $cargo = Cargo::findOrFail($request['cargo_id']);
                $permiso = Permission::findorFail($request['permiso_id']);
                foreach ($cargo->empleados as $empleado) {
                    if ($empleado->usuario->hasPermissionTo($permiso)) {
                        $empleado->usuario->revokePermissionTo($permiso);
                    }
                }
                $cargos->find($request['cargo_id'])->cargos_permisos()->where('permission_id',$request['permiso_id'])->update(['estado'=>0]);
                return response()->json(['mensaje' => 'ng','respuesta' => 'El permiso se elimino correctamente','tipo'=> 'warning']);
            }
        } else {
            abort(404);
        }
    }

    public function setCambiopermisoEmpleado(Request $request){
        if ($request->ajax()) {
            $permiso = Permission::findorFail($request['id_permission']);
            $usuario = User::findOrFail($request['id_empleado']);
            if (!$usuario->hasPermissionTo($permiso)) {
                $usuario->givePermissionTo($permiso);
                return response()->json(['mensaje' => 'ok','respuesta' => 'El permiso se asigno correctamente','tipo'=> 'success']);
            }else{
                $usuario->revokePermissionTo($permiso);
                return response()->json(['mensaje' => 'ng','respuesta' => 'El permiso se elimino correctamente','tipo'=> 'warning']);
            }
        } else {
            abort(404);
        }
    }
}
