<?php

namespace App\Repositories;

use App\Models\MonitorServidor;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\MonitorRepositoryInterface;
use Illuminate\Support\Facades\Log;

class MonitorRepository implements MonitorRepositoryInterface
{

    public function getAllMapeos(): Collection
    {
		$relacion_monitores_servidores = MonitorServidor::select('REGISTRO_id', 'FK_id_unidad', 'FK_id_monitor_kuma', 'tipo_monitor')->get()->groupBy('FK_id_unidad');
        $map = $relacion_monitores_servidores->map(function ($items) {
			if(count($items) != 2){
				Log::error("La unidad con ID {$items->first()->FK_id_unidad} no tiene ambos monitores (red_router y http) correctamente configurados.");
				die();
			};
			if(!$items->contains('tipo_monitor', 'red_router') || !$items->contains('tipo_monitor', 'http')){
				Log::error("La unidad con ID {$items->first()->FK_id_unidad} no tiene ambos monitores (red_router y http) correctamente configurados.");
				die();
			};
			$unidad = new \stdClass();
			$unidad->FK_id_unidad = (int) $items->first()->FK_id_unidad;
			$unidad->FK_id_monitor_kuma_red = (int) $items->where('tipo_monitor', 'red_router')->first()->FK_id_monitor_kuma;
			$unidad->FK_id_monitor_kuma_http = (int) $items->where('tipo_monitor', 'http')->first()->FK_id_monitor_kuma;
			$unidad->REGISTRO_id = (int) $items->first()->REGISTRO_id;
			return $unidad;
		})->values(); 
		return $map;
    }
}
