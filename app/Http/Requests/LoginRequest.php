<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return[
            'email.required' => 'Informe o seu e-mail',
            'email.email' => 'Informe um e-mail válido',
            'password.required' => 'Informe a sua senha',
        ];
    }
}
