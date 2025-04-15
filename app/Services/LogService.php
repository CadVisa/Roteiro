<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogService
{
    public static function registrar(array $dados): ?Log
    {
        $userId = $dados['user_id'] ?? Auth::id();

        // Ignora o log se o usuário autenticado for o ID 1
        // if ($userId === 1) {
        //     return null;
        // }
        
        return Log::create([
            'log_data' => now(),
            'log_ip' => Request::ip(),
            'log_nivel' => $dados['nivel'],
            'log_chave' => $dados['chave'],
            'log_descricao' => $dados['descricao'],
            'log_observacoes' => $dados['observacoes'] ?? null,
            'user_id' => $userId,
        ]);
    }
}
