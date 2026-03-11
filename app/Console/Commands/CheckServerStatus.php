<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Gateway; 
use App\Models\MonitorServidor;
use App\Models\Heartbeat;

class CheckServerStatus extends Command
{
    protected $signature = 'check:server-status';
    protected $description = 'Revisa el estado de los servidores y emite eventos vía Gateway.';

    public function handle(Gateway $gateway)
    {
        $mapeos = MonitorServidor::all();
        $disponibilidad = [];

        foreach ($mapeos as $mapeo) {
            $ultimoHeartbeat = Heartbeat::where('monitor_id', $mapeo->FK_id_monitor_kuma)
                ->orderBy('time', 'desc')
                ->first();

            if ($ultimoHeartbeat) {
                $disponibilidad[] = [
                    'unidad_id' => $mapeo->FK_id_unidad,
                    'online'    => (bool) $ultimoHeartbeat->status,
                    'latencia'  => $ultimoHeartbeat->ping,
                    'fecha'     => $ultimoHeartbeat->time,
                ];
            }
        }

        if (count($disponibilidad) > 0) {
            $gateway->dispatchStatusUpdate(collect($disponibilidad));

            $this->info("Proceso completado: " . count($disponibilidad) . " estados enviados al Gateway.");
        }
    }
}