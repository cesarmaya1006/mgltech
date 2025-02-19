<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EducacionEmpleado extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'educacion_empleados';
    protected $guarded = [];

    //==================================================================================
    //----------------------------------------------------------------------------------
    public function tipo_educacion()
    {
        return $this->belongsTo(TipoEducacion::class, 'tipo_id', 'id');
    }
    //----------------------------------------------------------------------------------
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
    //----------------------------------------------------------------------------------
}
