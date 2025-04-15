<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Models\Estabelecimento;
use App\Models\Log;
use App\Services\LogService;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $request->validate([
            'periodo' => 'required',
        ], [
            'periodo.required' => 'Selecione um período para exclusão dos logs.',
        ]);

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

    public function gerarPDF(Request $request)
    {
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;
        $nivel_pesquisa = $request->nivel_pesquisa;
        $ip_pesquisa = $request->ip_pesquisa;
        $grupo_pesquisa = $request->grupo_pesquisa;
        $descricao_pesquisa = $request->descricao_pesquisa;

        $query = Log::orderBy('id');

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

        $logs = $query->get();

        if ($logs->isEmpty()) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_logs',
                'descricao' => 'Tentou gerar o relatório sem informações.',
            ]);

            return back()->withInput()->with('error', 'Sem informações para gerar o relatório!');
        }

        if ($logs->count() > 1000) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_logs',
                'descricao' => 'Tentou gerar o relatório com mais de 1000 registros.',
            ]);

            return back()->withInput()->with('error', 'A consulta retornou mais de 1000 registros! Redefina os parâmetros da consulta.');
        }

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_logs',
            'descricao' => 'Gerou relatório dos logs.',
        ]);

        $nomePdf = 'Relatório_logs.pdf';

        $pdf = Pdf::loadView('interno.relatorios.logs-1', [
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'nivel_pesquisa' => $nivel_pesquisa,
            'ip_pesquisa' => $ip_pesquisa,
            'grupo_pesquisa' => $grupo_pesquisa,
            'descricao_pesquisa' => $descricao_pesquisa,
            'logs' => $logs
        ]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 96,
            'isPhpEnabled' => true,
        ]);

        return $pdf->download($nomePdf);
        //return $pdf->stream($nomePdf);
    }

    public function alterar(Request $request, Log $log)
    {
        // dd($request->log_nivel);

        if ($request->log_nivel == 1) {
            $log->update([
                'log_nivel' => 2
            ]);

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_logs',
                'descricao' => 'Alterou o nível do log.',
                'observacoes' => 'De: ' . $request->log_nivel . ' para ' . $log->log_nivel . '. Log: ' . $log->id . '.',
            ]);

            return back()->withInput()->with('success', 'Nível do log alterado com sucesso!');
        } elseif ($request->log_nivel == 2) {
            $log->update([
                'log_nivel' => 3
            ]);

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_logs',
                'descricao' => 'Alterou o nível do log.',
                'observacoes' => 'De: ' . $request->log_nivel . ' para ' . $log->log_nivel . '. Log: ' . $log->id . '.',
            ]);

            return back()->withInput()->with('success', 'Nível do log alterado com sucesso!');
        } elseif ($request->log_nivel == 3) {
            $log->update([
                'log_nivel' => 4
            ]);

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_logs',
                'descricao' => 'Alterou o nível do log.',
                'observacoes' => 'De: ' . $request->log_nivel . ' para ' . $log->log_nivel . '. Log: ' . $log->id . '.',
            ]);

            return back()->withInput()->with('success', 'Nível do log alterado com sucesso!');
        } elseif ($request->log_nivel == 4) {
            $log->update([
                'log_nivel' => 1
            ]);

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_logs',
                'descricao' => 'Alterou o nível do log.',
                'observacoes' => 'De: ' . $request->log_nivel . ' para ' . $log->log_nivel . '. Log: ' . $log->id . '.',
            ]);

            return back()->withInput()->with('success', 'Nível do log alterado com sucesso!');
        } else {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_logs',
                'descricao' => 'Informou um nível de log que não existe.',
                'observacoes' => 'Nível de log informado: ' . $request->log_nivel . '.',
            ]);

            return back()->withInput()->with('error', 'Algo deu errado!');
        }
    }
}
