<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocTermosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'termos_uso' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'termos_uso.required' => 'Informe os termos de uso',
        ];
    }
}
