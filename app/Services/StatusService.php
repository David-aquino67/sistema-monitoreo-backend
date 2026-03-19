<?php

namespace App\Services;

use App\Models\MonitorServidor;
use App\Models\Heartbeat;
use App\Services\Sibop;
use Illuminate\Support\Facades\Cache;

class StatusService
{
    private $refresh_cahe = 60*60*24*62;

    public function getStatusFull()
    {
        $mapeos = MonitorServidor::all();
        $ids = $mapeos->pluck('FK_id_unidad')->toArray();
        $unidadesSibop = Cache::remember('catalogo_unidades_sibop', $this->refresh_cahe, function () use ($ids) {
            return Sibop::unidades(env('SIBOP_API_TOKEN'), $ids);
        });
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
    }
}