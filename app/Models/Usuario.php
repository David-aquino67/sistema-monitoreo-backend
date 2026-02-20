<?php

namespace App\Models;

use App\Services\Sibop;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "usuarios";
    protected $primaryKey = "id_sibop";
    public $incrementing = false;

    public $casts = [
        'id_sibop' => 'integer',
		'id_sibop_jefe' => 'integer',
    ];

    const CREATED_AT = 'REGISTRO_fecha_creacion';
    const UPDATED_AT = 'REGISTRO_fecha_ultimo_cambio';

    public function datosCompletos()
    {
        try {
            $datos = Cache::remember("datos_usuario_{$this->id_sibop}_sibop", 60 * 60 * 24 * 30, function () {
                return Sibop::datosCompletosUsuario(env('SIBOP_API_TOKEN'), $this->id_sibop);
            });
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $datos;
    }

    public function permiso(): BelongsTo
    {
        return $this->belongsTo(Permiso::class, 'FK_id_permiso', 'ability');
    }
}
