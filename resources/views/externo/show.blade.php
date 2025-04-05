@extends('layouts.layout_1')

@section('content')
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic @if ($resultado == 0) text-warning @endif">
                @if ($resultado == 0)
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Atenção! Esta empresa não possui atividades
                    econômicas sujeitas a licenciamento<i class="fa-solid fa-triangle-exclamation ms-2"></i>
                @else
                    <i class="text-warning fa-solid fa-face-smile-wink me-2"></i>Pronto! Agora é só conferir o resultado e
                    clicar em gerar roteiro<i class="text-warning fa-solid fa-face-smile-wink ms-2"></i>
                @endif
            </p>
            <div class="base-cv">Resolução SES/RJ nº 2191 de 02/12/2020</div>
        </div>
    </section>

    <x-alert />

    @if ($resultado == 0)
        <div class="alert alert-warning p-2 lh-sm text-justify text-muted" role="alert">
            A consulta indicou que esta empresa não possui atividades econômicas sujeitas a licenciamento sanitário, conforme a
            Resolução SES/RJ nº 2191, de 02/12/2020.
            A última atualização dos dados desta empresa ocorreu em
            {{ \Carbon\Carbon::parse($estabelecimento->atualizado_em)->format('d/m/Y') }}.
            Caso tenha ocorrido alguma alteração após essa data, será necessário aguardar a próxima atualização do banco
            de dados.
            Para consultar o CNPJ diretamente no site da Receita Federal, clique <a
                href="https://solucoes.receita.fazenda.gov.br/servicos/cnpjreva/cnpjreva_solicitacao.asp" target="_blank"
                class="text-decoration-none">aqui</a>.
        </div>
    @endif

    <div class="d-flex justify-content-center align-items-center">
        <div>
            @if ($resultado != 0)
                <a href="{{ route('estabelecimento.gerarRoteiro', ['estabelecimento' => $estabelecimento->id, 'resultado' => $resultado]) }}" class="btn btn-sm btn-success spinner-light-cv">
                    <i class="fa-solid fa-file-pdf me-2"></i>Gerar roteiro
                </a>
            @endif
            <a href="{{ route('home') }}" class="btn btn-sm btn-warning spinner-warning-cv">
                <i class="fas fa-search me-2"></i>Nova consulta
            </a>
        </div>
    </div>

    <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

        <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
            <span class="me-auto">Informações da empresa</span>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-sm-12 col-md-8 mb-1">
                    <span class="fw-medium">Razão social: </span><span>
                        {{ ucwords(strtolower($estabelecimento->razao_social)) }}</span>
                </div>

                <div class="col-sm-12 col-md-4 mb-1">
                    <span class="fw-medium">CNPJ: </span><span> {{ ucwords(strtolower($estabelecimento->cnpj)) }}</span>
                </div>

                <div class="col-sm-12 col-md-8 mb-1">
                    <span class="fw-medium">Nome fantasia:</span><span>
                        {{ ucwords(strtolower($estabelecimento->nome_fantasia)) }}</span>
                </div>

                <div class="col-sm-12 col-md-4 mb-1">
                    <span class="fw-medium">Atualizado em: </span><span>
                        {{ ucwords(strtolower(\Carbon\Carbon::parse($estabelecimento->atualizado_em)->format('d/m/Y'))) }}</span>
                </div>

                <div class="col-12 mb-1">
                    <span class="fw-medium">Endereço:</span><span>
                        {{ ucwords(strtolower($estabelecimento->logradouro)) . ', nº ' . ucwords(strtolower($estabelecimento->numero)) . '' . ($estabelecimento->complemento ? ' - ' . ucwords(strtolower($estabelecimento->complemento)) : '') }}</span>
                </div>

                <div class="col-sm-12 col-md-8 mb-1">
                    <span class="fw-medium">Bairro: </span><span> {{ ucwords(strtolower($estabelecimento->bairro)) }}</span>
                </div>

                <div class="col-sm-12 col-md-4 mb-1">
                    <span class="fw-medium">CEP: </span><span> {{ ucwords(strtolower($estabelecimento->cep)) }}</span>
                </div>

                <div class="col-sm-12 col-md-8 mb-1">
                    <span class="fw-medium">Cidade:</span><span> {{ ucwords(strtolower($estabelecimento->cidade)) }}</span>
                </div>

                <div class="col-sm-12 col-md-4 mb-1">
                    <span class="fw-medium">Estado: </span><span> {{ strtoupper($estabelecimento->estado) }}</span>
                </div>

                <div class="col-sm-12 col-md-8 mb-1">
                    <span class="fw-medium">Telefone(s): </span><span>
                        {{ ucwords(strtolower($estabelecimento->telefone_1)) . ($estabelecimento->telefone_2 ? ' / ' . ucwords(strtolower($estabelecimento->telefone_2)) : '') }}</span>
                </div>

                <div class="col-sm-12 col-md-4 mb-1">
                    <span class="fw-medium">E-mail: </span><span> {{ $estabelecimento->email }}</span>
                </div>

            </div>

            <div class="row">

                <div class="col-sm-12 col-md-8 mb-2 mt-3">
                    <span class="fw-medium"><i class="fa-solid fa-bars me-2"></i>Atividade(s) econômica(s)</span>
                </div>

                <div class="accordion mb-3" id="accordionMaisCampos">
                    @foreach ($estabelecimento->cnaes->sortBy('codigo_limpo') as $cnae)
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="headingMaisCampos-{{ $cnae->id }}">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseMaisCampos-{{ $cnae->id }}"
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="collapseMaisCampos-{{ $cnae->id }}">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ $cnae->codigo_cnae . ' - ' . $cnae->descricao_cnae }}
                                        </div>

                                        @php
                                            $grau = $cnae->grau_cnae;
                                            $sigla = match ($grau) {
                                                'CNAE isento' => 'IS',
                                                'Depende de informação' => 'DI',
                                                'Alto risco' => 'AR',
                                                'Médio risco' => 'MR',
                                                'Baixo risco' => 'BR',
                                                default => $grau,
                                            };
                                        @endphp

                                        <div class="ms-3 me-4 text-end">
                                            <span
                                                class="badge rounded-pill badge-fixed-md
        @if ($grau == 'CNAE isento') bg-secondary
        @elseif($grau == 'Depende de informação') bg-primary
        @elseif($grau == 'Alto risco') bg-danger
        @elseif($grau == 'Médio risco') bg-warning text-dark
        @elseif($grau == 'Baixo risco') bg-success
        @else bg-light text-dark @endif"
                                                title="{{ $grau }}">

                                                <span class="d-md-none">{{ $sigla }}</span>
                                                <span class="d-none d-md-inline">
                                                    @if ($grau == 'CNAE isento')
                                                        Isento
                                                    @else
                                                        {{ $grau }}
                                                    @endif
                                                </span>
                                            </span>
                                        </div>

                                    </div>

                                </button>
                            </h4>
                            <div id="collapseMaisCampos-{{ $cnae->id }}"
                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                aria-labelledby="headingMaisCampos-{{ $cnae->id }}"
                                data-bs-parent="#accordionMaisCampos">
                                <div class="accordion-body row">
                                    <div class="text-center fw-medium mb-2">Notas explicativas</div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mb-3 small">
                                            <div class="text-center fw-medium mb-1">Compreende:</div>
                                            @if ($cnae->notas_s_compreende == 'NI')
                                                <div class="text-center text-muted">Sem informação</div>
                                            @else
                                                <div class="text-justify">
                                                    {{ $cnae->notas_s_compreende }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-sm-12 col-md-6 mb-3 small border-left-sm ps-sm-3">
                                            <div class="text-center fw-medium mb-1">Não compreende:</div>
                                            @if ($cnae->notas_n_compreende == 'NI')
                                                <div class="text-center text-muted">Sem informação</div>
                                            @else
                                                <div class="text-justify">
                                                    {{ $cnae->notas_n_compreende }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    @if ($cnae->perguntas->count() > 0)
                                        <hr>
                                        <div class="text-center fw-medium mb-2">Pergunta(s)</div>

                                        <table class="table table-hover small tabela-azul-claro">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center">Sim</th>
                                                    <th class="text-center">Não</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cnae->perguntas as $pergunta)
                                                    <tr>
                                                        <td class="text-justify">{{ $pergunta->pergunta }}</td>
                                                        <td class="text-center" style="max-width: 100px;"
                                                            title="{{ $pergunta->grau_sim }}">
                                                            <span
                                                                class="badge rounded-pill 
                                                            @if ($pergunta->grau_sim == 'Alto risco') bg-danger
                                                            @elseif($pergunta->grau_sim == 'Médio risco')
                                                                bg-warning text-dark
                                                            @elseif($pergunta->grau_sim == 'Baixo risco')
                                                                bg-success
                                                            @else
                                                                bg-light text-dark @endif">
                                                                @if ($pergunta->grau_sim == 'Alto risco')
                                                                    AR
                                                                @elseif ($pergunta->grau_sim == 'Médio risco')
                                                                    MR
                                                                @elseif ($pergunta->grau_sim == 'Baixo risco')
                                                                    BR
                                                                @else
                                                                    {{ $pergunta->grau_sim }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="text-center" style="max-width: 100px;"
                                                            title="{{ $pergunta->grau_nao }}">
                                                            <span
                                                                class="badge rounded-pill 
                                                            @if ($pergunta->grau_nao == 'Alto risco') bg-danger
                                                            @elseif($pergunta->grau_nao == 'Médio risco')
                                                                bg-warning text-dark
                                                            @elseif($pergunta->grau_nao == 'Baixo risco')
                                                                bg-success
                                                            @else
                                                                bg-light text-dark @endif">
                                                                @if ($pergunta->grau_nao == 'Alto risco')
                                                                    AR
                                                                @elseif ($pergunta->grau_nao == 'Médio risco')
                                                                    MR
                                                                @elseif ($pergunta->grau_nao == 'Baixo risco')
                                                                    BR
                                                                @else
                                                                    {{ $pergunta->grau_nao }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
