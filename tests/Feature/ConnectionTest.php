<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ConnectionService;
use App\Services\EncryptionService;

class ConnectionTest extends TestCase
{
    /**
     * Verifica que el servicio recupera y descifra los datos de la DB real.
     */
    public function test_debe_descifrar_password_real_de_mremoteng()
    {
        // 1. Instanciamos los servicios manualmente para la prueba
        $encryption = new EncryptionService();
        $connection = new ConnectionService($encryption);

        // 2. Act: Buscamos la unidad 1 (la que insertamos en SQL)
        $resultado = $connection->getCredentialsByUnidad(2);

        // 3. Assert: Verificaciones
        $this->assertNotNull($resultado, "No se encontró el mapeo en la tabla monitor_conexion.");
        $this->assertEquals('11.1.22.201', $resultado['host'], "El Hostname no coincide.");
        
        // Aquí probamos el descifrado
        // Si todo es correcto, debería devolver la clave que mRemoteNG guardó.
        $this->assertNotEmpty($resultado['pass'], "La contraseña descifrada está vacía.");
        
        dump("Contraseña recuperada: " . $resultado['pass']);
    }
}