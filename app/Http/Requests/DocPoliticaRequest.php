<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocPoliticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'politica_privacidade' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'politica_privacidade.required' => 'Informe as politicas de privacidade',
        ];
    }
}
