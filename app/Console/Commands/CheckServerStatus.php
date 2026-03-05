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
    $mapeos = \App\Models\MonitorMapeo::all();

    foreach ($mapeos as $mapeo) {
       \App\Jobs\ProcessServerStatus::dispatch($mapeo);
    }

    $this->info('Se han encolado ' . $mapeos->count() . ' servidores para revisión.');
    }
}
