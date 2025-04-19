<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Models\DocumentoLegal;
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
        $documento = DocumentoLegal::latest()->first();

        if ($documento) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_politica',
                'descricao' => 'Acessou a página de política de privacidade',
            ]);

            return view('externo.politica_privacidade', ['menu' => 'home', 'documento' => $documento]);
        } else {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_politica',
                'descricao' => 'Página de poiltica de privacidade não encontrada.',
            ]);

            return back()->with('error', 'Página de poiltica de privacidade não encontrada.');
        }
    }

    public function termosUso()
    {
        $documento = DocumentoLegal::latest()->first();

        if ($documento) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_termos',
                'descricao' => 'Acessou a página de termos de uso.',
            ]);

            return view('externo.termos_uso', ['menu' => 'home', 'documento' => $documento]);
        } else {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_politica',
                'descricao' => 'Página de termos de uso não encontrada.',
            ]);

            return back()->with('error', 'Página de termos de uso não encontrada.');
        }
    }
}
