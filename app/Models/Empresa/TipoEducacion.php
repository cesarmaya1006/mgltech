<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TipoEducacion extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'tipo_educacion';
    protected $guarded = [];
    //----------------------------------------------------------------------------------
    public function educacion_empleados()
    {
        return $this->hasMany(EducacionEmpleado::class, 'tipo_id', 'id');
    }
    //----------------------------------------------------------------------------------
}
