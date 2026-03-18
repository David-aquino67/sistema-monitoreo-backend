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

    public function handle(StatusService $statusService, WebSocketGateway $gateway)
    {
        $disponibilidad = $statusService->getStatusFull();
        $gateway->dispatchStatusUpdate($disponibilidad);

        $this->info("Estados actualizados y enviados.");
    }
}
