<?php
namespace App\Services;
use App\Models\Servidor;
use App\Events\ServidorActualizado;

class ServidorService
{
    public function cambiarEstado(int $id, string $nuevoEstado)
    {
        $servidor = Servidor::findOrFail($id);
        $servidor->estado = $nuevoEstado;
        if ($nuevoEstado === 'offline') {
            $servidor->latencia = 0;
            $servidor->tiempoActividad = "0d 0h";
        } else {
            $servidor->latencia = rand(10, 100);
            $servidor->ultimoPing = now();
        }
        $servidor->save();
        event(new ServidorActualizado($servidor));

        return $servidor;
    }
}
