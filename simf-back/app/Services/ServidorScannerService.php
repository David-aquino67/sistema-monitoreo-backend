<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ServidorScannerService
{

    public function escanearServidor($requestData)
    {

    Log::info("Iniciando escaneo del servidor: js" . json_encode($requestData));
}
   
    private function parsearHtml($html, $campo)
    {
        if (preg_match("/$campo\s*:\s*([^<|\n]+)/i", $html, $coincidencias)) {
            return trim($coincidencias[1]);
        }
        return "No detectado";
    }
}