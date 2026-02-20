<?php

namespace App\Services;

use App\Models\Version;
use Illuminate\Support\Facades\Cache;

class GlobalService
{
	public function dropCache()
	{
		Cache::flush();
	}

	public function listarVersiones()
	{
		$versiones = Version::with('historial')->orderBy('fecha_liberacion', 'desc')->get();
		return $versiones;
	}

		public function obtenerUltimaVersion()
	{
		$ultimaVersion = Version::orderBy('fecha_liberacion', 'desc')->first();
		return $ultimaVersion;
	}

	public function obtenerVersion($version)
	{
		$version = Version::with('historial')->where('numero_version', $version)->first();
		return $version;
	}

}