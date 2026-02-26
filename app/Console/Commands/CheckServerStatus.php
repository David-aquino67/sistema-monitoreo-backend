<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckServerStatus extends Command
{
    protected $signature = 'servers:check';
    protected $description = 'Revisa el estado de los servidores y emite eventos de actualización.';

    public function handle()
    {
        $mapeos = \App\Models\MonitorMapeo::where('is_active', 1)->get();

        foreach ($mapeos as $mapeo) {
            $ultimoEstado = \App\Models\Heartbeat::where('monitor_id', $mapeo->kuma_monitor_id)
                ->orderBy('time', 'desc')
                ->first();

            if ($ultimoEstado) {
                event(new \App\Events\ServerStatusUpdated([
                    'sibop_id' => $mapeo->sibop_unidad_id,
                    'nombre'   => $mapeo->nombre_unidad,
                    'status'   => (int) $ultimoEstado->status,
                    'ping'     => $ultimoEstado->ping ?? 0,
                    'time'     => $ultimoEstado->time,
                ]));
            }
        }

        $this->info('Estados verificados y eventos emitidos.');
        return Command::SUCCESS;
    }
}
