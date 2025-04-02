@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-brands fa-creative-commons-share me-1"></i>Atividades Econômicas</h4>
        </div>

        <div class="card border-primary mb-3 mt-3 border-ligth shadow col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">

                <span class="me-auto">Detalhes da atividade econômica</span>

                <div class="d-flex align-items-center gap-2">
                    <span>
                        <a href="{{ route('cnae.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="d-none d-sm-inline">Voltar</span>
                        </a>
                    </span>

                    <span>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i>
                                <span class="d-none d-sm-inline">Menu</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('cnae.edit', ['cnae' => $cnae->id]) }}">
                                        <i class="fa-regular fa-pen-to-square"></i> Editar
                                    </a></li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal-{{ $cnae->id }}">
                                        <i class="fa-regular fa-trash-can"></i> Excluir
                                    </a></li>
                            </ul>
                        </div>
                    </span>
                </div>
            </div>

            <div class="card-body">

                <x-alert />

                <div class="row">
                    <div class="col-12 mb-3">
                        <span class="fw-bold">Código:</span><span> {{ $cnae->codigo_cnae }}</span>
                    </div>
                    <div class="col-12 mb-3">
                        <span class="fw-bold">Descrição:</span><span> {{ $cnae->descricao_cnae }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <span class="fw-bold">Competência:
                            <span
                                class="badge rounded-pill 
                                                @if ($cnae->competencia == 'CNAE isento') bg-secondary 
                                                @elseif($cnae->competencia == 'Municipal')
                                                    bg-success
                                                @elseif($cnae->competencia == 'Estadual')
                                                    bg-danger
                                                @elseif($cnae->competencia == 'Depende de informação')
                                                    bg-primary
                                                @else
                                                    bg-light text-dark @endif">
                                @if ($cnae->competencia == 'CNAE isento')
                                    Isento
                                @else
                                    {{ $cnae->competencia }}
                                @endif

                            </span>
                        </span>
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
                                Isento
                            @else
                                {{ $cnae->grau_cnae }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary mb-3 mt-3 border-ligth shadow col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">Notas explicativas</span>
                <a href="{{ route('cnae.edit-notas', ['cnae' => $cnae->id]) }}"
                    class="spinner-light btn btn-outline-light btn-sm"><i class="fa-regular fa-pen-to-square"></i><span
                        class="d-none d-sm-inline">
                        Editar</span></a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="d-flex flex-column flex-row">
                            <span class="fw-bold mb-1 mb-md-0">Compreende:</span>
                            <div class="text-justify" style="text-align: justify; text-justify: inter-word;">
                                {!! nl2br($cnae->notas_s_compreende) !!}</div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="d-flex flex-column flex-row">
                            <span class="fw-bold mb-1 mb-md-0">Não compreende:</span>
                            <div class="text-justify" style="text-align: justify; text-justify: inter-word;">
                                {!! nl2br($cnae->notas_n_compreende) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary mb-3 mt-3 border-ligth shadow col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">Perguntas</span>
                <div>
                    <a href="{{ route('cnae.create-question', ['cnae' => $cnae->id]) }}"
                        class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-plus"></i>
                        <span class="d-none d-sm-inline"> Adicionar</span>
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($perguntas->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th class="d-none d-md-table-cell text-center">Competência</th>
                                <th class="text-center">Sim</th>
                                <th class="text-center">Não</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perguntas as $pergunta)
                                <tr>
                                    <td>{{ $pergunta->pergunta }}</td>
                                    <td class="text-truncate d-none d-md-table-cell text-center" style="max-width: 100px;">
                                        <span
                                            class="badge rounded-pill 
                                            @if ($pergunta->competencia == 'CNAE isento') @elseif($pergunta->competencia == 'Municipal')
                                                bg-success
                                            @elseif($pergunta->competencia == 'Estadual')
                                                bg-danger
                                            @elseif($pergunta->competencia == 'Depende de informação')
                                                bg-primary
                                            @else
                                                bg-light text-dark @endif">

                                            @if ($pergunta->competencia == 'CNAE isento')
                                            @elseif ($pergunta->competencia == 'Municipal')
                                                MUN
                                            @elseif ($pergunta->competencia == 'Estadual')
                                                EST
                                            @elseif ($pergunta->competencia == 'Depende de informação')
                                                DI
                                            @else
                                                {{ $pergunta->competencia }}
                                            @endif
                                        </span>
                                    </td>
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
                                    <td class="text-end">

                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-gear"></i>
                                                <span class="d-none d-sm-inline">Menu</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('cnae.edit-question', $pergunta->id) }}">
                                                        <i class="fa-regular fa-pen-to-square"></i> Editar
                                                    </a></li>
                                                <li><a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-{{ $pergunta->id }}-pergunta">
                                                        <i class="fa-regular fa-trash-can"></i> Excluir
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                {{-- --------- MODAL PARA EXCLUIR UMA PERGUNTA --------- --}}
                                <div class="modal fade" id="deleteModal-{{ $pergunta->id }}-pergunta" tabindex="-1"
                                    aria-labelledby="deleteModalLabel-{{ $pergunta->id }}-pergunta"
                                    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header text-light bg-danger">
                                                <h6 class="modal-title"
                                                    id="deleteModalLabel-{{ $pergunta->id }}-pergunta">Deseja realmente
                                                    excluir esta pergunta?
                                                </h6>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6 mb-3">
                                                        <div class="form-label fw-bold mb-0">Código:</div>
                                                        <div class="text-justify">{{ $pergunta->cnae->codigo_cnae }}</div>
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-label fw-bold mb-0">Descrição:</div>
                                                        <div class="text-justify">{{ $pergunta->cnae->descricao_cnae }}
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-label fw-bold mb-0">Pergunta:</div>
                                                        <div class="text-justify" style="text-align: justify; text-justify: inter-word;">{!! nl2br($pergunta->pergunta) !!}
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <span class="text-center text-danger fw-bold">Essa ação é
                                                            irreversível!</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="{{ route('cnae.destroy-question', ['pergunta' => $pergunta->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="spinner-danger btn btn-sm btn-outline-danger"><i
                                                            class="fa-regular fa-trash-can"></i>
                                                        Excluir</button>
                                                </form>
                                                <button type="button" id="closeModal"
                                                    class="spinner-secondary btn btn-sm btn-outline-secondary"
                                                    data-bs-dismiss="modal"> <i class="fa-solid fa-xmark"></i>
                                                    Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="text-center text-muted fst-italic">Nenhuma pergunta cadastrada</span>
                    </div>
                @endif
                {{ $perguntas->onEachSide(0)->links() }}
            </div>
        </div>
    </div>


    {{-- MODAL EXCLUIR CNAE --}}
    <div class="modal fade" id="deleteModal-{{ $cnae->id }}" tabindex="-1"
        aria-labelledby="deleteModalLabel-{{ $cnae->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-light bg-danger">
                    <h6 class="modal-title" id="deleteModalLabel-{{ $cnae->id }}">Deseja realmente excluir esta
                        atividade econômica?
                    </h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-label fw-bold mb-0">Código:</div>
                            <div class="text-justify">{{ $cnae->codigo_cnae }}</div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">Descrição:</div>
                            <div class="text-justify">{{ $cnae->descricao_cnae }}</div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-center text-danger fw-bold">Essa ação é irreversível!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('cnae.destroy', ['cnae' => $cnae->id]) }}">
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
