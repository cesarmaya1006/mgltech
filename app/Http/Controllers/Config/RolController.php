<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('intranet.config.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('intranet.config.roles.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Role::create(['name' => ucwords(strtolower($request['name']))]);
        return redirect('configuracion_sis/rol')->with('mensaje', 'Rol creado con éxito');
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
        $rol_edit = Role::findOrFail($id);
        return view('intranet.config.roles.editar', compact('rol_edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rol_edit['name'] = ucwords(strtolower($request['name']));
        Role::findOrFail($id)->update($rol_edit);
        return redirect('configuracion_sis/rol')->with('mensaje', 'Rol actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $rol = Role::findOrFail($id);

            $rol_del = Role::findByName($rol->name);
            $rol_del->delete();
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
