<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckServerStatus extends Command
{
    protected $signature = 'servers:check';
    protected $description = 'Revisa el estado de los servidores y emite eventos de actualización.';

    public function handle()
    {
        $mapeos = \App\Models\MonitorMapeo::all();
        foreach ($mapeos as $mapeo) {
            $ultimoEstado = \App\Models\Heartbeat::where('monitor_id', $mapeo->FK_id_monitor_kuma)
                ->orderBy('time', 'desc')
                ->first();
            if ($ultimoEstado) {
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
