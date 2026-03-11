<?php
namespace App\Services;

use App\Events\ServerStatusCambio;
use Illuminate\Support\Collection;

class Gateway
{
    public function dispatchStatusUpdate(Collection $data)
    {
        $data->chunk(50)->each(function ($chunk) {
            event(new ServerStatusCambio($chunk->values()->all()));
        });
    }
}