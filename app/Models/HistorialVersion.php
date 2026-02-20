<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialVersion extends Model
{
    protected $table = "historial_versiones";
    protected $primaryKey = "REGISTRO_id";
	public $timestamps = true;

	public function version(): BelongsTo
	{
		return $this->belongsTo(Version::class, 'numero_version', 'numero_version');
	}
}
