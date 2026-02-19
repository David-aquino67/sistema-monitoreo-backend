<?php

namespace App\Http\Requests;

use App\Rules\ExisteIdUsuarioSibopRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_sibop' => $this->route('id_sibop') ?? $this->input('id_sibop'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $getRules = [
            'id_sibop' => ['required', 'integer', 'exists:usuarios,id_sibop']
        ];

        $postRules = [
            'id_sibop' => ['required', 'integer', new ExisteIdUsuarioSibopRule()],
            'FK_permiso_ability' => ['required', 'string', 'exists:permisos,ability'],
        ];

        if($this->isMethod('post')) { 
            return $postRules;
        }

        if($this->isMethod('put')) {
            return array_merge($postRules, $getRules);
        }

        if($this->isMethod('get') || $this->isMethod('delete')) {
            return $getRules;
        }

        return [];
    }
}
