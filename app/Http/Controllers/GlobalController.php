<?php

namespace App\Http\Controllers;

use App\Services\GlobalService;
// use Docs\GlobalControllerDocInterface;

class GlobalController // extends Controller implements GlobalControllerDocInterface
{
	public function indexVersiones(GlobalService $globalService)
	{
		$versiones = $globalService->listarVersiones();
		return response()->json($versiones, 200);
	}

	public function showUltimaVersion(GlobalService $globalService)
	{
		$ultimaVersion = $globalService->obtenerUltimaVersion();
		return response()->json($ultimaVersion, 200);
	}

	public function showVersion(GlobalService $globalService, $version)
	{
		$version = $globalService->obtenerVersion($version);
		if(!$version){
			return response()->json(['message' => 'La versión solicitada no existe'], 404);
		}
		return response()->json($version, 200);
	}

	public function destroyCache(GlobalService $globalService)
    {
        $globalService->dropCache();
        return response()->json(null, 204);
    }
}
