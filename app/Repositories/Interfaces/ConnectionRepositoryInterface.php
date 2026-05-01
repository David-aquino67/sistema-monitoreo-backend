<?php

namespace App\Repositories\Interfaces;

interface ConnectionRepositoryInterface
{
    public function encontrarConnectionData(int $unidadId): ?object;
    public function ejecutarPsExec(int $unidadId, string $rutaScript):?object;
}
