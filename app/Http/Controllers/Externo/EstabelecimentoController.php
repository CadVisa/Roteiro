<?php

namespace App\Http\Controllers\Externo;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstabAPIRequest;
use App\Models\Configuration;
use App\Models\EstabCnae;
use App\Models\Estabelecimento;
use App\Services\CnpjWsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Throwable;

class EstabelecimentoController extends Controller
{
    //CONSTRUTOR DO WEBSERVICE PARA USAR API RECEITA WS
    protected $cnpjWSService;

    public function __construct(CnpjWsService $cnpjWSService)
    {
        $this->cnpjWSService = $cnpjWSService;
    }

    public function store(EstabAPIRequest $request)
    {
        $request->validated();

        $config = Configuration::first();

        if ($config && $config->usa_api == 'Sim') {

            $cnpj = $request->cnpj;

            $cnpjLimpo = preg_replace("/[^0-9]/", "", $cnpj);

            DB::beginTransaction();

            try {

                // Faz a consulta na API
                $dadosEmpresa = $this->cnpjWSService->consultarCNPJ($cnpjLimpo);

                //dd($dadosEmpresa);

                // Verifica se a API retornou vazia
                if (empty($dadosEmpresa)) {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Nenhuma informação foi retornada pela consulta');
                }

                $situacoesInvalidas = [
                    'baixada',
                    'inapta',
                    'suspensa',
                    'nula',
                    'cancelada',
                    'irregular',
                    'pendente',
                ];

                $situacao = strtolower(trim($dadosEmpresa['estabelecimento']['situacao_cadastral'] ?? ''));

                if (in_array($situacao, $situacoesInvalidas)) {
                    $razaoSocial = ucwords(strtolower($dadosEmpresa["razao_social"] ?? 'Não informada'));
                    $dataAtualizacao = Carbon::parse($dadosEmpresa['atualizado_em'] ?? now())->format('d/m/Y H:i');

                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->with('error', "A empresa {$razaoSocial} encontra-se com a situação cadastral '{$situacao}' 
                            junto à Receita Federal. A última atualização no banco de dados ocorreu em $dataAtualizacao");
                }


                // Concatena o tipo de logradouro com logradouro
                $logradouro = $dadosEmpresa['estabelecimento']['tipo_logradouro'] . ' ' . $dadosEmpresa['estabelecimento']['logradouro'];

                // Formata o CEP
                $cep = $dadosEmpresa['estabelecimento']['cep'];
                $cepNumeros = preg_replace('/[^0-9]/', '', $cep);
                $cepFormatado = substr($cepNumeros, 0, 2) . '.' . substr($cepNumeros, 2, 3) . '-' . substr($cepNumeros, 5, 3);

                // Formata o telefone
                function formatarTelefoneBrasil($telefone = null, $ddd = null)
                {
                    $telefoneLimpo = preg_replace('/[^0-9]/', '', $telefone);
                    $tamanho = strlen($telefoneLimpo);

                    $formatado = match ($tamanho) {
                        8 => preg_replace('/(\d{4})(\d{4})/', '$1-$2', $telefoneLimpo),       // 0000-0000
                        9 => preg_replace('/(\d{1})(\d{3})(\d{4})/', '$1.$2-$3', $telefoneLimpo), // 0.000-0000
                        default => $telefoneLimpo
                    };

                    if ($ddd) {
                        $dddLimpo = preg_replace('/[^0-9]/', '', $ddd);
                        return "$dddLimpo $formatado";
                    }

                    return $formatado;
                }

                // Uso para telefone 1
                $telefone1Formatado = formatarTelefoneBrasil(
                    $dadosEmpresa['estabelecimento']['telefone1'] ?? null,
                    $dadosEmpresa['estabelecimento']['ddd1'] ?? null
                );

                // Uso para telefone 2
                $telefone2Formatado = formatarTelefoneBrasil(
                    $dadosEmpresa['estabelecimento']['telefone2'] ?? null,
                    $dadosEmpresa['estabelecimento']['ddd2'] ?? null
                );

                // Cadastra o estabelecimento
                $estabelecimento = Estabelecimento::create([
                    'razao_social' => $dadosEmpresa['razao_social'],
                    'nome_fantasia' => $dadosEmpresa['estabelecimento']['nome_fantasia'] ?? 'Não informado',
                    'cnpj' => $cnpj,
                    'atualizado_em' => $dadosEmpresa["estabelecimento"]["atualizado_em"],
                    'logradouro' => $logradouro,
                    'numero' => $dadosEmpresa['estabelecimento']['numero'],
                    'complemento' => $dadosEmpresa['estabelecimento']['complemento'],
                    'bairro' => $dadosEmpresa['estabelecimento']['bairro'],
                    'cidade' => $dadosEmpresa['estabelecimento']['cidade']['nome'],
                    'estado' => $dadosEmpresa['estabelecimento']['estado']['sigla'],
                    'cep' => $cepFormatado,
                    'telefone_1' => $telefone1Formatado ?? 'Não informado',
                    'telefone_2' => $telefone2Formatado ?? 'Não informado',
                    'email' => $dadosEmpresa['estabelecimento']['email'] ?? 'Não informado',
                    'criado_em' => now(),
                    'criado_por' => request()->ip(),
                ]);

                // Pega o ID do estabelecimento
                $estabelecimentoId = $estabelecimento->id;

                // Entra neste neste IF caso haja atividade principal
                if (isset($dadosEmpresa['estabelecimento']['atividade_principal'])) {

                    // Inclui a atividade principal
                    EstabCnae::create([
                        'estabelecimento_id' => $estabelecimentoId,
                        'codigo_cnae' => $dadosEmpresa['estabelecimento']['atividade_principal']['subclasse'],
                        'codigo_limpo' => $dadosEmpresa['estabelecimento']['atividade_principal']['id'],
                        'descricao_cnae' => $dadosEmpresa['estabelecimento']['atividade_principal']['descricao'],
                    ]);

                    // Entra neste neste IF caso hajam atividades secundárias
                    if (isset($dadosEmpresa['estabelecimento']['atividades_secundarias'])) {
                        foreach ($dadosEmpresa['estabelecimento']['atividades_secundarias'] as $atividadeSecundaria) {
                            EstabCnae::create([
                                'estabelecimento_id' => $estabelecimentoId,
                                'codigo_cnae' => $atividadeSecundaria['subclasse'],
                                'codigo_limpo' => $atividadeSecundaria['id'],
                                'descricao_cnae' => $atividadeSecundaria['descricao'],
                            ]);
                        }
                    }

                    // Pega os cnaes adicionados do estabelecimento e atualiza os dados chamando a função atualizarDadosBaseCnae
                    $cnaesParaAtualizar = EstabCnae::where('estabelecimento_id', $estabelecimentoId)
                        ->whereNull('grau_cnae')
                        ->get();

                    // Atualiza os dados do CNAE e adiciona as perguntas
                    foreach ($cnaesParaAtualizar as $cnae) {
                        $cnae->atualizarBaseCnae();
                        $cnae->adicionarPerguntas();
                    }

                    // Verifica se existe pelo menos um CNAE NÃO isento
                    $possuiCnaeNaoIsento = Estabelecimento::where('id', $estabelecimentoId)
                        ->whereHas('cnaes', function ($query) {
                            $query->where('grau_cnae', '<>', 'CNAE isento');
                        })
                        ->exists();

                    if ($possuiCnaeNaoIsento) {
                        // Caso 1: Existe pelo menos um CNAE com grau de risco diferente de "CNAE isento"
                        $resultado = 1;
                    } else {
                        // Caso 2: Todos os CNAEs são isentos (ou não tem CNAEs cadastrados)
                        $resultado = 0;
                    }
                    // Atualiza os dados do estabelecimento com as informações do CNAE
                    DB::commit();

                    $estabAtual = Estabelecimento::with('cnaes.perguntas')->findOrFail($estabelecimentoId);

                    return redirect()->route('estabelecimento.show', ['estabelecimento' => $estabAtual, 'resultado' => $resultado]);

                    //dd($resultado);

                    // Caso não tenho atividade principal, algo está errado no cadastro desta empresa
                } else {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Estabelecimento com informações incompletas na Receita Federal!');
                }
                // Caso não tenha sido possível cadastrar o estabelecimento, retorna com a informação
            } catch (RequestException $e) {
                return $this->tratarErroCnpj($e);
            }
        } else {
            return back()->withInput()->with('error', 'API não disponível no momento. Tente mais tarde...');
        }
    }

    public function tratarErroCnpj($e)
    {
        try {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : null;
            $bodyContent = $response ? $response->getBody()->getContents() : null;
            $body = json_decode($bodyContent, true);

            DB::rollBack();

            if ($statusCode === 404) {
                return back()->withInput()->with('error', 'CNPJ não encontrado!');
            } elseif ($statusCode === 429) {
                return back()->withInput()->with('error', 'Limite de requisições atingido! Tente novamente após 1 minuto.');
            } else {
                return back()->withInput()->with('error', 'Erro inesperado. Entre em contato!.');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erro crítico. Contate o suporte.');
        }
    }

    public function show(Estabelecimento $estabelecimento, $resultado)
    {
        return view('externo.show', [
            'estabelecimento' => $estabelecimento,
            'resultado' => $resultado,
            'menu' => 'home',
        ]);
    }

    public function gerarRoteiro(Estabelecimento $estabelecimento, $resultado)
    {
        if ($resultado == 0) {
            return back()->withInput()->with('error', 'Não é possível gerar o roteiro, pois esta empresa não possui atividades econômicas sujeitas a licenciamento.');
        }

        $cnpjLimpo = preg_replace('/[^0-9]/', '', trim($estabelecimento->cnpj));

        $cnpjFormatado = substr($cnpjLimpo, 0, 2) . '_' .
                 substr($cnpjLimpo, 2, 3) . '_' .
                 substr($cnpjLimpo, 5, 3) . '_' .
                 substr($cnpjLimpo, 8, 4) . '_' .
                 substr($cnpjLimpo, 12, 2);

        $namePdf = 'Roteiro_' . $cnpjFormatado . '.pdf';

        $grausDefinidos = $estabelecimento->cnaes()
            ->where('grau_cnae', '!=', 'Depende de informação')
            ->where('grau_cnae', '!=', 'CNAE isento')
            ->get();

        $grausDepende = $estabelecimento->cnaes()
            ->where('grau_cnae', 'Depende de informação')
            ->with('perguntas')
            ->get();

        $data = ['estabelecimento' => $estabelecimento->load('cnaes.perguntas'), 'grausDefinidos' => $grausDefinidos, 'grausDepende' => $grausDepende];

        $pdf = Pdf::loadView('externo.roteiro', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 96,
            'isPhpEnabled' => true,
        ]);

        // Salva o PDF em storage
        $pdf->save(storage_path("app/public/{$namePdf}"));

        // Redireciona para home com a mensagem e nome do PDF
        return redirect()->route('home')->with('success_pdf', 'O roteiro da empresa ' . $estabelecimento->razao_social . ' foi gerado com sucesso! Agora você pode abrir o arquivo baixado, imprimir se desejar ou fazer uma nova consulta informando o CNPJ abaixo.')->with('pdf_file', $namePdf);

        //return $pdf->download($namePdf);
        //return $pdf->stream($namePdf);
    }
}
