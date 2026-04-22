<?php

namespace App\Services;

use App\Models\Heartbeat;
use App\Services\Sibop;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\MonitorRepositoryInterface; 
use App\Repositories\Interfaces\HeartbeatRepositoryInterface;
use Illuminate\Support\Collection;

class StatusService
{
    private $refresh_cache = 60*60*24*62;
    protected $monitorRepo;
    protected $heartbeatRepo;

    public function __construct(MonitorRepositoryInterface $monitorRepo, HeartbeatRepositoryInterface $heartbeatRepo) {
        $this->monitorRepo = $monitorRepo;
        $this->heartbeatRepo = $heartbeatRepo;
    }

    public function getStatusFull()
    {
        $mapeos = $this->monitorRepo->getAllMapeos();
        $unidadesSibop = $this->obtenerCatalogoUnidades($mapeos);

        return $mapeos->map(function ($item) use ($unidadesSibop) {
            $unidadData = $this->buscarUnidadEnCatalogo($unidadesSibop, $item->FK_id_unidad);
            $ultimoHbRedRouter = $this->heartbeatRepo->obtenerUltimoDeMonitorId($item->FK_id_monitor_kuma_red);
			$ultimoHbHttp = $this->heartbeatRepo->obtenerUltimoDeMonitorId($item->FK_id_monitor_kuma_http);

            return $this->formatearRespuesta($item, $unidadData, $ultimoHbRedRouter, $ultimoHbHttp);
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
    private function formatearRespuesta(?\stdClass $item, ?array $unidadData, ?Heartbeat $ultimoHbRedRouter, ?Heartbeat $ultimoHbHttp ):array
    {
        return [
            'id'        		=> $item->REGISTRO_id,
            'unidad_id' 		=> $item->FK_id_unidad,
            'nombre'    		=> $unidadData['descripcion'] ?? 'Unidad Desconocida',
            'online'    		=> ((bool)$ultimoHbRedRouter->status?? false) && ((bool)$ultimoHbHttp->status?? false),
			'online_red_router' => (bool)$ultimoHbRedRouter->status?? false,
			'online_http' 		=> (bool)$ultimoHbHttp->status?? false,
            'latencia'  		=> $ultimoHbHttp->ping?? 0,
            'fecha'     		=> $ultimoHbHttp->time?? null,
        ];
    }
}
