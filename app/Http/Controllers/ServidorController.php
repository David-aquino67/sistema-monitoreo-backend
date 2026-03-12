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
        // Traemos todos los servidores mapeados desde SQL Server
        // Seleccionamos los campos que React necesita para pintar las tarjetas

        $servidores = MonitorServidor::all()->map(function($item) {
            return [
                'id' => $item->REGISTRO_id, // El ID interno del SIBOP
                'unidad_id' => $item->FK_id_unidad,
                'online' => false, // Estado inicial por defecto
                'latencia' => 0    // Latencia inicial
            ];
        });

        $ids = $servidores->pluck('unidad_id')->toArray();
        $unidades = Sibop::unidades(env('SIBOP_API_TOKEN'), $ids);

        $servidores = $servidores->map(function($servidor) use ($unidades) {
            $unidad_sibop = array_filter($unidades, function($unidad) use ($servidor) {
                return ((int) $unidad['REGISTRO_id']) === ((int) $servidor['unidad_id']);
            });
            $servidor['nombre'] = $unidad_sibop ? reset($unidad_sibop)['descripcion'] : 'Desconocido';
            return $servidor; 
        });

        return response()->json($servidores);
    }
}