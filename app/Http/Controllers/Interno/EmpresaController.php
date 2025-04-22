<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Models\Estabelecimento;
use App\Services\LogService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $razao_pesquisa = $request->razao_pesquisa;
        $cnpj_pesquisa = $request->cnpj_pesquisa;
        $cidade_pesquisa = $request->cidade_pesquisa;
        $estado_pesquisa = $request->estado_pesquisa;
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;
        $ip_pesquisa = $request->ip_pesquisa;
        $roteiro_pesquisa = $request->roteiro_pesquisa;

        $query = Estabelecimento::orderBy('razao_social');

        if ($razao_pesquisa) {
            $query->where('razao_social', 'like', '%' . $razao_pesquisa . '%')->orWhere('nome_fantasia', 'like', '%' . $razao_pesquisa . '%');
        }

        if ($cnpj_pesquisa) {
            $query->where('cnpj', $cnpj_pesquisa);
        }

        if ($cidade_pesquisa) {
            $query->where('cidade', $cidade_pesquisa);
        }

        if ($estado_pesquisa) {
            $query->where('estado', $estado_pesquisa);
        }

        if ($data_inicio) {
            $query->where('criado_em', '>=', Carbon::parse($data_inicio));
        }

        if ($data_fim) {
            $query->where('criado_em', '<=', Carbon::parse($data_fim));
        }

        if ($ip_pesquisa) {
            $query->where('criado_por', $ip_pesquisa);
        }

        if ($roteiro_pesquisa) {
            if ($roteiro_pesquisa == 1) {
                // Empresas com roteiros emitidos
                $query->whereNotNull('path_roteiro');
            } elseif ($roteiro_pesquisa == 2) {
                // Empresas sem roteiros emitidos
                $query->whereNull('path_roteiro');
            }
        }

        $empresas = $query->paginate(env('PAGINACAO'))->withQueryString();

        $ips = Estabelecimento::orderBy('criado_por')->distinct()->pluck('criado_por');
        $cidades = Estabelecimento::orderBy('cidade')->distinct()->pluck('cidade');
        $estados = Estabelecimento::orderBy('estado')->distinct()->pluck('estado');

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_empresas',
            'descricao' => 'Acessou a página inicial das empresas.',
        ]);

        return view('interno.empresa.index', [
            'menu' => 'empresas',
            'empresas' => $empresas,
            'ips' => $ips,
            'cidades' => $cidades,
            'estados' => $estados,
            'razao_pesquisa' => $razao_pesquisa,
            'cnpj_pesquisa' => $cnpj_pesquisa,
            'cidade_pesquisa' => $cidade_pesquisa,
            'estado_pesquisa' => $estado_pesquisa,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'ip_pesquisa' => $ip_pesquisa,
            'roteiro_pesquisa' => $roteiro_pesquisa
        ]);
    }

    public function gerarPDF(Request $request)
    {
        $razao_pesquisa = $request->razao_pesquisa;
        $cnpj_pesquisa = $request->cnpj_pesquisa;
        $cidade_pesquisa = $request->cidade_pesquisa;
        $estado_pesquisa = $request->estado_pesquisa;
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;
        $ip_pesquisa = $request->ip_pesquisa;
        $roteiro_pesquisa = $request->roteiro_pesquisa;

        $query = Estabelecimento::orderBy('razao_social');

        if ($razao_pesquisa) {
            $query->where('razao_social', 'like', '%' . $razao_pesquisa . '%')->orWhere('nome_fantasia', 'like', '%' . $razao_pesquisa . '%');
        }

        if ($cnpj_pesquisa) {
            $query->where('cnpj', $cnpj_pesquisa);
        }

        if ($cidade_pesquisa) {
            $query->where('cidade', $cidade_pesquisa);
        }

        if ($estado_pesquisa) {
            $query->where('estado', $estado_pesquisa);
        }

        if ($data_inicio) {
            $query->where('criado_em', '>=', Carbon::parse($data_inicio));
        }

        if ($data_fim) {
            $query->where('criado_em', '<=', Carbon::parse($data_fim));
        }

        if ($ip_pesquisa) {
            $query->where('criado_por', $ip_pesquisa);
        }

        if ($roteiro_pesquisa) {
            if ($roteiro_pesquisa == 1) {
                // Empresas com roteiros emitidos
                $query->whereNotNull('path_roteiro');
            } elseif ($roteiro_pesquisa == 2) {
                // Empresas sem roteiros emitidos
                $query->whereNull('path_roteiro');
            }
        }

        $empresas = $query->get();

        if ($empresas->isEmpty()) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_empresas',
                'descricao' => 'Tentou gerar o relatório sem informações.',
            ]);

            return back()->withInput()->with('error', 'Sem informações para gerar o relatório!');
        }

        if ($empresas->count() > 1000) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_empresas',
                'descricao' => 'Tentou gerar o relatório com mais de 1000 registros.',
            ]);

            return back()->withInput()->with('error', 'A consulta retornou mais de 1000 registros! Redefina os parâmetros da consulta.');
        }

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_empresas',
            'descricao' => 'Gerou relatório das empresas.',
        ]);

        $nomePdf = 'Relatório_empresas.pdf';

        $pdf = Pdf::loadView('interno.relatorios.empresas-1', [
            'menu' => 'empresas',
            'empresas' => $empresas,
            'razao_pesquisa' => $razao_pesquisa,
            'cnpj_pesquisa' => $cnpj_pesquisa,
            'cidade_pesquisa' => $cidade_pesquisa,
            'estado_pesquisa' => $estado_pesquisa,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'ip_pesquisa' => $ip_pesquisa,
            'roteiro_pesquisa' => $roteiro_pesquisa
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

    public function destroy(Request $request)
    {
        $request->validate([
            'periodo' => 'required',
        ], [
            'periodo.required' => 'Selecione um período para exclusão das empresas.',
        ]);

        try {
            $periodo = $request->periodo;
            $descricaoPeriodo = '';

            if ($periodo === 'all') {
                Estabelecimento::with('cnaes.perguntas')->get()->each(function ($estabelecimento) {
                    foreach ($estabelecimento->cnaes as $cnae) {
                        $cnae->perguntas()->delete();
                        $cnae->delete();
                    }
                    $estabelecimento->delete();
                });
                $descricaoPeriodo = 'Todas as empresas foram excluídas.';
            } else {
                $dias = intval($periodo);
                $limite = now()->subDays($dias);

                Estabelecimento::where('criado_em', '<', $limite)
                    ->with('cnaes.perguntas')
                    ->get()
                    ->each(function ($estabelecimento) {
                        foreach ($estabelecimento->cnaes as $cnae) {
                            $cnae->perguntas()->delete();
                        }
                        $estabelecimento->cnaes()->delete();
                        $estabelecimento->delete();
                    });


                $descricaoPeriodo = "Empresas cadastradas com mais de {$dias} dias foram excluídas.";
            }

            // LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_empresas',
                'descricao' => 'Exclusão de empresas.',
                'observacoes' => $descricaoPeriodo,
            ]);

            return back()->with('success', 'Empresas excluídas com sucesso!');
        } catch (\Exception $e) {
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_empresas',
                'descricao' => 'Erro ao excluir empresas cadastradas.',
                'observacoes' => 'Mensagem: ' . $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao excluir empresas cadastradas. Tente novamente.');
        }
    }

    public function show(Estabelecimento $estabelecimento)
    {
        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_empresas',
            'descricao' => 'Acessou a página para visualizar os detalhes de uma empresa.',
            'observacoes' => 'CNPJ: ' . $estabelecimento->id,
        ]);

        return view('interno.empresa.show', ['menu' => 'empresas', 'estabelecimento' => $estabelecimento]);
    }

    public function destroyEmpresa(Estabelecimento $estabelecimento)
    {
        DB::beginTransaction();

        try {
            // Exclui as perguntas relacionadas aos CNAEs do estabelecimento
            foreach ($estabelecimento->cnaes as $cnae) {
                $cnae->perguntas()->delete();
            }

            // Exclui os CNAEs do estabelecimento
            $estabelecimento->cnaes()->delete();

            // Exclui o estabelecimento
            $estabelecimento->delete();

            DB::commit();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '1',
                'chave' => 'pg_empresas',
                'descricao' => 'Excluiu uma empresa.',
                'observacoes' => 'ID: ' . $estabelecimento->id,
            ]);

            return redirect()->route('empresa.index', ['menu' => 'empresas'])->with('success', 'Empresa excluída com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_empresas',
                'descricao' => 'Erro ao excluir uma empresa.',
                'observacoes' => 'ID: ' . $estabelecimento->id . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Empresa não excluída!');
        }
    }

    public function baixar($nome)
    {
        $caminho = public_path('roteiros/' . $nome);

        if (!file_exists($caminho)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->download($caminho);
    }
}
