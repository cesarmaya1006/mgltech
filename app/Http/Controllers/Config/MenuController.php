<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::getMenu();
        return view('intranet.config.menu.index', compact('menus'));
    }
    public function guardarOrden(Request $request)
    {
        if ($request->ajax()) {
            $menu = new Menu();
            $menu->guardarOrden($request->menu);
            return response()->json(['respuesta' => 'ok']);
        } else {
            abort(404);
        }
    }
}
