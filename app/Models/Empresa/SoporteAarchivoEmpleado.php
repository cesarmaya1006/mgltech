<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SoporteAarchivoEmpleado extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'soportes_archivo';
    protected $guarded = [];

    //==================================================================================
    //----------------------------------------------------------------------------------
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
    //----------------------------------------------------------------------------------
}
