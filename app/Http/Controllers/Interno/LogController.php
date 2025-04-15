<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Models\Estabelecimento;
use App\Models\Log;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;
        $nivel_pesquisa = $request->nivel_pesquisa;
        $ip_pesquisa = $request->ip_pesquisa;
        $grupo_pesquisa = $request->grupo_pesquisa;
        $descricao_pesquisa = $request->descricao_pesquisa;

        $query = Log::orderByDesc('id');

        if ($data_inicio) {
            $query->where('log_data', '>=', Carbon::parse($data_inicio));
        }

        if ($data_fim) {
            $query->where('log_data', '<=', Carbon::parse($data_fim));
        }

        if ($nivel_pesquisa) {
            $query->where('log_nivel', $nivel_pesquisa);
        }

        if ($ip_pesquisa) {
            $query->where('log_ip', 'like', '%' . $ip_pesquisa . '%');
        }

        if ($grupo_pesquisa) {
            $query->where('log_chave', $grupo_pesquisa);
        }

        if ($descricao_pesquisa) {
            $query->where('log_descricao', 'like', '%' . $descricao_pesquisa . '%')->orWhere('log_observacoes', 'like', '%' . $descricao_pesquisa . '%');
        }

        $logs = $query->paginate(env('PAGINACAO'))->withQueryString();

        $ips = Estabelecimento::orderBy('criado_por')->distinct()->pluck('criado_por');

        $grupos = Log::select('log_chave')
            ->groupBy('log_chave')
            ->orderBy('log_chave')
            ->pluck('log_chave');

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_logs',
            'descricao' => 'Usuário acessou a página de logs.',
        ]);

        return view('interno.log.index', [
            'menu' => 'logs',
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'nivel_pesquisa' => $nivel_pesquisa,
            'ip_pesquisa' => $ip_pesquisa,
            'grupo_pesquisa' => $grupo_pesquisa,
            'descricao_pesquisa' => $descricao_pesquisa,
            'logs' => $logs,
            'ips' => $ips,
            'grupos' => $grupos,
        ]);
    }

    public function destroy(Request $request)
    {
        try {
            $periodo = $request->periodo;
            $descricaoPeriodo = '';

            if ($periodo === 'all') {
                Log::truncate();
                $descricaoPeriodo = 'Todos os logs foram excluídos.';
            } else {
                $dias = intval($periodo);
                $limite = now()->subDays($dias);
                Log::where('log_data', '<', $limite)->delete();
                $descricaoPeriodo = "Logs com mais de {$dias} dias foram excluídos.";
            }

            // LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_logs',
                'descricao' => 'Exclusão de logs do sistema',
                'observacoes' => $descricaoPeriodo,
            ]);

            return back()->with('success', 'Logs excluídos com sucesso!');
        } catch (\Exception $e) {
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_logs',
                'descricao' => 'Erro ao excluir logs do sistema',
                'observacoes' => 'Mensagem: ' . $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao excluir logs. Tente novamente.');
        }
    }
}
