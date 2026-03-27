<?php

namespace App\Services;

class EncryptionService
{
    /**
     * Descifra contraseñas de mRemoteNG (AES-128-CBC)
     */
    public function decryptMRemote($base64Password, $masterPassword = 'mremoteng')
    {
        if (empty($base64Password)) return null;

        // 1. Limpieza y Decodificación Base64 (PASO CRUCIAL)
        $data = base64_decode(trim($base64Password)); 
        
        // mRemoteNG usa un IV de 16 bytes. El total debe ser mayor a 16.
        if (strlen($data) <= 16) {
            return "Error: Formato de hash inválido";
        }

        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        
        // 2. Generación de Llave (MD5 del password maestro)
        $key = md5($masterPassword, true); 

        // 3. Descifrado con Zero Padding para manejo manual
        $decrypted = openssl_decrypt(
            $ciphertext, 
            'aes-128-cbc', 
            $key, 
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, 
            $iv
        );

        if ($decrypted === false) {
            return "Error OpenSSL: " . openssl_error_string();
        }

        // 4. Limpieza de Relleno (Padding PKCS7 / Null bytes)
        // Quitamos caracteres no imprimibles y bytes nulos
        $decrypted = preg_replace('/[\x00-\x1F\x7F]/', '', $decrypted);
        
        // 5. Retorno limpio
        return !empty($decrypted) ? $decrypted : "Error: No se pudo descifrar";
    }
}