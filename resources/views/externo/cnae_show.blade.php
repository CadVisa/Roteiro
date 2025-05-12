@extends('layouts.layout_1')

@section('content')

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic">Veja os detalhes da atividade econômica</p>
            <div class="base-cv">Resolução SES/RJ nº 2191 de 02/12/2020</div>
        </div>
    </section>

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-magnifying-glass me-1"></i>Atividades Econômicas</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">

                <span class="me-auto d-none d-sm-block">Detalhes da atividade econômica</span>
                <span class="me-auto d-block d-sm-none">Detalhes</span>

                <div class="d-flex justify-content-between align-items-center gap-2">
                    <span>
                        <a href="{{ route('consulta_cnae.index') }}" class="btn btn-sm btn-outline-light" onclick="mostrarPreload()">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Voltar</span>
                        </a>
                    </span>
                </div>
            </div>

            <div class="card-body">

                <x-alert />

                <div class="row">
                    <div class="col-sm-6 col-md-8 col-xl-9 mb-3">
                        <span class="fw-bold">Código:</span><span> {{ $cnae->codigo_cnae }}</span>
                    </div>

                    @isset($revisao)
                        <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                            <span class="fw-bold">Revisado em:</span><span> {{ \Carbon\Carbon::parse($revisao->data_movimento)->format('d/m/Y') }}</span>
                        </div>
                    @endisset

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Descrição:</span><span> {{ $cnae->descricao_cnae }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <span class="fw-bold">Grau de risco: </span><span
                            class="badge rounded-pill 
                                                @if ($cnae->grau_cnae == 'CNAE isento') bg-secondary
                                                @elseif($cnae->grau_cnae == 'Depende de informação')
                                                    bg-primary
                                                @elseif($cnae->grau_cnae == 'Alto risco')
                                                    bg-danger
                                                @elseif($cnae->grau_cnae == 'Médio risco')
                                                    bg-warning text-dark
                                                @elseif($cnae->grau_cnae == 'Baixo risco')
                                                    bg-success
                                                @else
                                                    bg-light text-dark @endif">
                            @if ($cnae->grau_cnae == 'CNAE isento')
                                Isento de licenciamento
                            @else
                                {{ $cnae->grau_cnae }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">Notas explicativas</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="d-flex flex-column flex-row">
                            <span class="fw-bold mb-1 mb-md-0">Compreende:</span>
                            <div class="text-justify" style="text-align: justify; text-justify: inter-word;">
                                @if ($cnae->notas_s_compreende == 'NI')
                                    Sem informação
                                @else
                                    {!! nl2br($cnae->notas_s_compreende) !!}
                                @endif


                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="d-flex flex-column flex-row">
                            <span class="fw-bold mb-1 mb-md-0">Não compreende:</span>
                            <div class="text-justify" style="text-align: justify; text-justify: inter-word;">
                                @if ($cnae->notas_n_compreende == 'NI')
                                    Sem informação
                                @else
                                    {!! nl2br($cnae->notas_n_compreende) !!}
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($perguntas->count() > 0)
            <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">
                <div
                    class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                    <span class="me-auto">Perguntas</span>
                </div>

                <div class="card-body">
                    @if ($perguntas->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th class="text-center">Sim</th>
                                    <th class="text-center">Não</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perguntas as $pergunta)
                                    <tr>
                                        <td>{{ $pergunta->pergunta }}</td>
                                        <td class="text-center" style="max-width: 100px;">
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
                                        <td class="text-center" style="max-width: 100px;">
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
                    @else
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-center text-muted fst-italic">Esta atividade não depende de informação</span>
                        </div>
                    @endif
                    {{ $perguntas->onEachSide(0)->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
