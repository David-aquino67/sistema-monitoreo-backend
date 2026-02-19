<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Servidor;
use App\Services\ServidorScannerService;

class InspeccionController extends Controller
{
    private $scanner;

    public function __construct(ServidorScannerService $scanner)
    {
        $this->scanner = $scanner;
    }

    public function index()
    {
        $servidores = Servidor::all();
        return response()->json($servidores);
    }
    public function procesar(Request $request)
    {
        Log::info(json_encode($request->all()));
        $message = "Datos recibidos de Kuma: " . json_encode($request->all());
        return response()->json([
          'request_data' => json_encode($request->all()),
          'message' => $message
        ]);
    }
  
public function investigar(Request $request)
{

        $this->scanner->escanearServidor($request->all());
        return response()->json([], 204); 
   
    }

    private function extraerDato($html, $campo) {
        if (preg_match("/$campo\s*:\s*([^<|\n]+)/i", $html, $coincidencias)) {
            return trim($coincidencias[1]);
        }
        return "No detectado en HTML";
    }
}
