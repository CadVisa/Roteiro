@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-building me-1"></i>Empresas</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">

                <span class="me-auto">Detalhes da empresa</span>

                <div class="d-flex align-items-center gap-2">
                    <span>
                        <a href="{{ route('empresa.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="d-none d-sm-inline">Voltar</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-light" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $estabelecimento->id }}">
                            <i class="fa-regular fa-trash-can"></i>
                            <span class="d-none d-sm-inline">Excluir</span>
                        </a>
                    </span>
                </div>
            </div>

            <div class="card-body">

                <x-alert />

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
                        <span class="fw-medium">Bairro: </span><span>
                            {{ ucwords(strtolower($estabelecimento->bairro)) }}</span>
                    </div>

                    <div class="col-sm-12 col-md-4 mb-1">
                        <span class="fw-medium">CEP: </span><span> {{ ucwords(strtolower($estabelecimento->cep)) }}</span>
                    </div>

                    <div class="col-sm-12 col-md-8 mb-1">
                        <span class="fw-medium">Cidade:</span><span>
                            {{ ucwords(strtolower($estabelecimento->cidade)) }}</span>
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

                    <div class="col-sm-12 col-md-8 mb-1">
                        <span class="fw-medium">IP: </span><span>
                            {{ $estabelecimento->criado_por }}</span>
                    </div>

                    <div class="col-sm-12 col-md-4 mb-1">
                        <span class="fw-medium">Cadastro: </span><span>
                            {{ ucwords(strtolower(\Carbon\Carbon::parse($estabelecimento->criado_em)->format('d/m/Y'))) }}</span>
                    </div>

                    <div class="col-sm-12 col-md-8 mb-1">
                        <span class="fw-medium">ID: </span><span>
                            {{ $estabelecimento->id }}</span>
                    </div>

                    @php
                        $arquivo = $estabelecimento->path_roteiro;

                        $caminhoRelativo = $arquivo ? 'roteiros/' . ltrim($arquivo, '/') : null;

                        $caminhoAbsoluto = $caminhoRelativo ? public_path($caminhoRelativo) : null;

                        $arquivoExiste = $caminhoAbsoluto && file_exists($caminhoAbsoluto);
                    @endphp

                    <div class="col-sm-12 col-md-4 mb-1">
                        <span class="fw-medium">Roteiro: </span>
                        <span>
                            @if ($arquivoExiste)
                            <a class="text-decoration-none" href="{{ route('baixar.roteiro', ['nome' => $arquivo]) }}">
                                Baixar
                            </a>
                            @else
                                Não encontrado
                            @endif
                        </span>
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
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMaisCampos-{{ $cnae->id }}" aria-expanded="false"
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
                                <div id="collapseMaisCampos-{{ $cnae->id }}" class="accordion-collapse collapse"
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
    </div>


    {{-- MODAL EXCLUIR EMPRESA --}}
    <div class="modal fade" id="deleteModal-{{ $estabelecimento->id }}" tabindex="-1"
        aria-labelledby="deleteModalLabel-{{ $estabelecimento->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-light bg-danger">
                    <h6 class="modal-title" id="deleteModalLabel-{{ $estabelecimento->id }}">Deseja realmente excluir
                        esta
                        empresa?
                    </h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 col-sm-6 mb-3">
                            <div class="form-label fw-bold mb-0">Data:</div>
                            <div class="text-justify">
                                {{ \Carbon\Carbon::parse($estabelecimento->criado_em)->format('d/m/Y H:i:s') }}</div>
                        </div>

                        <div class="col-4 col-sm-6 mb-3">
                            <div class="form-label fw-bold mb-0">ID:</div>
                            <div class="text-justify">
                                {{ $estabelecimento->id }}</div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">IP:</div>
                            <div class="text-justify">{{ $estabelecimento->criado_por }}</div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">Razão social:</div>
                            <div class="text-justify">{{ $estabelecimento->razao_social }}</div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">CNPJ:</div>
                            <div class="text-justify">{{ $estabelecimento->cnpj }}</div>
                        </div>

                        <div class="col-8 col-sm-6 mb-3">
                            <div class="form-label fw-bold mb-0">Cidade:</div>
                            <div class="text-justify">{{ $estabelecimento->cidade }}</div>
                        </div>

                        <div class="col-4 col-sm-6 mb-3">
                            <div class="form-label fw-bold mb-0">UF:</div>
                            <div class="text-justify">{{ $estabelecimento->estado }}</div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-center text-danger fw-bold">Essa ação é irreversível!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST"
                        action="{{ route('empresa.destroyEmpresa', ['estabelecimento' => $estabelecimento->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="spinner-danger btn btn-sm btn-outline-danger"><i
                                class="fa-regular fa-trash-can"></i>
                            Excluir</button>
                    </form>
                    <button type="button" id="closeModal" class="spinner-secondary btn btn-sm btn-outline-secondary"
                        data-bs-dismiss="modal"> <i class="fa-solid fa-xmark"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
