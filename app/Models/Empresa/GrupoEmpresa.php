<?php

namespace App\Models\Empresa;

use App\Models\Config\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GrupoEmpresa extends Model
{
    use HasFactory, Notifiable;
    protected $remember_token = false;
    protected $table = 'emp_grupos';
    protected $guarded = [];
    //==================================================================================
    //----------------------------------------------------------------------------------
    public function tipo_docu()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'id');
    }
    //----------------------------------------------------------------------------------
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'emp_grupo_id', 'id');
    }
    //----------------------------------------------------------------------------------
    //==================================================================================

}
