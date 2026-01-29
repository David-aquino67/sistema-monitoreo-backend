<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    protected $table = 'servidores';
    protected $fillable = [
        'titulo',
        'ubicacion',
        'ip',
        'estado',
        'tiempoActividad',
        'latencia',
        'ultimoPing',
        'permisos'
    ];
    protected $casts = [
        'permisos' => 'array',
        'ultimoPing' => 'datetime',
    ];
}
