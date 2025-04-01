<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Models\Cnae;
use Illuminate\Http\Request;

class CnaeController extends Controller
{
    public function index(Request $request)
    {
        $codigo_pesquisa = $request->codigo_pesquisa;
        $descricao_pesquisa = $request->descricao_pesquisa;
        $grau_pesquisa = $request->grau_pesquisa;
        $competencia_pesquisa = $request->competencia_pesquisa;

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

        if ($competencia_pesquisa) {
            $query->where('competencia', $competencia_pesquisa);
        }

        $cnaes = $query->paginate(env('PAGINACAO'))->withQueryString();

        return view('interno.cnae.index', [
            'menu' => 'cnaes',
            'codigo_pesquisa' => $codigo_pesquisa,
            'descricao_pesquisa' => $descricao_pesquisa,
            'grau_pesquisa' => $grau_pesquisa,
            'competencia_pesquisa' => $competencia_pesquisa,
            'cnaes' => $cnaes
        ]);
    }
}
