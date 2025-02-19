<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Departamento extends Model
{
    use HasFactory, Notifiable;
    protected $table = "departamentos";
    protected $guarded = ['id'];
    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'departamento_id', 'id');
    }
}
