<?php
namespace App\Services;

use App\Events\ServerStatusCambio;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
class Gateway
{
    public function dispatchStatusUpdate(Collection $data)
    {
        $data->chunk(50)->each(function ($chunk, $index) {
            event(new ServerStatusCambio($chunk->values()->all()));
            Log::info("Gateway: Paquete #" . ($index + 1) . " procesado.");
        });
    }
}