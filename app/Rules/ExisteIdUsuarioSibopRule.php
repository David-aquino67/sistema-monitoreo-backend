<?php

namespace App\Rules;

use App\Services\Sibop;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExisteIdUsuarioSibopRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try{
            Sibop::datosCompletosUsuario(env('SIBOP_API_TOKEN'), $value);
        }catch(\Exception $e){
            $fail('El ID de usuario no existe en el SIBOP.');
        }
    }
}
