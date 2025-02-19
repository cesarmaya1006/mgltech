<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Config\TipoDocumento;
use App\Models\Empresa\Cargo;
use App\Models\Empresa\EducacionEmpleado;
use App\Models\Empresa\Empleado;
use App\Models\Empresa\GrupoEmpresa;
use App\Models\Empresa\TipoEducacion;
use App\Models\Empresa\Pais;
use App\Models\Empresa\Departamento;
use App\Models\Empresa\ExperienciaLab;
use App\Models\Empresa\Municipio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Laravel\Facades\Image;

class HojasDeVidaController extends Controller
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

        return view('intranet.empresa.modulo_archivo.hojas_de_vida.index', compact('grupos', 'usuario'));
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
        $empleado = Empleado::findOrFail($id);
        $tiposdocu = TipoDocumento::get();
        $tiposeducacion = TipoEducacion::get();
        $paises = Pais::get();
        $departamentos = Departamento::get();
        return view('intranet.empresa.modulo_archivo.hojas_de_vida.editar', compact('empleado', 'tiposdocu', 'tiposeducacion','paises','departamentos'));
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
    public function getUsuariosHojasVida(Request $request)
    {
        if ($request->ajax()) {
            $empresa_id = $_GET['id'];
            $empleados = Empleado::with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            return response()->json(['empleados' => $empleados]);
        } else {
            abort(404);
        }
    }
    public function getFiltrarUsuarioNombre(Request $request)
    {
        if ($request->ajax()) {
            $busqueda = $_GET['busqueda'];
            $empresa_id = $_GET['empresa_id'];
            $empleados = Empleado::with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();

            /*if ($busqueda != '') {
                $empleadosFind = $empleados->filter(function ($q) use ($busqueda) {
                    return Str::startsWith(strtolower($q['nombres']), strtolower($busqueda)) || Str::startsWith(strtolower($q['apellidos']), strtolower($busqueda));
                });
            } else {
                $empleadosFind = $empleados;
            }*/
            if ($busqueda != '') {
                $empleadosFind = Empleado::with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                    $q->whereHas('area', function ($r) use ($empresa_id) {
                        $r->where('empresa_id', $empresa_id);
                    });
                })->where(function ($query) use ($busqueda) {
                    $query->where('nombres', 'LIKE', "%{$busqueda}%")->orWhere('apellidos', 'like', "%{$busqueda}%");
                })->get();
            } else {
                $empleadosFind = $empleados;
            }

            return response()->json(['empleados' => $empleadosFind]);
        } else {
            abort(404);
        }
    }
    public function getUsuariosHojasVidaFormateado(Request $request)
    {
        if ($request->ajax()) {
            $empresa_id = $_GET['id'];
            $empleados = Empleado::with('cargo')->with('cargo.area')->with('usuario')->whereHas('cargo', function ($q) use ($empresa_id) {
                $q->whereHas('area', function ($r) use ($empresa_id) {
                    $r->where('empresa_id', $empresa_id);
                });
            })->get();
            $ruta = Config::get('constantes.folder_img_usuarios');
            $ruta = trim($ruta);
            // --------------------------------------------------------------------------------------------------------
            $collectionEmpleados = [];
            foreach ($empleados as $empleado) {
                $respuesta_html = '';
                $respuesta_html .= '<tr>';
                $respuesta_html .= '<td>';
                $respuesta_html .= '<div class="card card-widget widget-user shadow">';
                $respuesta_html .= '<div class="widget-user-header bg-info">';
                $respuesta_html .= '<h6 class="widget-user-username">';
                $respuesta_html .=  $empleado->nombres . ' ' . $empleado->apellidos;
                $respuesta_html .= '</h6>';
                $respuesta_html .= '<p class="widget-user-desc">' . $empleado->cargo->cargo . '</p>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '<div class="widget-user-image">';
                $respuesta_html .= '<img class="img-circle elevation-4"';
                $respuesta_html .= 'src="' . $ruta . $empleado->foto . '"';
                $respuesta_html .= 'alt="' . $empleado->nombres . ' ' . $empleado->apellidos . '">';
                $respuesta_html .= '</div>';
                $respuesta_html .= '<div class="card-footer">';
                $respuesta_html .= '<div class="row d-flex justify-content-md-center">';
                $respuesta_html .= '<div class="col-sm-2 border-right">';
                $respuesta_html .= '<div class="description-block">';
                $respuesta_html .= '<h5 class="description-header">Identificación</h5>';
                $respuesta_html .= '<span class="description-text">' . $empleado->identificacion . '</span>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '<div class="col-sm-2 border-right">';
                $respuesta_html .= '<div class="description-block">';
                $respuesta_html .= '<h5 class="description-header">Teléfono</h5>';
                $respuesta_html .= '<span class="description-text">' . $empleado->telefono . '</span>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '<div class="col-sm-3 border-right">';
                $respuesta_html .= '<div class="description-block">';
                $respuesta_html .= '<h5 class="description-header">Email</h5>';
                $respuesta_html .= '<span class="description-text text-lowercase text-nowrap">' . $empleado->usuario->email . '</span>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '<div class="col-sm-2 border-right">';
                $respuesta_html .= '<div class="description-block">';
                $respuesta_html .= '<h5 class="description-header">Vinculación</h5>';
                $respuesta_html .= '<span class="description-text text-lowercase text-nowrap">' . $empleado->vinculacion . '</span>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '<div class="col-sm-3">';
                $respuesta_html .= '<div class="description-block">';
                $respuesta_html .= '<h5 class="description-header">Opciones</h5>';
                $respuesta_html .= '<span class="description-text d-flex justify-content-md-between mt-2">';
                $respuesta_html .= '<a href="' . route('hojas_vida.hojas_de_vida-editar', ['id' => $empleado->id]) . '" ';
                $respuesta_html .= 'class="btn btn-primary pl-1 pr-1 btn-xs btn-sombra mr-3"><i class="fa fa-edit mr-1" aria-hidden="true"></i>';
                $respuesta_html .= 'Editar</a>';
                $respuesta_html .= '<a href="' . route('hojas_vida.hojas_de_vida-detalles', ['id' => $empleado->id]) . '" ';
                $respuesta_html .= 'class="btn btn-primary pl-1 pr-1 btn-xs btn-sombra"><i class="fa fa-eye mr-1" aria-hidden="true"></i>';
                $respuesta_html .= 'Detalles</a>';
                $respuesta_html .= '</span>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</div>';
                $respuesta_html .= '</td>';
                $respuesta_html .= '</tr>';
                array_push($collectionEmpleados, $respuesta_html);
            }
            //---------------------------------------------------------------------------------------------------------
            return response()->json(['empleados' => $empleados]);
        } else {
            abort(404);
        }
    }

    public function setCargoEmpleado(Request $request)
    {
        if ($request->ajax()) {
            Empleado::findOrFail($request['empleado_id'])->update(['cargo_id' => $request['cargo_id']]);
            $cargo = Cargo::findOrFail($request['cargo_id']);
            return response()->json(['mensaje' => 'ok', 'cargo' => $cargo->cargo, 'area' => $cargo->area->area]);
        } else {
            abort(404);
        }
    }
    public function setEmpleadodatos(Request $request)
    {
        if ($request->ajax()) {
            //==============================================================================================
            $nombres_array = explode(' ', ucwords(strtolower($request['nombres'])));
            $apellidos_array = explode(' ', ucwords(strtolower($request['apellidos'])));
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $usuario_editar = User::findOrFail($request['id']);
            $usuario_editar->update([
                'name' => ucwords(strtolower($nombres_array[0])) . ' ' . ucwords(strtolower($apellidos_array[0])),
                'email' => strtolower($request['email']),
            ]);
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $nombrefoto = $usuario_editar->empleado->foto;
            if ($request->hasFile('foto')) {
                $ruta = Config::get('constantes.folder_img_usuarios');
                $ruta = trim($ruta);
                if ($usuario_editar->empleado->foto != 'usuario-inicial.jpg') {
                    unlink($ruta . $usuario_editar->empleado->foto);
                }
                $foto = $request->foto;
                $imagen_foto = Image::read($foto);
                $nombrefoto = time() . $foto->getClientOriginalName();
                $imagen_foto->resize(400, 500);
                $imagen_foto->save($ruta . $nombrefoto, 100);
            }
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $usuario_editar->empleado->update([
                'tipo_documento_id' => $request['tipo_documento_id'],
                'identificacion' => $request['identificacion'],
                'nombres' => ucwords(strtolower($request['nombres'])),
                'apellidos' => ucwords(strtolower($request['apellidos'])),
                'telefono' => $request['telefono'],
                'direccion' => $request['direccion'],
                'foto' => $nombrefoto,
            ]);
            //==============================================================================================
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
    public function setEducacionEmpleadodatos(Request $request)
    {
        if ($request->ajax()) {
            //==============================================================================================
            // - - - - - - - - - - - - - - - - - - - - - - - -
            if ($request->hasFile('soporte')) {
                $ruta = Config::get('constantes.folder_doc_empleados');
                $ruta = trim($ruta);

                $doc_subido = $request->soporte;
                $nombre_doc = time() . '-' . utf8_encode(utf8_decode($doc_subido->getClientOriginalName()));
                $doc_subido->move($ruta, $nombre_doc);
            }
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $educacionNew['empleado_id'] = $request['empleado_id'];
            $educacionNew['tipo_id'] = $request['tipo_id'];
            $educacionNew['estado'] = $request['estado'];
            $educacionNew['ultimo_cursado'] = $request['ultimo_cursado'];
            $educacionNew['titulo'] = $request['titulo'];
            $educacionNew['establecimiento'] = $request['establecimiento'];
            $educacionNew['fecha_inicio'] = $request['fecha_inicio'];
            $educacionNew['fecha_termino'] = $request['fecha_termino'];
            $educacionNew['soporte'] = $nombre_doc;
            if ($request['tipo_id'] == 2) {
                $educacionNew['tarjeta_prof'] = $request['tarjeta_prof'];
            }
            if ($request['tipo_id'] == 3) {
                $educacionNew['cant_horas'] = $request['cant_horas'];
            }
            $educacion = EducacionEmpleado::create($educacionNew);
            //==============================================================================================
            return response()->json(['mensaje' => 'ok', 'educacion' => $educacion]);
        } else {
            abort(404);
        }
    }
    public function getCargarMunicipios(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['municipios' => Municipio::where('departamento_id',$_GET['id'])->get()]);
        } else {
            abort(404);
        }
    }
    public function addExperienciaLaboral(Request $request)
    {
        if ($request->ajax()) {
            $experienciaLaboral['empleado_id'] = $request['empleado_id'];
            $experienciaLaboral['tipo_entidad'] = $request['tipo_entidad'];
            $experienciaLaboral['entidad'] = $request['entidad'];
            $experienciaLaboral['actual'] = $request['actual'];
            $experienciaLaboral['pais'] = $request['pais'];
            $departamento = Departamento::findOrFail(intval($request['departamento']));
            $experienciaLaboral['departamento'] = $departamento->departamento;
            $experienciaLaboral['municipio'] = $request['municipio'];
            $experienciaLaboral['direccion'] = $request['direccion'];
            $experienciaLaboral['telefono'] = $request['telefono'];
            $experienciaLaboral['fecha_ingreso'] = $request['fecha_ingreso'];
            $experienciaLaboral['fecha_termino'] = $request['fecha_termino'];
            $experienciaLaboral['tipo_contrato'] = $request['tipo_contrato'];
            $experienciaLaboral['tiempo_contrato'] = $request['tiempo_contrato'];
            $experienciaLaboral['cargo'] = $request['cargo'];
            $experienciaLaboral['dependencia'] = $request['dependencia'];
            $experienciaLaboral['jefe_inmediato'] = $request['jefe_inmediato'];
            $experienciaLaboral['observaciones'] = $request['observaciones'];
            // - - - - - - - - - - - - - - - - - - - - - - - -
            if ($request->hasFile('soporte')) {
                $ruta = Config::get('constantes.folder_doc_empleados');
                $ruta = trim($ruta);

                $doc_subido = $request->soporte;
                $nombre_doc = time() . '-' . utf8_encode(utf8_decode($doc_subido->getClientOriginalName()));
                $doc_subido->move($ruta, $nombre_doc);
            }
            // - - - - - - - - - - - - - - - - - - - - - - - -
            $experienciaLaboral['soporte'] = $nombre_doc;
            $experienciaLaboralNew = ExperienciaLab::create($experienciaLaboral);
            return response()->json(['mensaje' => 'ok','experienciaLaboral' => $experienciaLaboralNew]);
        } else {
            abort(404);
        }
    }
    public function eliminarlaboralformal(Request $request, $id)
    {
        if ($request->ajax()) {
            if (ExperienciaLab::destroy($id)) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
