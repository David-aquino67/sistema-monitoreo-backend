<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckServerStatus extends Command
{
    protected $signature = 'check:server-status';
    protected $description = 'Revisa el estado de los servidores y emite eventos de actualización.';

    public function handle()
    {
    $mapeos = \App\Models\MonitorServidor::all();
    $disponibilidad = [];

    foreach ($mapeos as $mapeo) {
        $ultimoHeartbeat = \App\Models\Heartbeat::where('monitor_id', $mapeo->FK_id_monitor_kuma)
            ->orderBy('time', 'desc')
            ->first();

        if ($ultimoHeartbeat) {
            $disponibilidad[] = [
                'unidad_id' => $mapeo->FK_id_unidad,
                'online'    => (bool) $ultimoHeartbeat->status, // 1 = true, 0 = false
                'latencia'  => $ultimoHeartbeat->ping,
                'fecha'     => $ultimoHeartbeat->time,
                'msg'       => $ultimoHeartbeat->msg
            ];
        }
    }

    if (count($disponibilidad) > 0) {
        event(new \App\Events\ServerStatusCambio($disponibilidad));
        \Log::info("Monitoreo masivo enviado con " . count($disponibilidad) . " registros.");
    }
    }
}
