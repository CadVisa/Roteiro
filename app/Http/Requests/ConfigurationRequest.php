<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'versao_sistema' => 'required|max:15',
            'usa_api' => 'required',
            'email_sistema' => 'required|email',
            'exibe_card' => 'required',
            'exibe_info_rodape' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'versao_sistema.required' => 'Informe a versão do sistema',
            'versao_sistema.max' => 'Pode ter no máximo :max caracteres',
            'usa_api.required' => 'Informe se a API está ativa',
            'email_sistema.required' => 'Informe o e-mail do sistema',
            'email_sistema.email' => 'Informe um e-mail válido',
            'exibe_card.required' => 'Informe se exibe os cards',
            'exibe_info_rodape.required' => 'Informe se exibe as notas do rodapé',
            
        ];
    }
}
