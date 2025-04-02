<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerguntaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pergunta' => 'required|min:3',
            'competencia' => 'required',
            'grau_sim' => 'required',
            'grau_nao' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'pergunta.required' => 'Informe a pergunta',
            'pergunta.min' => 'A pergunta deve conter pelo menos :min caracteres',
            'competencia.required' => 'Informe a competência',
            'grau_sim.required' => 'Informe o grau se a resposta for sim',
            'grau_nao.required' => 'Informe o grau se a resposta for nao',
        ];
    }
}
