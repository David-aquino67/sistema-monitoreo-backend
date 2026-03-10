<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonitorServidor; // Asegúrate de que este es el nombre de tu modelo de mapeo

class ServidorController extends Controller
{
    public function index()
    {
        // Traemos todos los servidores mapeados desde SQL Server
        // Seleccionamos los campos que React necesita para pintar las tarjetas
        $servidores = MonitorServidor::all()->map(function($item) {
            return [
                'id' => $item->REGISTRO_id, // El ID interno del SIBOP
                'unidad_id' => $item->FK_id_unidad,
                'nombre' => "Unidad " . $item->FK_id_unidad,
                'online' => false, // Estado inicial por defecto
                'latencia' => 0    // Latencia inicial
            ];
        });

        return response()->json($servidores);
    }
}