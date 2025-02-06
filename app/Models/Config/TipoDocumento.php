<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TipoDocumento extends Model
{
    use HasFactory, Notifiable;
    protected $remember_token = false;
    protected $table = 'tipo_documentos';
    protected $guarded = [];
}
