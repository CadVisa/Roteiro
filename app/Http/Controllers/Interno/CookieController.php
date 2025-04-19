<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Models\Consent;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function index(Request $request)
    {
        $ip_pesquisa = $request->ip_pesquisa;
        $situacao = $request->situacao_pesquisa;
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;

        $situacao_pesquisa = match($situacao) {
            'Aceito' => 1,
            'Recusado' => 0,
            default => null,
        };

        $query = Consent::orderByDesc('id');

        if ($ip_pesquisa) {
            $query->where('ip', $ip_pesquisa);
        }

        if (!is_null($situacao_pesquisa)) {
            $query->where('accepted', $situacao_pesquisa);
        }

        if ($data_inicio) {
            $query->where('created_at', '>=', Carbon::parse($data_inicio));
        }

        if ($data_fim) {
            $query->where('created_at', '<=', Carbon::parse($data_fim));
        }

        $cookies = $query->paginate(env('PAGINACAO'))->withQueryString();

        $ips = Consent::orderBy('id')->distinct()->pluck('ip');

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cookies',
            'descricao' => 'Acessou a página inicial dos cookies.',
        ]);

        return view('interno.cookie.index', [
            'menu' => 'cookies',
            'cookies' => $cookies,
            'ips' => $ips,
            'ip_pesquisa' => $ip_pesquisa,
            'situacao' => $situacao,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,            
        ]);
    }

    public function show(Consent $cookie)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_cookies',
            'descricao' => 'Acessou a página para visualizar um cookie.',
            'observacoes' => 'ID: ' . $cookie->id,
        ]);

        return view('interno.cookie.show', ['menu' => 'cookies', 'cookie' => $cookie]);
    }
}
