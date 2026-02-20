<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = "archivos";
    protected $primaryKey = "REGISTRO_id";
 
	const CREATED_AT = 'REGISTRO_fecha_creacion';
	const UPDATED_AT = 'REGISTRO_fecha_ultimo_cambio';
}
