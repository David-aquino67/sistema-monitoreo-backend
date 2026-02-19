<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Servidor;
use App\Services\ServidorService;
use Illuminate\Http\Request;

class ServidorController extends Controller
{
    protected $servidorService;
    public function __construct(ServidorService $servidorService)
    {
        $this->servidorService = $servidorService;
    }
    public function index()
    {
        return response()->json(Servidor::all());
    }
    public function levantar($id)
    {
        $servidor = $this->servidorService->cambiarEstado($id, 'online');

        return response()->json([
            'message' => 'Servidor iniciado correctamente',
            'data' => $servidor
        ]);
    }
}
