<?php

//use App\Models\Admin\Permiso;
//use Illuminate\Database\Eloquent\Builder;

if (!function_exists('getMenuActivo')) {
    function getMenuActivo($ruta)
    {
        $pos = strpos($ruta, '-');
        $ruta2='';
        if ($pos !== false) {
            $ruta2=substr($ruta, 0, $pos);
        }else{
            $ruta2=$ruta;
        }
        if (request()->is($ruta2) || request()->is($ruta2 . '*')) {
            return 'active '. $ruta2;

        } else {
            return '';

        }
    }
}
/*
if (!function_exists('canUser')) {
    function can($permiso, $redirect = true)
    {
        if (session()->get('rol_nombre') == 'Administrador Sistema') {
            return true;
        } else {
            $rolId = session()->get('rol_id');
            $permisos = cache()->tags('Permiso')->rememberForever("Permiso.rolid.$rolId", function () {
                return Permiso::whereHas('roles', function ($query) {
                    $query->where('rol_id', session()->get('rol_id'));
                })->get()->pluck('slug')->toArray();
            });
            if (!in_array($permiso, $permisos)) {
                if ($redirect) {
                    if (!request()->ajax())
                        return redirect()->route('admin-index')->with('mensaje', 'No tienes permisos para entrar en este modulo')->send();
                    abort(403, 'No tiene permiso');
                } else {
                    return false;
                }
            }
            return true;
        }
    }
}*/
