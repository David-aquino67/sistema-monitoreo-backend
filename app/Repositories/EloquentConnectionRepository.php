<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentConnectionRepository implements ConnectionRepositoryInterface
{
    protected $connections;

    public function __construct(ConnectionRepositoryInterface $connections)
    {
        $this->connections = $connections;
    }
    public function encontrarConnectionData(int $unidadId): ?object
    {
        return DB::table('monitor_conexion')
            ->join('tblCons', function ($join) {
                $join->on(
                    'monitor_conexion.constant_id',
                    '=',
                    DB::raw('tblCons.ConstantID COLLATE SQL_Latin1_General_CP1_CI_AS')
                );
            })
            ->where('monitor_conexion.unidad_id', $unidadId)
            ->select('tblCons.Username', 'tblCons.Password', 'tblCons.Hostname', 'tblCons.Port')
            ->first();
    }

    public function ejecutarPsExec(int $unidadId, string $rutaScript): ?object
    {
        $auth = $this->connections->encontrarConnectionData($unidadId);

        if (!$auth) {
            throw new \Exception("No se encontraron credenciales de conexión para la unidad ID: {$unidadId}");
        }
        $comando = sprintf(
            'psexec \\\\%s -u %s -p %s -n 15 -e cmd -h /C "%s"',
            escapeshellarg($auth->Hostname),
            escapeshellarg($auth->Username),
            escapeshellarg($auth->Password),
            $rutaScript
        );
        $comandoLog = str_replace($auth->Password, '******', $comando);
        Log::info("Ejecutando comando remoto: " . $comandoLog);

        $resultado = Process::run($comando);

        if ($resultado->failed()) {
            Log::error("PsExec Fallido: " . $resultado->errorOutput());
            throw new \Exception("Error al ejecutar script remoto: " . $resultado->errorOutput());
        }

        return $resultado->output();
    }

}
