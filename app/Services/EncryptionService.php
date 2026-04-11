<?php
namespace App\Services;

class EncryptionService
{
    private const algoritmo = 'aes-128-cbc';
    private const longitud  = 16;

    public function decryptMRemote(string $base64Password, ?string $masterPassword = null): ?string
    {
        if (empty($base64Password)) {
            return null;
        }
        //$masterPassword = $masterPassword ?? config('services.mremote.master_password') ?? env('MASTER_PASSWORD');
        $masterPassword = env('MASTER_PASSWORD');
        if (!$masterPassword) {
            return "Error: Master Password no configurada";
        }

        $data = base64_decode(trim($base64Password));

        if (strlen($data) <= 16) {
            return "Error: Formato inválido";
        }

        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        $key = md5($masterPassword, true);

        $decrypted = openssl_decrypt(
            $ciphertext,
            'aes-128-cbc',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return ($decrypted === false) ? "Error OpenSSL" : trim($decrypted);
    }
    private function procesoDesifrado(string $base64Password, ?string $masterPassword = null): ?string
    {
        $binaruData = base64_encode(trim($base64Password));
        if (strlen($binaruData) <= self::longitud) {
            return "error de formato datos insufucientes";
        }
        $iv = $this->inicializacionVector($binaruData);
        $ciphertext = $this->extraetexto($binaruData);
        $key = $this->keyMD5($masterPassword);

        return $this->executeOpenSSLDecrypt($ciphertext, $key, $iv);
    }
    private function keyMD5(string $masterPassword): string
    {
        return md5($masterPassword, true);
    }
    private function inicializacionVector(string $data):string
    {
        return substr($data, 0, self::longitud);
    }
    private function extraetexto(string $data):string
    {
        return substr($data, self::longitud);
    }
    private function executeOpenSSLDecrypt(string $ciphertext, string $key, string $iv): string
    {
        $descrypted = openssl_decrypt(
            $ciphertext,
            self::algoritmo,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return ($descrypted === false) ? "Error en descifrado OpenSSL" : trim($descrypted);
    }
}
