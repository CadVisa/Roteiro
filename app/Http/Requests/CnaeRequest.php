<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CnaeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cnaeId = $this->route('cnae');

        return [

            'codigo_cnae' => 'required|size:9|unique:base_cnaes,codigo_cnae,' . ($cnaeId ? $cnaeId->id : null),
            'descricao_cnae' => 'required|min:3|max:500|unique:base_cnaes,descricao_cnae,' . ($cnaeId ? $cnaeId->id : null),
            'grau_cnae' => 'required',
            'competencia' => 'required',
            'notas_s_compreende' => 'nullable',
            'notas_n_compreende' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return[
            'codigo_cnae.required' => 'Informe o código do CNAE',
            'codigo_cnae.size' => 'Informe o código do CNAE corretamente',
            'codigo_cnae.unique' => 'CNAE já cadastrado',
            'descricao_cnae.required' => 'Informe a descrição do CNAE',
            'descricao_cnae.min' => 'A descrição do CNAE deve ter no mínimo :min caracteres',
            'descricao_cnae.max' => 'A descrição do CNAE deve ter no máximo :max caracteres',
            'descricao_cnae.unique' => 'CNAE já cadastrado',
            'grau_cnae.required' => 'Informe o grau de risco',
            'competencia.required' => 'Informe a competência',
        ];
    }
}
