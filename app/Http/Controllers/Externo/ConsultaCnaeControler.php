<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Models\Cnae;
use App\Models\Movimento;
use App\Services\LogService;
use Illuminate\Http\Request;

class ConsultaCnaeControler extends Controller
{
    public function index(Request $request)
    {
        $codigo_pesquisa = $request->codigo_pesquisa;
        $descricao_pesquisa = $request->descricao_pesquisa;
        $grau_pesquisa = $request->grau_pesquisa;

        $query = Cnae::orderBy('descricao_cnae');

        if ($codigo_pesquisa) {
            $query->where('codigo_cnae', 'like', '%' . $codigo_pesquisa . '%')->orWhere('codigo_limpo', 'like', '%' . $codigo_pesquisa . '%');
        }

        if ($descricao_pesquisa) {
            $query->where('descricao_cnae', 'like', '%' . $descricao_pesquisa . '%');
        }

        if ($grau_pesquisa) {
            $query->where('grau_cnae', $grau_pesquisa);
        }

        $cnaes = $query->paginate(env('PAGINACAO'))->withQueryString();

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_consulta_cnaes',
            'descricao' => 'Usuário acessou a página de consulta de CNAEs.',
        ]);

        return view('externo.cnae_index', [
            'menu' => 'consulta_cnaes',
            'codigo_pesquisa' => $codigo_pesquisa,
            'descricao_pesquisa' => $descricao_pesquisa,
            'grau_pesquisa' => $grau_pesquisa,
            'cnaes' => $cnaes
        ]);
    }

    public function show(Cnae $cnae)
    {
        $revisao = Movimento::where('base_cnae_id', $cnae->id)
                   ->where('tipo_movimento', 'Edição')
                   ->orderByDesc('data_movimento')
                   ->first();
                   
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_consulta_cnaes',
            'descricao' => 'Usuário acessou a página para visualizar os detalhes de um CNAE.',
            'observacoes' => 'CNAE: ' . $cnae->codigo_cnae,
        ]);

        $perguntas = $cnae->perguntas()->paginate(env('PAGINACAO'));

        return view('externo.cnae_show', ['menu' => 'consulta_cnaes', 'cnae' => $cnae, 'perguntas' => $perguntas, 'revisao' => $revisao]);
    }
}
