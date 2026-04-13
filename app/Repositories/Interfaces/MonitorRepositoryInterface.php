<?php

namespace App\Repositories\Interfaces;
use Illuminate\Support\Collection; 
interface MonitorRepositoryInterface
{
public function getAllMapeos():Collection;
}
