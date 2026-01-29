<?php
namespace App\Events;

use App\Models\Servidor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServidorActualizado implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $servidor;
    public function __construct($servidor)
    {
        $this->servidor = $servidor;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('monitoreo-global'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'servidor.cambio';
    }
}
