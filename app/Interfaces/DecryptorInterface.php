<?php

namespace App\Interfaces;

interface DecryptorInterface
{
     public function decrypt(string $encrypted, ?string $key = null): ?string;
}
