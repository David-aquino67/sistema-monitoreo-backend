<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GlobalService;

class Dev extends Command
{
    protected $signature = 'dev';
    protected $description = 'Levanta servidor de desarrollo, cola de trabajo y websockets';
    public function handle(GlobalService $globalService)
    {
		$host = env('DEV_HOST', '127.0.0.1');
		$port = env('DEV_PORT', '8000');
		$reverbHost = env('REVERB_SERVER_HOST', env('REVERB_HOST', '0.0.0.0'));
		$reverbPort = env('REVERB_SERVER_PORT', env('REVERB_PORT', '8080'));
		$reverbHostname = env('REVERB_HOST', $reverbHost);

		// Eliminamos la cache
		$this->info("Limpiando cache...");
		$globalService->dropCache();

		// Lanzamos los procesos asíncronos en ventanas nuevas
		$this->info("Iniciando Worker de colas...");
		pclose(popen("start php artisan queue:listen > NUL", "r"));

		$this->info("Iniciando WebSockets (Reverb) en {$reverbHost}:{$reverbPort}...");
		pclose(popen("start php artisan reverb:start --host={$reverbHost} --port={$reverbPort} --hostname={$reverbHostname} > NUL", "r"));

		// Lanzamos el servidor de desarrollo
		$this->info("Iniciando servidor en http://{$host}:{$port}");
		$this->call('serve', [
			'--host' => $host, 
			'--port' => $port
		]);
    }
}