<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Version extends Model
{
    protected $table = "versiones";
    protected $primaryKey = "numero_version";
	public $incrementing = false;
	public $timestamps = true;
	protected $keyType = 'string';

	public $casts = [
		'fecha_liberacion' => 'datetime',
	];

	public function historial() : HasMany
	{
		return $this->hasMany(HistorialVersion::class, 'numero_version', 'numero_version');
	}
}
