<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\Menu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class MenuRolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rols = Role::orderBy('id')->pluck('name', 'id')->toArray();
        $menus = Menu::getMenu();
        $menusRols = Menu::with('roles_menu')->get()->pluck('roles_menu', 'id')->toArray();
        return view('intranet.config.menu_rol.index', compact('rols', 'menus', 'menusRols'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $menus = new Menu();
            if ($request->input('estado') == 1) {
                $menus->find($request->input('menu_id'))->roles_menu()->attach($request->input('rol_id'));
                return response()->json(['respuesta' => 'El rol se asigno correctamente','tipo'=> 'success']);
            } else {
                $menus->find($request->input('menu_id'))->roles_menu()->detach($request->input('rol_id'));
                return response()->json(['respuesta' => 'El rol se elimino correctamente','tipo'=> 'warning']);
            }
        } else {
            abort(404);
        }
    }
}
