<?php
namespace App\Helpers;

class MayoFuncionesHelper
{
    public static function getMenuActivo($ruta)
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
