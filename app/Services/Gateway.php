<?php

namespace App\Services;

use App\Events\ServerStatusCambio;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Gateway
{
    private const CHUNK_SIZE = 30;

    public function dispatchStatusUpdate(Collection $data): void
    {
        if ($data->isEmpty()) {
            return;
        }
        $data->chunk(self::CHUNK_SIZE)->each(function ($chunk, $index) {
            $this->processPackage($chunk, $index + 1);
            unset($chunk);
        });
    }
    private function processPackage(Collection $chunk, int $packageNumber): void
    {
        try {
            $payload = $chunk->values()->all();
            event(new ServerStatusCambio($payload));
            Log::info("Gateway: Paquete #{$packageNumber} procesado con " . count($payload) . " servidores.");
        } catch (\Exception $e) {
            Log::error("Gateway Error en Paquete #{$packageNumber}: " . $e->getMessage());
        }
    }
}
