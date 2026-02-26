<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckServerStatus extends Command
{
    protected $signature = 'servers:check';
    protected $description = 'Revisa el estado de los servidores y emite eventos de actualización.';

    public function handle()
    {
        // 1. Obtenemos los mapeos de la tabla oficial monitores_servidores
        $mapeos = \App\Models\MonitorMapeo::all();

        foreach ($mapeos as $mapeo) {
            // 2. Usamos FK_id_monitor_kuma para consultar en MariaDB
            $ultimoEstado = \App\Models\Heartbeat::where('monitor_id', $mapeo->FK_id_monitor_kuma)
                ->orderBy('time', 'desc')
                ->first();

            if ($ultimoEstado) {
                // 3. Emitimos el evento con el ID de unidad correcto (FK_id_unidad)
                event(new \App\Events\ServerStatusUpdated([
                    'sibop_id' => $mapeo->FK_id_unidad,
                    'status'   => $ultimoEstado->status,
                    'ping'     => $ultimoEstado->ping,
                    'time'     => $ultimoEstado->time
                ]));
            }
        }
    }
}
