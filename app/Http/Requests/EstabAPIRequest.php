<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstabAPIRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cnpj' => 'required|size:18|cnpj',
        ];
    }

    public function messages(): array
    {
        return[
            'cnpj.required' => 'Informe o CNPJ',
            'cnpj.size' => 'Informe o CNPJ corretamente',
            'cnpj.cnpj' => 'CNPJ inválido',
        ];
    }
}
