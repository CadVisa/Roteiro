<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Models\EstabelecimentoAcesso;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EstabelecimentoAcessoController extends Controller
{
    public function index(Request $request)
    {
        $data_pesquisa = $request->data_pesquisa;
        $ip_pesquisa = $request->ip_pesquisa;

        $query = EstabelecimentoAcesso::orderByDesc('id');

        if ($data_pesquisa) {
            $query->where('data', Carbon::parse($data_pesquisa));
        }

        if ($ip_pesquisa) {
            $query->where('ip', 'like', '%' . $ip_pesquisa . '%');
        }

        $acessos = $query->paginate(env('PAGINACAO'))->withQueryString();

        $ips = EstabelecimentoAcesso::orderBy('ip')->distinct()->pluck('ip');

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_acessos',
            'descricao' => 'Acessou a página de acessos únicos.',
        ]);

        return view('interno.acessos.index', [
            'menu' => 'acessos',
            'acessos' => $acessos,
            'data_pesquisa' => $data_pesquisa,
            'ip_pesquisa' => $ip_pesquisa,
            'ips' => $ips,
        ]);
    }
}
