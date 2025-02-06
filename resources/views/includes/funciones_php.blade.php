<?php

function mes_espanol($fecha_ing)
{
$monthNumero = date('m', strtotime($fecha_ing));
switch ($monthNumero) {
case '1':
$monthNameSpanish = 'Enero';
break;
case '2':
$monthNameSpanish = 'Febrero';
break;
case '3':
$monthNameSpanish = 'Marzo';
break;
case '4':
$monthNameSpanish = 'Abril';
break;
case '5':
$monthNameSpanish = 'Mayo';
break;
case '6':
$monthNameSpanish = 'Junio';
break;
case '7':
$monthNameSpanish = 'Julio';
break;
case '8':
$monthNameSpanish = 'Agosto';
break;
case '9':
$monthNameSpanish = 'Septiembre';
break;
case '10':
$monthNameSpanish = 'Octubre';
break;
case '11':
$monthNameSpanish = 'Noviembre';
break;
default:
$monthNameSpanish = 'Diciembre';
}
echo $monthNameSpanish;
}
//---------------------------------------------
function icono_extension($extension)
{
switch ($extension) {
case 'pdf':
$icono_archivo = 'far fa-file-pdf text-danger';
break;
case 'xls':
$icono_archivo = 'far fa-file-excel text-success';
break;
case 'xlsx':
$icono_archivo = 'far fa-file-excel text-success';
break;
case 'jpg':
$icono_archivo = 'fas fa-file-image text-info';
break;
case 'jpeg':
$icono_archivo = 'fas fa-file-image text-info';
break;
case 'png':
$icono_archivo = 'fas fa-file-image text-info';
break;
case 'gif':
$icono_archivo = 'fas fa-file-image text-info';
break;
case 'doc':
$icono_archivo = 'far fa-file-word text-primary';
break;
case 'docx':
$icono_archivo = 'far fa-file-word text-primary';
break;
case 'txt':
$icono_archivo = 'far fa-file-alt text-primary';
break;
case 'mp3':
$icono_archivo = 'far fa-file-audio text-warning';
break;
case 'mp4':
$icono_archivo = 'fas fa-photo-video text-warning';
break;
case 'mkv':
$icono_archivo = 'fas fa-photo-video text-warning';
break;
case 'zip':
$icono_archivo = 'far fa-file-archive text-red';
break;
case 'rar':
$icono_archivo = 'far fa-file-archive text-red';
break;
default:
$icono_archivo = 'far fa-file text-black';
}
echo $icono_archivo;
}
function semaforoImpacto($impacto)
{
switch ($impacto) {
case 'Alto':
$semaforo = 'darkred';
break;
case 'Medio-alto':
$semaforo = 'lightsalmon';
break;
case 'Medio':
$semaforo = 'orange';
break;
case 'Medio-bajo':
$semaforo = 'yellowgreen';
break;
default:
$semaforo = 'green';
}
echo $semaforo;
}
?>
