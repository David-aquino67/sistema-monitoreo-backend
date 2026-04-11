<?php

namespace App\Interfaces;

interface DecryptorInterface
{
     public function decrypt(string $data): ?string;
}
