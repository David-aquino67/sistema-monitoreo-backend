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
    $connection = new ConnectionService($encryption);

    // Buscamos la unidad (asegúrate que en smars_testing sea el ID 1)
    $resultado = $connection->getCredentialsByUnidad(1);

    $this->assertNotNull($resultado, "Error: No se encontró la unidad 1 en la DB de pruebas.");

    // --- DEPURACIÓN VISUAL ---
    dump("------------------------------------");
    dump("IP del Servidor: " . $resultado['host']);
    dump("Usuario: " . $resultado['user']);
    dump("PASSWORD DESCIFRADA: " . $resultado['pass']);
    dump("------------------------------------");

    $this->assertNotEquals("Error al descifrar", $resultado['pass']);
    // En ConnectionTest.php línea 29, cambia por:
$this->assertStringNotContainsString("Error", $resultado['pass']);
}
}