<?php

namespace App\Http\Controllers\Intranet\admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empleado;
use App\Models\Sistema\Mensaje;
use App\Models\Sistema\Notificacion;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class IntranetPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('intranet.dashboard.dashboard');
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

    public function profile()
    {
        return view('intranet.infojet.profile');
    }
    public function getEmpleadosChat(Request $request)
    {
        if ($request->ajax()) {
            $ruta = Config::get('constantes.folder_img_usuarios');
            $ruta = trim($ruta);
            $superAdminstradores = User::role('Administrador Sistema')->get();

            if (session('rol_principal_id') == 1) {
                $empleados = User::role('Empleado')->with('empleado')->whereHas('empleado', function ($q) {
                    $q->where('estado', 1);
                })->with('empleado.cargo')->with('empleado.cargo.area')->with('empleado.cargo.area.empresa')->get();
            } else {
                $empelados_ids = $this->getEmpleadosWithChat(session('id_usuario'));
                $empleados = User::role('Empleado')->whereIn('id', $empelados_ids)->with('empleado')->with('empleado.cargo')->with('empleado.cargo.area')->with('empleado.cargo.area.empresa')->get();
            }
            foreach ($superAdminstradores as $superAdminstrador) {
                $superAdminstrador['cant_sin_leer'] = $superAdminstrador->mensajes_remitente()->where('estado', 0)->where('destinatario_id', session('id_usuario'))->count();
                $superAdminstrador['foto_chat'] = 'usuario-inicial.jpg';
                $superAdminstrador['nombre_chat'] = $superAdminstrador['name'];
            }

            foreach ($empleados as $empleado) {
                if ($empleado->hasRole('Administrador Empresa')) {
                    $empleado['adminEmpresa'] = 1;
                } else {
                    $empleado['adminEmpresa'] = 0;
                }
                $empleado['cant_sin_leer'] = $empleado->mensajes_remitente()->where('estado', 0)->where('destinatario_id', session('id_usuario'))->count();
                $empleado['foto_chat'] = $empleado->empleado->foto;
                $empleado['nombre_chat'] = $empleado->empleado['nombres'] . ' ' . $empleado->empleado['apellidos'];
            }
            return response()->json(['superAdminstradores' => $superAdminstradores, 'empleados' => $empleados]);
        } else {
            abort(404);
        }
    }
    public function getMensajesNuevosEmpleadosChat(Request $request)
    {
        if ($request->ajax()) {
            $id_usuario = session('id_usuario');
            $mensajesNuevos = Mensaje::where('estado', 0)->where('destinatario_id', $id_usuario)->with('remitente')->with('remitente.empleado')->with('remitente.mensajes_remitente')->get();
            foreach ($mensajesNuevos as $mensaje) {
                if ($mensaje->remitente->empleado) {
                    $mensaje->remitente['fotoChat'] = $mensaje->remitente->empleado->foto;
                    $mensaje->remitente['nombre_chat'] = $mensaje->remitente->empleado->nombres . ' ' . $mensaje->remitente->empleado->apellidos;
                } else {
                    $mensaje->remitente['fotoChat'] = 'usuario-inicial.jpg';
                    $mensaje->remitente['nombre_chat'] = $mensaje->remitente->name;
                }
                $date1 = new DateTime($mensaje->fec_creacion);
                $date2 = new DateTime("now");
                $diff = $date1->diff($date2);
                $mensaje['diff_creacion'] = $this->get_format($diff);
                $mensaje->remitente['cant_sin_leer'] = $mensaje->remitente->mensajes_remitente()->where('estado', 0)->where('destinatario_id', session('id_usuario'))->count();
            }
            return response()->json(['mensajesDestinatario' => $mensajesNuevos, 'cantidadMensajesNuevos' => $mensajesNuevos->count()]);
        } else {
            abort(404);
        }
    }
    public function getEmpleadosWithChat($empleado_id)
    {
        $empleadoFind = Empleado::findOrFail($empleado_id);
        $ids_empresas = [];
        if ($empleadoFind->empresas_tranv->count() > 0) {
            foreach ($empleadoFind->empresas_tranv as $empresa) {
                $ids_empresas[] = $empresa->id;
            }
            $empleados1 = Empleado::where('estado', 1)
                ->whereHas('cargo', function ($p) use ($ids_empresas) {
                    $p->whereHas('area', function ($q) use ($ids_empresas) {
                        $q->whereIn('empresa_id', $ids_empresas);
                    });
                })->get();
            $empleados2 = Empleado::where('estado', 1)
                ->whereHas('cargo', function ($p) use ($ids_empresas) {
                    $p->whereHas('area', function ($q) use ($ids_empresas) {
                        $q->whereNotIn('empresa_id', $ids_empresas);
                    });
                })->whereHas('empresas_tranv', function ($p) use ($empleadoFind) {
                    $p->where('empresa_id', $empleadoFind->cargo->area->empresa_id);
                })->get();
            $empleados = $empleados1->concat($empleados2);
        } else {
            $empleados = Empleado::where('estado', 1)
                ->whereHas('cargo', function ($p) use ($empleadoFind) {
                    $p->whereHas('area', function ($q) use ($empleadoFind) {
                        $q->where('empresa_id', $empleadoFind->cargo->area->empresa_id);
                    });
                })->get();
        }

        return $empleados->pluck('id')->toArray();
    }
    public function setNuevoMensaje(Request $request)
    {
        if ($request->ajax()) {
            $request['fec_creacion'] = date('Y-m-d H:i:s');
            $mensaje = Mensaje::create($request->all());
            return response()->json(['mensaje' => $mensaje, 'respuesta' => 'ok']);
        } else {
            abort(404);
        }
    }

    public function getMensajesChatUsuario(Request $request)
    {
        if ($request->ajax()) {

            $mensajes = Mensaje::with('remitente')->with('destinatario')->whereIn('remitente_id', [session('id_usuario'), $request['id_usuario']])->whereIn('destinatario_id', [session('id_usuario'), $request['id_usuario']])->get();

            foreach ($mensajes as $mensaje) {
                if ($mensaje->destinatario_id == session('id_usuario')) {
                    $mensaje->update(['estado' => 1]);
                }
            }

            return response()->json(['mensajes' => $mensajes]);
        } else {
            abort(404);
        }
    }
    public function getMensajesNuevosDestinatarioChat(Request $request)
    {
        if ($request->ajax()) {
            $mensajes = Mensaje::where('estado', 0)->where('remitente_id', $request['id_usuario'])->where('destinatario_id', session('id_usuario'))->get();
            foreach ($mensajes as $mensaje) {
                if ($mensaje->destinatario_id == session('id_usuario')) {
                    $mensaje->update(['estado' => 1]);
                }
            }
            return response()->json(['mensajes' => $mensajes]);
        } else {
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getNotificacionesEmpleado(Request $request)
    {
        if ($request->ajax()) {
            $notificaciones = Notificacion::where('usuario_id', 3)->where('estado', 1)->get();
            foreach ($notificaciones as $notificacion) {
                $date1 = new DateTime($notificacion->fec_creacion);
                $date2 = new DateTime("now");
                $diff = $date1->diff($date2);
                $notificacion['diff_creacion'] = $this->get_format($diff);
            }
            return response()->json(['notificaciones' => $notificaciones, 'cant_notificaciones' => $notificaciones->count() ]);
        } else {
            abort(404);
        }
    }
    public function get_format($df)
    {

        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' A ' : $df->y . ' A ';
        }
        if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' M ' : $df->m . ' M ';
        }
        if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' D ' : $df->d . ' D ';
        }
        if ($df->h > 0) {
            // hours
            $str .= ($df->h > 1) ? $df->h . ' H ' : $df->h . ' H ';
        }
        if ($df->i > 0) {
            // minutes
            $str .= ($df->i > 1) ? $df->i . ' mins ' : $df->i . ' min ';
        }
        if ($df->s > 0) {
            // seconds
            $str .= ($df->s > 1) ? $df->s . ' segs ' : $df->s . ' seg ';
        }

        return $str;
    }
}
