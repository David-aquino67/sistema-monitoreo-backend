<?php

namespace App\Repositories\Interfaces;
use App\Models\Heartbeat;

interface HeartbeatRepositoryInterface
{
    public function obtenerUltimoHeartbeat(int $monitor_Id): ?Heartbeat;
}
