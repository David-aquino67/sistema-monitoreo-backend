<?php

namespace App\Services;

use App\Models\MonitorServidor;
use App\Models\Heartbeat;
use App\Services\Sibop;
use Illuminate\Support\Facades\Cache;

class StatusService
{
    public function getStatusFull()
    {
        return Cache::remember('servidores_status_full', 300, function () {
            $mapeos = MonitorServidor::all();
            $ids = $mapeos->pluck('FK_id_unidad')->toArray();
            $unidadesSibop = Sibop::unidades(env('SIBOP_API_TOKEN'), $ids); // usar para cache 
            return $mapeos->map(function ($item) use ($unidadesSibop) {
                $unidadData = collect($unidadesSibop)->firstWhere('REGISTRO_id', $item->FK_id_unidad);
                $ultimoHb = Heartbeat::where('monitor_id', $item->FK_id_monitor_kuma)
                    ->orderBy('time', 'desc')
                    ->first();

                return [
                    'id'        => $item->REGISTRO_id,
                    'unidad_id' => $item->FK_id_unidad,
                    'nombre'    => $unidadData['descripcion'] ?? 'Unidad Desconocida',
                    'online'    => $ultimoHb ? (bool)$ultimoHb->status : false,
                    'latencia'  => $ultimoHb ? $ultimoHb->ping : 0,
                    'fecha'     => $ultimoHb ? $ultimoHb->time : null,
                ];
            });
        });
    }
}
