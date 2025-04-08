<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cardId = $this->route('card');

        return [

            'card_titulo' => 'required|max:100|unique:cards,card_titulo,' . ($cardId ? $cardId->id : null),
            'card_descricao' => 'required|min:10|max:500',
            'card_icone' => 'required|max:30|unique:cards,card_icone,' . ($cardId ? $cardId->id : null),
            'card_ordem' => 'required|integer|unique:cards,card_ordem,' . ($cardId ? $cardId->id : null),
            'card_status' => 'required|in:Ativo,Inativo',
        ];
    }

    public function messages(): array
    {
        return[
            'card_titulo.required' => 'Título é obrigatório',
            'card_titulo.size' => 'Título deve ter no máximo :max caracteres',
            'card_titulo.unique' => 'O título já está em uso',
            'card_descricao.required' => 'Descrição é obrigatória',
            'card_descricao.min' => 'Descrição deve ter no mínimo :min caracteres',
            'card_descricao.max' => 'Descrição deve ter no máximo :max caracteres',
            'card_icone.required' => 'Ícone é obrigatório',
            'card_icone.max' => 'Ícone deve ter no máximo :max caracteres',
            'card_icone.unique' => 'O ícone já está em uso',
            'card_ordem.required' => 'Ordem é obrigatório',
            'card_ordem.integer' => 'Ordem deve ser um número inteiro',
            'card_ordem.unique' => 'A ordem já está em uso',
            'card_status.required' => 'Status é obrigatório',
            'card_status.in' => 'O status deve ser Ativo ou Inativo',
        ];
    }
}
