<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ConnectionService;
use App\Services\EncryptionService;

class ConnectionTest extends TestCase
{
    public function test_debe_descifrar_password_real_de_mremoteng()
    {
        $encryption = new EncryptionService();
        //$connection = new ConnectionService($encryption);
        $connection = app(ConnectionService::class);

        $resultado = $connection->getCredentialsByUnidad(1);

        $this->assertNotNull($resultado, "Error: No se encontró la unidad 1 en la DB de pruebas.");

        dump("------------------------------------");
        dump("IP del Servidor: " . $resultado['host']);
        dump("Usuario: " . $resultado['user']);
        dump("PASSWORD DESCIFRADA: " . $resultado['pass']);
        dump("------------------------------------");

        $this->assertStringNotContainsString("Error", $resultado['pass']);
    }
}
