<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permiso extends Model
{
    protected $table = "permisos";
    protected $primaryKey = "ability";
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'FK_id_permiso', 'ability');
    }
}
