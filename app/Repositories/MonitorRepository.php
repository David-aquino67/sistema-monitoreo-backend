<?php

namespace App\Repositories;

use App\Models\MonitorServidor;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\MonitorRepositoryInterface;

class MonitorRepository implements MonitorRepositoryInterface
{

    public function getAllMapeos(): Collection
    {
        return MonitorServidor::all();
    }
}
