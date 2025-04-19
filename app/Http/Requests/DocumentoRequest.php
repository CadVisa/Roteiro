<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'termos_uso' => 'required',
            'politica_privacidade' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'termos_uso.required' => 'Informe os termos de uso',
            'politica_privacidade.required' => 'Informe a política de privacidade',
        ];
    }
}
