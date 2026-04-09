<?php
namespace App\Jobs;

use App\Models\Heartbeat;
use App\Events\ServerStatusCambio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\Interfaces\HeartbeatRepositoryInterface;

class ProcessServerStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mapeo;

    public function __construct($mapeo)
    {
        $this->mapeo = $mapeo;
    }

    public function handle(HeartbeatRepositoryInterface $heartbeatrepo)
    {
        $ultimoEstado = $heartbeatrepo->obtenerUltimoHeartbeat($this->mapeo->FK_id_monitor_kuma);
        if ($ultimoEstado) {
            $this->broadcastServerUpdate($ultimoEstado);
        }
    }

    private function broadcastServerUpdate(Heartbeat $heartbeat): void
    {
        event(new ServerStatusCambio([
            'sibop_id' => $this->mapeo->FK_id_unidad,
            'status' => $heartbeat->status,
            'ping' => $heartbeat->ping,
            'time' => $heartbeat->time
        ]));
    }
}
