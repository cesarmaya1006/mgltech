<?php

namespace App\Models\Empresa;

use App\Models\Config\TipoDocumento;
use App\Models\Proyectos\Proyecto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Empresa extends Model
{
    use HasFactory, Notifiable;
    protected $remember_token = false;
    protected $table = 'empresas';
    protected $guarded = [];
    //==================================================================================
    public function tipos_docu()
    {
        return $this->belongsTo(TipoDocumento::class, 'docutipos_id', 'id');
    }
    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    public function grupo()
    {
        return $this->belongsTo(EmpGrupo::class, 'emp_grupo_id', 'id');
    }
    //----------------------------------------------------------------------------------
    //==================================================================================
    //----------------------------------------------------------------------------------
    public function areas()
    {
        return $this->hasMany(Area::class, 'empresa_id', 'id');
    }
    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'empresa_id', 'id');
    }
    //----------------------------------------------------------------------------------
    //==================================================================================
    public function opcionesarchivo ()
    {
        return $this->belongsToMany(OpcionArchivo::class,'empresas_opcionarchivo','empresa_id','opcionarchivo_id');
    }
    //----------------------------------------------------------------------------------
    //==================================================================================
}
