<?php

namespace App\Repositories;

use App\Models\MonitorServidor;
use App\Repositories\Interfaces\Collection;
use App\Repositories\Interfaces\MonitorRepositoryInterface;

class MonitorRepository implements Interfaces\MonitorRepositoryInterface
{

    public function getAllMapeos(): Collection
    {
        return MonitorServidor::all();
    }
}
