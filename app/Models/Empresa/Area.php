<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Area extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'areas';
    protected $guarded = [];

    //==================================================================================
    //----------------------------------------------------------------------------------
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }
    //----------------------------------------------------------------------------------
    public function cargos()
    {
        return $this->hasMany(Cargo::class, 'area_id', 'id');
    }
    //----------------------------------------------------------------------------------
    // ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****
    //----------------------------------------------------------------------------------
    public function area_sup()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
    //----------------------------------------------------------------------------------
    public function areas()
    {
        return $this->hasMany(Area::class, 'area_id', 'id');
    }
    //----------------------------------------------------------------------------------
    // ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****
    //==================================================================================
}
