<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisoRolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        $permisos = Permission::orderBy('id')->get();
        return view('intranet.config.permiso_rol.index', compact('roles', 'permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $valor = intval($request['value']);
            $rol = Role::findOrFail(intval($request['role_id']));
            $permiso = Permission::findOrFail(intval($request['permission_id']));
            if ($valor==1) {
                $rol->revokePermissionTo($permiso);
                return response()->json(['respuesta' => 'El permiso se elimino correctamente rol ','tipo'=> 'warning']);
            } else {
                $rol->givePermissionTo($permiso);
                return response()->json(['respuesta' => 'El permiso se asigno correctamente rol' ,'tipo'=> 'success']);
            }
        } else {
            abort(404);
        }
    }

    public function excepciones(string $permission_id, string $role_id){
        $rol = Role::findOrFail($role_id);
        $permiso = Permission::findOrFail($permission_id);
        $usuarios = User::role($rol->name)->get();
        return view('intranet.config.permiso_rol.excepcion', compact('rol','permiso', 'usuarios'));
    }
    public function store_excepciones(Request $request){
        if ($request->ajax()) {
            $valor = intval($request['value']);
            $usuario = User::findOrfail($request['usuario_id']);
            if ($valor==1) {
                $usuario->revokePermissionTo($request['permission_name']);
                return response()->json(['respuesta' => 'El permiso se elimino correctamente rol ','tipo'=> 'warning']);
            } else {
                $usuario->givePermissionTo($request['permission_name']);
                return response()->json(['respuesta' => 'El permiso se asigno correctamente rol' ,'tipo'=> 'success']);
            }
        } else {
            abort(404);
        }
    }
}
