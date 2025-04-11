<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogService
{
    public static function registrar(array $dados): Log
    {
        return Log::create([
            'log_data' => now(),
            'log_ip' => Request::ip(),
            'log_nivel' => $dados['nivel'],
            'log_chave' => $dados['chave'],
            'log_descricao' => $dados['descricao'],
            'log_observacoes' => $dados['observacoes'] ?? null,
            'user_id' => $dados['user_id'] ?? Auth::id(),
        ]);
    }
}
