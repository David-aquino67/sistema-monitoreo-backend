<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ConnectionService;
use App\Services\EncryptionService;

class ConnectionTest extends TestCase
{
    public function test_debe_descifrar_password_de_mremoteng_correctamente()
    {
        $encryption = new EncryptionService();
        $connection = new ConnectionService($encryption);
        $resultado = $connection->getCredentialsByUnidad(999);
        $this->assertNotNull($resultado, "No se encontró la conexión de prueba.");
        $this->assertEquals('admin_test', $resultado['user']);
        $this->assertEquals('127.0.0.1', $resultado['host']);
        
        $this->assertEquals('password123', $resultado['pass'], "El descifrado falló: la contraseña no coincide.");
    }
}