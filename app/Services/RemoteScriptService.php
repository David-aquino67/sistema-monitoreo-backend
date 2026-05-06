<?php

namespace App\Services;

class RemoteScriptService
{
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
    public function processServerAction(int $unidadId, string $accionNombre, int $usuarioId)
    {
        $accion = \DB::table('cat_acciones')
            ->where('nombre', 'LIKE', $accionNombre)
            ->first();

        if (!$accion) throw new \Exception("Acción no encontrada", 404);

        $resultado = $this->ejecutarPsExec($unidadId, $accion->ruta_script);

        \DB::table('historico_acciones')->insert([
            'unidad_id'        => $unidadId,
            'accion_id'        => $accion->id,
            'usuario_sibop_id' => $usuarioId,
            'resultado_salida' => $resultado,
            'created_at'       => now()
        ]);

        return $resultado;
    }
}
