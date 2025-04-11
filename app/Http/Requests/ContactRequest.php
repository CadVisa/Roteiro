<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'observacoes' => 'nullable|max:2000',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'observacoes.max' => 'Observações deve ter no máximo :max caracteres',
            'status.required' => 'Status é obrigatório',
        ];
    }
}
