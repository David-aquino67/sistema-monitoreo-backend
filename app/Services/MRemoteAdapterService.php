<?php

namespace App\Services;

use App\Interfaces\DecryptorInterface;

class MRemoteAdapterService implements DecryptorInterface
{
    private EncryptionService $decryptor;
    public function __construct(EncryptionService $decryptor)
    {
        $this->decryptor = $decryptor;
    }
    public function decrypt(string $encrypted, ?string $key = null): ?string
    {
        //$masterPassword = $masterPassword ?? config('services.mremote.master_password') ?? env('MASTER_PASSWORD');
        $masterPassword = env('MASTER_PASSWORD');
        if (!$masterPassword) {
            return "Error: Master Password no configurada";
        }
        return $this->decryptor->decryptMRemote($encrypted, $masterPassword);
    }
}
