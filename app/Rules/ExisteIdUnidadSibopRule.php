<?php

namespace App\Rules;

use App\Services\Sibop;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExisteIdUnidadSibopRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try{
            $unidades = Sibop::unidades(env('SIBOP_API_TOKEN'), [$value]);
            if(count($unidades) != 1){
                $fail('Unidad inexistente en el SIBOP');
            }
        }catch(\Exception $e){
            $fail('Unidad inexistente en el SIBOP');
        }
    }
}
