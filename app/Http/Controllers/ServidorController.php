<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonitorServidor; // Asegúrate de que este es el nombre de tu modelo de mapeo
use App\Services\Sibop; // Modelo para obtener la descripción de la unidad desde el SIBOP
use Illuminate\Support\Facades\Log; // Para registrar información en los logs

class ServidorController extends Controller
{
    public function index()
    {
        /return response()->json($statusService->getStatusFull());
    }
}
