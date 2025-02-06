<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Config\TipoDocumento;
use App\Models\Empresa\Empresa;
use App\Models\Empresa\GrupoEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Laravel\Facades\Image;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = GrupoEmpresa::get();
        return view('intranet.empresas.empresas.index',compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposdocu = TipoDocumento::get();
        return view('intranet.empresas.empresas.crear',compact('tiposdocu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // - - - - - - - - - - - - - - - - - - - - - - - -
        if ($request->hasFile('logo')) {
            $ruta = Config::get('constantes.folder_img_empresas');
            $ruta = trim($ruta);

            $logo = $request->logo;
            $imagen_logo = Image::read($logo);
            $nombrelogo = time() . $logo->getClientOriginalName();
            $imagen_logo->resize(500, 500);
            $imagen_logo->save($ruta . $nombrelogo, 100);
            $empresa_new['logo'] = $nombrelogo;
        }
        // - - - - - - - - - - - - - - - - - - - - - - - -
        $empresa_new['emp_grupo_id'] = $request['emp_grupo_id'];
        $empresa_new['tipo_documento_id'] = $request['tipo_documento_id'];
        $empresa_new['identificacion'] = $request['identificacion'];
        $empresa_new['empresa'] = ucwords(strtolower($request['empresa']));
        $empresa_new['email'] = strtolower($request['email']);
        $empresa_new['telefono'] = $request['telefono'];
        $empresa_new['direccion'] = $request['direccion'];
        $empresa_new['contacto'] = ucwords(strtolower($request['contacto']));
        $empresa_new['cargo'] = ucwords(strtolower($request['cargo']));
        $empresa = Empresa::create($empresa_new);
        return redirect('configuracion_sis/empresa')->with('mensaje', 'Empresa creado con éxito');
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
        $tiposdocu = TipoDocumento::get();
        $grupos = GrupoEmpresa::get();
        $empresa_edit = Empresa::findOrFail($id);
        return view('intranet.empresas.empresas.editar', compact('empresa_edit','tiposdocu','grupos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($request['estado'])) {
            $request['estado'] = 1;
        } else {
            $request['estado'] = 0;
        }
        Empresa::findOrFail($id)->update($request->all());
        return redirect('configuracion_sis/empresa')->with('mensaje', 'Empresa actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            if (Empresa::destroy($id)) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
