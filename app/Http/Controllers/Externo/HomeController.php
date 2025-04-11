<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Models\EstabelecimentoAcesso;
use App\Services\LogService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $ip = Request::ip();
        $hoje = Carbon::today();

        EstabelecimentoAcesso::firstOrCreate([
            'ip' => $ip,
            'data' => $hoje
        ]);
        
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_inicial',
            'descricao' => 'Usuário acessou a página inicial do sistema.',
        ]);

        $acessos = EstabelecimentoAcesso::where('ip', $ip)->count();

        return view('externo.index', ['menu' => 'home', 'acessos' => $acessos]);
    }

    public function politicaPrivacidade()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_politica',
            'descricao' => 'Usuário acessou a página de política de privacidade',
        ]);

        return view('externo.politica_privacidade', ['menu' => 'home']);
    }

    public function termosUso()
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_termos',
            'descricao' => 'Usuário acessou a página de termos de uso.',
        ]);

        return view('externo.termos_uso', ['menu' => 'home']);
    }
}
