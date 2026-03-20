<?php

namespace App\Services;

class EncryptionService
{
    public function decryptMRemote($base64Password, $masterPassword = '')
    {
        if (empty($base64Password)) return null;
        $data = base64_decode($base64Password);
        if (strlen($data) <= 16) return false;
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        $key = md5($masterPassword, true); 
        $decrypted = openssl_decrypt($ciphertext, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted ? trim($decrypted) : "Error al descifrar";
    }
}