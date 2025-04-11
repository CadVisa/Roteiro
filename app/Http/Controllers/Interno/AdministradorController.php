<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_adm',
            'descricao' => 'Usuário acessou a página inicial do administrador.',
        ]);
        
        return view('interno.adm.index', ['menu' => 'dashboard']);
    }
}
