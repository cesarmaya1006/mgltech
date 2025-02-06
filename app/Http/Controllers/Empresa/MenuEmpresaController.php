<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Config\Menu;
use App\Models\Empresa\Empresa;
use Illuminate\Http\Request;

class MenuEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::orderBy('id')->pluck('empresa', 'id')->toArray();
        $menus = Menu::getMenu();
        $menusEmpresas = Menu::with('empresas_menu')->get()->pluck('empresas_menu', 'id')->toArray();
        return view('intranet.config.menu_empresa.index', compact('empresas','menus','menusEmpresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $menus = new Menu();
            if ($request->input('estado') == 1) {
                $menus->find($request->input('menu_id'))->empresas_menu()->attach($request->input('empresa_id'));
                return response()->json(['respuesta' => 'La empresa se asigno correctamente','tipo'=> 'success']);
            } else {
                $menus->find($request->input('menu_id'))->empresas_menu()->detach($request->input('empresa_id'));
                return response()->json(['respuesta' => 'La empresa se elimino correctamente','tipo'=> 'warning']);
            }
        } else {
            abort(404);
        }
    }
}
