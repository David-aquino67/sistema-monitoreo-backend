<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitorServidor extends Model
{
    protected $table = "monitores_servidores";
    protected $primaryKey = "REGISTRO_id";
 
	const CREATED_AT = 'REGISTRO_fecha_creacion';
	const UPDATED_AT = 'REGISTRO_fecha_ultimo_cambio';
}
