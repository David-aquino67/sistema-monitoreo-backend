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
    $listaEstados = [];

    foreach ($mapeos as $mapeo) {
        $ultimoEstado = \App\Models\Heartbeat::where('monitor_id', $mapeo->FK_id_monitor_kuma)
            ->orderBy('time', 'desc')
            ->first();

        if ($ultimoEstado) {
            $listaEstados[] = [
                'sibop_id' => $mapeo->FK_id_unidad,
                'status'   => $ultimoEstado->status,
                'ping'     => $ultimoEstado->ping,
                'time'     => $ultimoEstado->time
            ];
        }
    }

    if (!empty($listaEstados)) {
        event(new \App\Events\ServerStatusCambio($listaEstados));
        
        $this->info("Se envió una actualización masiva con " . count($listaEstados) . " servidores.");
        \Log::info("Monitoreo masivo enviado.");
        }
    }
}
