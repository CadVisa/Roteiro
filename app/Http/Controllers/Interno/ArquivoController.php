<?php

namespace App\Http\Controllers\interno;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArquivoController extends Controller
{
    public function index(Request $request)
    {
        $nome_pesquisa = $request->nome_pesquisa;
        $data_pesquisa = $request->data_pesquisa;
        $ordenar_por = $request->ordenar_por ?? 'data';
        $ordem = $request->ordem ?? 'asc';

        $path = storage_path('app/public/roteiros');
        $arquivos = collect();

        if (File::exists($path)) {
            $files = File::files($path);

            // Mapeia os arquivos com os dados necessários
            $arquivos = collect($files)->map(function ($file) {
                return [
                    'nome' => $file->getFilename(),
                    'tamanho' => $this->formatarTamanho($file->getSize()),
                    'tamanho_bytes' => $file->getSize(),
                    'data_timestamp' => $file->getMTime(),
                    'data' => Carbon::createFromTimestamp($file->getMTime())->format('d/m/Y H:i'),
                    'url' => asset('storage/roteiros/' . $file->getFilename()),
                ];
            });

            // Filtro por nome
            if ($nome_pesquisa) {
                $arquivos = $arquivos->filter(function ($arquivo) use ($nome_pesquisa) {
                    return str_contains(Str::lower($arquivo['nome']), Str::lower($nome_pesquisa));
                });
            }

            // Filtro por data
            if ($data_pesquisa) {
                try {
                    $dataCarbon = Carbon::parse($data_pesquisa)->format('Y-m-d');

                    $arquivos = $arquivos->filter(function ($arquivo) use ($dataCarbon) {
                        $dataArquivo = Carbon::createFromTimestamp($arquivo['data_timestamp'])->format('Y-m-d');
                        return $dataArquivo === $dataCarbon;
                    });
                } catch (\Exception $e) {
                    // Ignora filtro se a data for inválida
                }
            }

            // Ordenação
            $arquivos = $arquivos->sortBy(function ($item) use ($ordenar_por) {
                if ($ordenar_por === 'data') return $item['data_timestamp'];
                if ($ordenar_por === 'tamanho') return $item['tamanho_bytes'];
                return strtolower($item['nome']);
            }, SORT_REGULAR, $ordem === 'desc')->values();
        }

        // Cálculo do tamanho total em bytes
        $tamanhoTotalBytes = $arquivos->sum('tamanho_bytes');

        // Número de arquivos
        $n_arquivos = $arquivos->count();

        // Tamanho total formatado
        $tamanhoTotal = $this->formatarTamanho($tamanhoTotalBytes);

        // Média dos tamanhos
        $mediaBytes = $n_arquivos > 0 ? $tamanhoTotalBytes / $n_arquivos : 0;
        $media = $this->formatarTamanho($mediaBytes);

        // Paginação manual
        $perPage = env('PAGINACAO', 10);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $arquivos->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($currentItems, $arquivos->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_arquivos',
            'descricao' => 'Acessou a página de arquivos.',
        ]);

        return view('interno.arquivo.index', [
            'menu' => 'arquivos',
            'n_arquivos' => $n_arquivos,
            'paginated' => $paginated,
            'tamanhoTotal' => $tamanhoTotal,
            'media' => $media,
            'nome_pesquisa' => $nome_pesquisa,
            'data_pesquisa' => $data_pesquisa,
            'ordenar_por' => $ordenar_por,
            'ordem' => $ordem
        ]);
    }

    private function formatarTamanho($bytes, $decimals = 0)
    {
        // Definir as unidades de tamanho
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];

        // Se o valor for menor que 1 KB, já mostre em B (bytes)
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        // Calcular o fator para definir a unidade de medida
        $factor = floor(log($bytes, 1024));

        // Calcular o tamanho e formatar com arredondamento
        $formattedSize = round($bytes / pow(1024, $factor), $decimals);

        // Garantir que a unidade seja retornada corretamente
        return $formattedSize . ' ' . $size[$factor];
    }

    public function gerarPDF(Request $request)
    {
        $nome_pesquisa = $request->nome_pesquisa;
        $data_pesquisa = $request->data_pesquisa;
        $ordenar_por = $request->ordenar_por ?? 'data';
        $ordem = $request->ordem ?? 'asc';

        $path = storage_path('app/public/roteiros');
        $arquivos = collect();

        if (File::exists($path)) {
            $files = File::files($path);

            // Mapeia os arquivos com os dados necessários
            $arquivos = collect($files)->map(function ($file) {
                return [
                    'nome' => $file->getFilename(),
                    'tamanho' => $this->formatarTamanho($file->getSize()),
                    'tamanho_bytes' => $file->getSize(),
                    'data_timestamp' => $file->getMTime(),
                    'data' => Carbon::createFromTimestamp($file->getMTime())->format('d/m/Y H:i'),
                    'url' => asset('storage/roteiros/' . $file->getFilename()),
                ];
            });

            // Filtro por nome
            if ($nome_pesquisa) {
                $arquivos = $arquivos->filter(function ($arquivo) use ($nome_pesquisa) {
                    return str_contains(Str::lower($arquivo['nome']), Str::lower($nome_pesquisa));
                });
            }

            // Filtro por data
            if ($data_pesquisa) {
                try {
                    $dataCarbon = Carbon::parse($data_pesquisa)->format('Y-m-d');

                    $arquivos = $arquivos->filter(function ($arquivo) use ($dataCarbon) {
                        $dataArquivo = Carbon::createFromTimestamp($arquivo['data_timestamp'])->format('Y-m-d');
                        return $dataArquivo === $dataCarbon;
                    });
                } catch (\Exception $e) {
                    // Ignora filtro se a data for inválida
                }
            }

            // Ordenação
            $arquivos = $arquivos->sortBy(function ($item) use ($ordenar_por) {
                if ($ordenar_por === 'data') return $item['data_timestamp'];
                if ($ordenar_por === 'tamanho') return $item['tamanho_bytes'];
                return strtolower($item['nome']);
            }, SORT_REGULAR, $ordem === 'desc')->values();
        }

        // Cálculo do tamanho total em bytes
        $tamanhoTotalBytes = $arquivos->sum('tamanho_bytes');

        // Número de arquivos
        $n_arquivos = $arquivos->count();

        // Tamanho total formatado
        $tamanhoTotal = $this->formatarTamanho($tamanhoTotalBytes);

        // Média dos tamanhos
        $mediaBytes = $n_arquivos > 0 ? $tamanhoTotalBytes / $n_arquivos : 0;
        $media = $this->formatarTamanho($mediaBytes);

        if ($arquivos->isEmpty()) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_arquivos',
                'descricao' => 'Tentou gerar o relatório sem informações.',
            ]);

            return back()->withInput()->with('error', 'Sem informações para gerar o relatório!');
        }

        if ($arquivos->count() > 1000) {

            //LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_arquivos',
                'descricao' => 'Tentou gerar o relatório com mais de 1000 registros.',
            ]);

            return back()->withInput()->with('error', 'A consulta retornou mais de 1000 registros! Redefina os parâmetros da consulta.');
        }

        //LOG DO SISTEMA
        LogService::registrar([
            'nivel' => '1',
            'chave' => 'pg_arquivos',
            'descricao' => 'Gerou relatório dos arquivos.',
        ]);

        $nomePdf = 'Relatório_arquivos.pdf';

        $pdf = Pdf::loadView('interno.relatorios.arquivos-1', [
            'menu' => 'arquivos',
            'arquivos' => $arquivos,
            'nome_pesquisa' => $nome_pesquisa,
            'data_pesquisa' => $data_pesquisa,
            'n_arquivos' => $n_arquivos,
            'tamanhoTotal' => $tamanhoTotal,
            'media' => $media
        ]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 96,
            'isPhpEnabled' => true,
        ]);

        //return $pdf->download($nomePdf);
        return $pdf->stream($nomePdf);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'periodo' => 'required',
        ], [
            'periodo.required' => 'Selecione um período para exclusão dos arquivos.',
        ]);

        try {
            $periodo = $request->periodo;
            $descricaoPeriodo = '';

            $path = storage_path('app/public/roteiros');

            // Verifica se o diretório existe
            if (!File::exists($path)) {
                return back()->with('error', 'A pasta de roteiros não foi encontrada.');
            }

            // Recupera todos os arquivos na pasta
            $files = File::files($path);

            // Se o período for 'all', exclui todos os arquivos
            if ($periodo === 'all') {
                foreach ($files as $file) {
                    File::delete($file); // Exclui o arquivo
                }
                $descricaoPeriodo = 'Todos os arquivos foram excluídos.';
            } else {
                // Se o período for um número de dias, exclui os arquivos modificados antes do limite
                $dias = intval($periodo);
                $limite = now()->subDays($dias);

                foreach ($files as $file) {
                    $fileTimestamp = Carbon::createFromTimestamp($file->getMTime());

                    if ($fileTimestamp->lt($limite)) {
                        File::delete($file); // Exclui o arquivo se for mais antigo que o limite
                    }
                }

                $descricaoPeriodo = "Arquivos com mais de {$dias} dias foram excluídos.";
            }

            // LOG DO SISTEMA
            LogService::registrar([
                'nivel' => '2',
                'chave' => 'pg_arquivos',
                'descricao' => 'Exclusão de arquivos do sistema',
                'observacoes' => $descricaoPeriodo,
            ]);

            return back()->with('success', 'Arquivos excluídos com sucesso!');
        } catch (\Exception $e) {
            // LOG DO ERRO
            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_arquivos',
                'descricao' => 'Erro ao excluir arquivos',
                'observacoes' => 'Mensagem: ' . $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao excluir arquivos. Tente novamente.');
        }
    }

    public function destroyArquivo($arquivo)
    {
        DB::beginTransaction();

        try {

            $path = storage_path('app/public/roteiros/' . $arquivo);
            if (File::exists($path)) {
                File::delete($path);

                //LOG DO SISTEMA
                LogService::registrar([
                    'nivel' => '1',
                    'chave' => 'pg_arquivos',
                    'descricao' => 'Excluiu um arquivo.',
                    'observacoes' => 'Arquivo: ' . $arquivo,
                ]);
                DB::commit();
                return back()->with('success', 'Arquivo excluído com sucesso!');
            } else {

                //LOG DO SISTEMA
                LogService::registrar([
                    'nivel' => '3',
                    'chave' => 'pg_arquivos',
                    'descricao' => 'Erro ao excluir um arquivo.',
                    'observacoes' => 'Arquivo: ' . $arquivo . ' | Erro: Arquivo não encontrado.',
                ]);

                DB::commit();
                return back()->with('error', 'Arquivo não encontrado.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::registrar([
                'nivel' => '3',
                'chave' => 'pg_arquivos',
                'descricao' => 'Erro ao excluir um arquivo.',
                'observacoes' => 'Arquivo: ' . $arquivo . ' | Erro: ' . $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao excluir o arquivo.');
        }
    }
}
