<?php

namespace App\Services;

class EncryptionService
{
    public function decryptMRemote($base64Password, $masterPassword = '')
    {
        if (empty($base64Password)) return null;

        // 1. Decodificar Base64
        $data = base64_decode($base64Password);
        
        // mRemoteNG usa: 16 bytes (IV) + Datos cifrados
        if (strlen($data) <= 16) {
            return "Error: Datos insuficientes (" . strlen($data) . " bytes)";
        }

        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        
        // 2. Generar la llave (MD5 del master password en binario)
        $key = md5($masterPassword, true); 
        
        // 3. Descifrar usando AES-128-CBC
        $decrypted = openssl_decrypt(
            $ciphertext, 
            'aes-128-cbc', 
            $key, 
            OPENSSL_RAW_DATA, 
            $iv
        );

        if ($decrypted === false) {
            // Esto nos dirá si es un problema de la librería OpenSSL
            return "Error OpenSSL: " . openssl_error_string();
        }

        // 4. Limpieza final: mRemoteNG rellena con bytes nulos (\0)
        // Usamos una expresión regular para quitar cualquier caracter no imprimible
        $clean = preg_replace('/[\x00-\x1F\x7F]/', '', $decrypted);
        
        return !empty($clean) ? $clean : "Error: Resultado vacío";
    }
}