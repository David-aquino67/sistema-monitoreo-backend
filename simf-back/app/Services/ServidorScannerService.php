<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ServidorScannerService
{

    public function escanearServidor($url)
{
    $respuesta = Http::timeout(15)->get($url);
    $htmlOriginal = $respuesta->body();
    $htmlUtf8 = mb_convert_encoding($htmlOriginal, 'UTF-8', 'ISO-8859-1, UTF-8');

    if (empty($htmlUtf8)) {
        throw new \Exception("El cuerpo de la respuesta está vacío después de la conversión.");
    }

    return [
        'titulo' => $this->parsearHtml($htmlUtf8, 'titulo'),
        'ubicacion' => $this->parsearHtml($htmlUtf8, 'ubicacion'),
        'ip' => parse_url($url, PHP_URL_HOST),
        'estado' => $respuesta->successful() ? 'online' : 'offline',
        'tiempoActividad' => $this->parsearHtml($htmlUtf8, 'tiempo'),
        'latencia' => round($respuesta->handlerStats()['total_time'] * 1000) . ' ms',
        'ultimoPing' => now()->toDateTimeString(),
        'html_raw' => mb_scrub($htmlUtf8) 
    ];
}
   
    private function parsearHtml($html, $campo)
    {
        if (preg_match("/$campo\s*:\s*([^<|\n]+)/i", $html, $coincidencias)) {
            return trim($coincidencias[1]);
        }
        return "No detectado";
    }
}