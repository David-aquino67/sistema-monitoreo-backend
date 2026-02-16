<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Servidor;
class InspeccionController extends Controller
{
    public function index()
    {
        $servidores = Servidor::all();
        return response()->json($servidores);
    }
    public function procesar(Request $request)
    {
        Log::info(json_encode($request->all()));
        return response()->json([
          'request_data' => json_encode($request->all())
        ]);

    }
    public function investigar()
    {
        $url = 'http://11.108.34.122:9080/acceso.jsp';

        try {
            $respuesta = Http::timeout(10)->get($url);
            $html = $respuesta->body();

            if (empty($html)) {
                return response()->json(['error' => 'Servidor respondió vacío'], 404);
            }

            $datosExtraidos = [
                'titulo' => $this->extraerDato($html, 'titulo'),
                'ubicacion' => $this->extraerDato($html, 'ubicacion'),
                'ip' => '11.108.34.122',
                'estado' => $respuesta->successful() ? 'online' : 'offline',
                'tiempoActividad' => $this->extraerDato($html, 'tiempo'),
                'latencia' => $respuesta->handlerStats()['total_time'] * 1000 . ' ms',
                'ultimoPing' => now()->toDateTimeString(),
            ];

            return response()->json([
                'mensaje' => "Datos procesados del servidor institucional",
                'datos_limpios' => $datosExtraidos,
                'cuerpo_crudo_debug' => substr($html, 0, 1000)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => "No se pudo conectar al servidor institucional",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function extraerDato($html, $campo) {
        if (preg_match("/$campo\s*:\s*([^<|\n]+)/i", $html, $coincidencias)) {
            return trim($coincidencias[1]);
        }
        return "No detectado en HTML";
    }
}
