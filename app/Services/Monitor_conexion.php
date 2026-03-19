<?php

namespace App\Services;

class MonitorConexion
{
    function decrypt_mremote174($base64_password, $master_password = '>Z3^Kb8b<Dl0') {
    
	// El password cifrado se espera que esté en formato Base64, que incluye el IV y el ciphertext concatenados
	$data = base64_decode($base64_password);

	// Validación básica para asegurar que el formato es correcto
    if (strlen($data) <= 16) return false;

    // Los primeros 16 bytes corresponden al Vector de Inicialización (IV)
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    
    // La llave es un hash MD5 en crudo (16 bytes) del password maestro
    $key = md5($master_password, true); 
    
    // openssl_decrypt maneja el unpadding PKCS#7 de forma automática
    return openssl_decrypt($ciphertext, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }
}