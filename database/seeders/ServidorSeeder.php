<?php
namespace Database\Seeders;

use App\Models\Servidor;
use Illuminate\Database\Seeder;

class ServidorSeeder extends Seeder
{
    public function run(): void
    {
        $servidores = [
            [
                'titulo' => 'UMF 10 - Santa Anita',
                'ubicacion' => 'Delegación CDMX Norte',
                'ip' => '10.15.2.14',
                'estado' => 'offline',
                'tiempoActividad' => '0d 0h',
                'latencia' => 0,
                'permisos' => json_encode(['reiniciar' => true, 'restablecer' => true, 'limpiar' => true]),
            ],
            [
                'titulo' => 'Servidor Central SIMF',
                'ubicacion' => 'Data Center Principal',
                'ip' => '172.16.0.1',
                'estado' => 'online',
                'tiempoActividad' => '150d 5h',
                'latencia' => 12,
                'permisos' => json_encode(['reiniciar' => true, 'restablecer' => false, 'limpiar' => false]),
            ],
            [
                'titulo' => 'HGZ 1 - Puebla',
                'ubicacion' => 'Delegación Puebla',
                'ip' => '10.22.1.5',
                'estado' => 'warning',
                'tiempoActividad' => '45d 10h',
                'latencia' => 85,
                'permisos' => json_encode(['reiniciar' => true, 'restablecer' => true, 'limpiar' => false]),
            ]
        ];

        foreach ($servidores as $s) {
            Servidor::create([
                'titulo' => $s['titulo'],
                'ubicacion' => $s['ubicacion'],
                'ip' => $s['ip'],
                'estado' => $s['estado'],
                'tiempoActividad' => $s['tiempoActividad'],
                'latencia' => $s['latencia'],
                'permisos' => json_decode($s['permisos'], true),
            ]);
        }
    }
}
