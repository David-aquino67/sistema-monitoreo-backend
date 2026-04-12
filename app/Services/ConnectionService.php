<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use App\Interfaces\DecryptorInterface;

class ConnectionService
{
    protected $encryption;
    protected $connectionRepo;

    public function __construct(DecryptorInterface $encryption, ConnectionRepositoryInterface $connectionRepo)
    {
        $this->encryption = $encryption;
        $this->connectionRepo = $connectionRepo;
    }

    public function getCredentialsByUnidad(int $unidadId): ?array
    {
       $conexionRaw = $this->connectionRepo->encontrarConnectionData($unidadId);

        if (!$conexionRaw) {
            return null;
        }

        return $this->formatoDecryptCredentials($conexionRaw);
    }
    private function formatoDecryptCredentials($conexion): array
    {
        return [
            'host' => $conexion->Hostname,
            'user' => $conexion->Username,
            'port' => $conexion->Port,
            'pass' => $this->encryption->decrypt($conexion->Password),
        ];
    }
}
