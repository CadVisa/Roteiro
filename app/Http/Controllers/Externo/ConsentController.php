<?php

namespace App\Http\Controllers\externo;

use App\Http\Controllers\Controller;
use App\Models\Consent;
use App\Services\LogService;
use Illuminate\Http\Request;

class ConsentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => 'nullable|string|max:255',
            'accepted' => 'required|boolean',
        ]);

        Consent::create([
            'token'       => $data['token'],
            'ip'          => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'accepted'    => $data['accepted'],
        ]);

        if ($data['accepted']) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_consent',
                'descricao' => 'Usuário aceitou os termos de uso e política de privacidade.',
            ]);

        } else {
            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_consent',
                'descricao' => 'Usuário não aceitou os termos de uso e política de privacidade.',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
