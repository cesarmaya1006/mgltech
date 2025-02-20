<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ManualFuncion extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'manuales_funcion';
    protected $guarded = [];
    //----------------------------------------------------------------------------------
    public function cargo()
    {
        return $this->hasOne(Cargo::class, 'id');
    }
    //----------------------------------------------------------------------------------
}
