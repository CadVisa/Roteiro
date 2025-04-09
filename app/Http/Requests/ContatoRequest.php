<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'nome' => 'required|min:3|max:100',
            'email' => 'required|max:100|email',
            'telefone' => 'nullable|size:14',
            'descricao' => 'required|min:10|max:800',
        ];
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Nome é obrigatório',
            'nome.min' => 'Nome deve ter no mínimo :min caracteres',
            'nome.max' => 'Nome deve ter no máximo :max caracteres',
            'email.required' => 'E-mail é obrigatório',
            'email.max' => 'E-mail deve ter no máximo :max caracteres',
            'email.email' => 'Informe um e-mail válido',
            'telefone.size' => 'Informe um telefone válido',
            'descricao.required' => 'mensagem é obrigatória',
            'descricao.min' => 'Descrição deve ter no mínimo :min caracteres',
            'descricao.max' => 'Descrição deve ter no máximo :max caracteres',
        ];
    }
}
