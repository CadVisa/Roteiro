<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Models\Cnae;
use App\Models\Configuration;
use App\Models\Consent;
use App\Models\Contato;
use App\Models\Estabelecimento;
use App\Models\EstabelecimentoAcesso;
use App\Models\Log;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdministradorController extends Controller
{
    public function index()
    {
        $statusSistema = Configuration::value('status_sistema');

        // Gera os últimos 10 dias como datas (Carbon)
        $dias = collect();
        for ($i = 0; $i < 10; $i++) {
            $dias->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        // Consulta acessos reais nesses dias
        $acessos = EstabelecimentoAcesso::selectRaw('DATE(data) as data, COUNT(*) as total')
            ->where('data', '>=', Carbon::today()->subDays(9))
            ->groupBy('data')
            ->pluck('total', 'data');

        // Combina os dias com os acessos (colocando 0 se não houver acesso)
        $acessosPorDia = $dias->map(function ($dia) use ($acessos) {
            return [
                'data' => $dia,
                'total' => $acessos->get($dia, 0),
            ];
        });

        // Busca as 10 cidades mais pesquisadas
        $cidadesMaisFrequentes = Estabelecimento::select('cidade', 'estado', DB::raw('count(*) as total'))
            ->whereNotNull('cidade')
            ->whereNotNull('estado')
            ->groupBy('cidade', 'estado')
            ->orderByRaw('count(*) DESC')
            ->limit(10)
            ->get();

        // Busca as 10 cidades mais pesquisadas
        $ipsMaisFrequentes = Estabelecimento::select('criado_por', DB::raw('count(*) as total'))
            ->whereNotNull('criado_por')
            ->groupBy('criado_por')
            ->orderByRaw('count(*) DESC')
            ->limit(10)
            ->get();

        $logsSistema = Log::count();
        $logs_4 = Log::where('log_nivel', 4)->count();
        $logs_1 = Log::where('log_nivel', 1)->count();
        $logs_2 = Log::where('log_nivel', 2)->count();
        $logs_3 = Log::where('log_nivel', 3)->count();

        $contatos = Contato::count();
        $contatosNovos = Contato::where('status', 'Pendente')->count();
        $contatosVisualizados = Contato::where('status', 'Visualizado')->count();
        $contatosFinalizados = Contato::where('status', 'Finalizado')->count();

        $cnaes = Cnae::count();
        $cnaesRevisados = Cnae::whereHas('movimentos', function ($query) {
            $query->where('tipo_movimento', 'Edição');
        })->distinct('id')->count('id');

        $cnaesSemRevisao = Cnae::whereDoesntHave('movimentos', function ($query) {
            $query->where('tipo_movimento', 'Edição');
        })->distinct('id')->count('id');

        $arquivos = File::files(public_path('roteiros'));

        $quantidadeArquivos = count($arquivos);
        $tamanhoTotalBytes = collect($arquivos)->sum(function ($file) {
            return $file->getSize();
        });

        $tamanhoTotalMB = $this->formatarTamanho($tamanhoTotalBytes);

        $consents = Consent::count();
        $accepted_0 = Consent::where('accepted', 0)->count();
        $accepted_1 = Consent::where('accepted', 1)->count();

        $empresas = Estabelecimento::count();
        $empresasSemRoteiro = Estabelecimento::whereNull('path_roteiro')->count();
        $empresasComRoteiro = Estabelecimento::whereNotNull('path_roteiro')->count();

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_adm',
            'descricao' => 'Acessou a página inicial do administrador.',
        ]);

        return view('interno.adm.index', [
            'menu' => 'dashboard',
            'statusSistema' => $statusSistema,
            'acessosPorDia' => $acessosPorDia,
            'cidadesMaisFrequentes' => $cidadesMaisFrequentes,
            'ipsMaisFrequentes' => $ipsMaisFrequentes,
            'logsSistema' => $logsSistema,
            'logs_4' => $logs_4,
            'logs_1' => $logs_1,
            'logs_2' => $logs_2,
            'logs_3' => $logs_3,
            'contatos' => $contatos,
            'contatosNovos' => $contatosNovos,
            'contatosVisualizados' => $contatosVisualizados,
            'contatosFinalizados' => $contatosFinalizados,
            'cnaes' => $cnaes,
            'cnaesRevisados' => $cnaesRevisados,
            'cnaesSemRevisao' => $cnaesSemRevisao,
            'quantidadeArquivos' => $quantidadeArquivos,
            'tamanhoTotalMB' => $tamanhoTotalMB,
            'consents' => $consents,
            'accepted_0' => $accepted_0,
            'accepted_1' => $accepted_1,
            'empresas' => $empresas,
            'empresasSemRoteiro' => $empresasSemRoteiro,
            'empresasComRoteiro' => $empresasComRoteiro,
        ]);
    }

    // Método auxiliar para formatar o tamanho do arquivo em KB, MB, etc.
    private function formatarTamanho($bytes)
    {
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return round($bytes / pow(1024, $factor)) . ' ' . $size[$factor];
    }
}
