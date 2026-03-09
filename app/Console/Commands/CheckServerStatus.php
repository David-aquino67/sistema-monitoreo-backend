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
                'online'    => (bool) $ultimoHeartbeat->status,
                'latencia'  => $ultimoHeartbeat->ping,
                'fecha'     => $ultimoHeartbeat->time,
            ];
        }
    }

    if (count($disponibilidad) > 0) {
        $coleccion = collect($disponibilidad);
        $chunks = $coleccion->chunk(50);
        foreach ($chunks as $index => $chunk) {
            event(new \App\Events\ServerStatusCambio($chunk->values()->all()));
            \Log::info("Paquete de monitoreo #" . ($index + 1) . " enviado con " . $chunk->count() . " registros.");
        }
        $this->info("Proceso completado: " . count($disponibilidad) . " servidores enviados en " . $chunks->count() . " paquetes.");
    }
}
}
