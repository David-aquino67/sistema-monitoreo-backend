<?php

namespace App\Repositories;

use App\Models\Heartbeat;
use App\Repositories\Interfaces\HeartbeatRepositoryInterface;

class HeartbeatRepository implements Interfaces\HeartbeatRepositoryInterface
{

    public function obtenerUltimoHeartbeat(int $monitor_Id): ?Heartbeat
    {
        return Heartbeat::where('monitor_Id', $monitor_Id)->orderBy('time', 'desc')->first();
    }
}
