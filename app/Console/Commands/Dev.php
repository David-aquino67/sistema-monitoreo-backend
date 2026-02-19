<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Dev extends Command
{
    protected $signature = 'dev';
    protected $description = 'Levanta servidor de desarrollo y la cola de trabajo';
    public function handle()
    {
		$host = env('DEV_HOST', '127.0.0.1');
		$port = env('DEV_PORT', '8000');

		// Eliminamos la cache
		$this->info("Limpiando cache...");
		Cache::flush();

		// Lanzamos los procesos asíncronos en ventanas nuevas
		$this->info("Iniciando Worker de colas...");
		pclose(popen("start php artisan queue:listen > NUL", "r"));

		// Lanzamos el servidor de desarrollo
		$this->info("Iniciando servidor en http://{$host}:{$port}");
		$this->call('serve', [
			'--host' => $host, 
			'--port' => $port
		]);
    }
}