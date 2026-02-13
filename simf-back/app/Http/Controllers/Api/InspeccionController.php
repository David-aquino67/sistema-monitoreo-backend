<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        $url = 'http://10.107.33.121:9080/acceso.jsp';
// http://10.107.33.121:9080/acceso.jsp'
        try{
            $respuesta = Http::timeout(5)->get($url);
            Log::info("Datos Recibidos de $url", [
            'headers' => $respuesta->headers()
            ,'body' => substr($respuesta->body(), 0, 500)
            ,'status' => $respuesta->status() 
            ]);
            //'status' => 'success',
                // 'message' => "Acceso exitoso a $url",
                // 'data' => [
                //     'headers' => $respuesta->headers(),
                //     'body' => substr($respuesta->body(), 0, 500),
                //     'status_code' => $respuesta->status()
                    
            return response()->json([
                'mensaje' => "Datos del servidor umf3",
                'codigo_estado' => $respuesta->status(),
                'tipo_coontenido' => $respuesta->header('Content-Type'),
                'cabeceras_completas' => $respuesta->headers(),
                'cuerpo_respuesta' => $respuesta->body(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => "Error al acceder a $url",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}