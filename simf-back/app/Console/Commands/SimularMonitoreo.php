<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Servidor;
use App\Services\ServidorService;

class SimularMonitoreo extends Command
{
    // Nombre del comando para ejecutarlo
    protected $signature = 'monitoreo:simular';
    protected $description = 'Simula cambios de estado en los servidores en tiempo real';

    public function handle(ServidorService $service)
    {
        $this->info('Iniciando simulador de monitoreo...');

        while (true) {
            // 1. Elegir un servidor al azar
            $servidor = Servidor::inRandomOrder()->first();

            if ($servidor) {
                // 2. Decidir un nuevo estado aleatorio
                $estados = ['online', 'offline', 'warning'];
                $nuevoEstado = $estados[array_rand($estados)];

                // 3. Usar nuestro Servicio modular para actualizar y disparar WebSocket
                $service->cambiarEstado($servidor->id, $nuevoEstado);

                $this->info("Servidor [{$servidor->titulo}] cambiado a {$nuevoEstado}");
            }

            // Esperar 5 segundos antes del siguiente cambio
            sleep(5);
        }
    }
}
