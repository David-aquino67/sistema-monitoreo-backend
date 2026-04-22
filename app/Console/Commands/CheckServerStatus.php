<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StatusService;
use App\Services\Gateway;

class CheckServerStatus extends Command
{
    protected $signature = 'check:server-status';
    protected $description = 'Revisa el estado de los servidores y emite eventos vía Gateway.';

    public function handle(StatusService $statusService, Gateway $gateway)
    {
        $disponibilidad = $statusService->getStatusFull();
        $gateway->dispatchStatusUpdate($disponibilidad);

        $this->info("Estados actualizados y enviados.");
    }
}
