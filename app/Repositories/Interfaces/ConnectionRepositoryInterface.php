<?php

namespace App\Repositories\Interfaces;

interface ConnectionRepositoryInterface
{
    public function encontrarConnectionData(int $unidadId): ?object;
}
