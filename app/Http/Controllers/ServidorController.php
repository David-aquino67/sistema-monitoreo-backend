<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonitorServidor; // Asegúrate de que este es el nombre de tu modelo de mapeo
use App\Services\Sibop; // Modelo para obtener la descripción de la unidad desde el SIBOP
use Illuminate\Support\Facades\Log; // Para registrar información en los logs
use App\Services\StatusService; // Servicio para obtener el estado de los servidores
class ServidorController extends Controller
{
    protected $remoteService;
    
    public function __construct(RemoteScriptService $remoteService)
    {
        $this->remoteService = $remoteService;
    }

    public function ejecutarAccion(Request $request, $unidadId, $accionNombre)
    {
        $request->validate(['usuario_sibop_id' => 'required|integer']);

        try {
            $output = $this->remoteService->processServerAction(
                $unidadId,
                $accionNombre,
                $request->usuario_sibop_id
            );

            return response()->json(['status' => 'success', 'output' => $output]);
        } catch (\Exception $e) {
            Log::error("Error en acción: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
    public function index(StatusService $statusService)
    {
        return response()->json($statusService->getStatusFull());
    }
}
