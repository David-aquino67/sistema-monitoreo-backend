<?php

namespace App\Services;

use App\Models\MonitorServidor;
use App\Models\Heartbeat;
use App\Services\Sibop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class StatusService
{
    private $refresh_cahe = 60*60*24*62;

    public function getStatusFull()
    {
        $mapeos = MonitorServidor::all();
        $unidadesSibop = $this->obtenerCatalogoUnidades($mapeos);

        return $mapeos->map(function ($item) use ($unidadesSibop) {
            $unidadData = $this->buscarUnidadEnCatalogo($unidadesSibop, $item->FK_id_unidad);
            $ultimoHb = $this->obtenerUltimoHeartbeat($item->FK_id_monitor_kuma);

            return $this->formatearRespuesta($item, $unidadData, $ultimoHb);
        });
    }
    private function obtenerCatalogoUnidades(Collection $mapeos):array
    {
        $ids = $mapeos->pluck('FK_id_unidad')->toArray();
        return Cache::remember('catalogo_unidades_sibop', $this->refresh_cache, function () use ($ids) {
            return Sibop::unidades(env('SIBOP_API_TOKEN'), $ids);
        });
    }
    private function buscarUnidadEnCatalogo(array $catalogo, int $unidadId): ?array
    {
        return collect($catalogo)->firstWhere('REGISTRO_id', $unidadId);
    }
    private function obtenerUltimoHeartbeat(int $monitorId):?Heartbeat
    {
        return Heartbeat::where('monitor_id', $monitorId)
            ->orderBy('time', 'desc')
            ->first();
    }
    private function formatearRespuesta(MonitorServidor $item, ?array $unidadData, ?Heartbeat $ultimoHb ):array
    {
        return [
            'id'        => $item->REGISTRO_id,
            'unidad_id' => $item->FK_id_unidad,
            'nombre'    => $unidadData['descripcion'] ?? 'Unidad Desconocida',
            'online'    => $ultimoHb ? (bool)$ultimoHb->status : false,
            'latencia'  => $ultimoHb ? $ultimoHb->ping : 0,
            'fecha'     => $ultimoHb ? $ultimoHb->time : null,
        ];
    }
}
