<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Servidor;
use App\Services\ServidorService;

class SimularMonitoreo extends Command
{
    protected $signature = 'monitoreo:simular';
    protected $description = 'Simula cambios de estado en los servidores en tiempo real';

    public function handle(ServidorService $service)
    {
        $this->info('Iniciando simulador de monitoreo...');

        while (true) {
            $servidor = Servidor::inRandomOrder()->first();

            if ($servidor) {
                $estados = ['online', 'offline', 'warning'];
                $nuevoEstado = $estados[array_rand($estados)];
                $service->cambiarEstado($servidor->id, $nuevoEstado);
                $this->info("Servidor [{$servidor->titulo}] cambiado a {$nuevoEstado}");
            }
            sleep(5);
        }
    }
}
