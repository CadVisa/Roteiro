@extends('layouts.layout_1')


@section('content')

    @php use Illuminate\Support\Str; @endphp


    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-database me-1"></i>Arquivos gerados</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Pesquisar</span>
                <a href="{{ route('administrador.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="d-none d-sm-inline">Dashboard</span>
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('arquivo.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 mt-3">
                        <label for="nome_pesquisa" class="form-label mb-1">Nome: </label>
                        <input class="form-control" type="text" name="nome_pesquisa" id="nome_pesquisa"
                            placeholder="Nome do arquivo" value="{{ old('nome_pesquisa', $nome_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="data_pesquisa" class="form-label mb-1">Data: </label>
                        <input class="form-control" type="date" name="data_pesquisa" id="data_pesquisa"
                            value="{{ old('data_pesquisa', $data_pesquisa) }}" autocomplete="off">
                    </div>

                    <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="ordenar_por" class="form-label mb-1">Ordenar por:</label>
                        <select class="form-select" name="ordenar_por" id="ordenar_por">
                            <option value="data" {{ old('ordenar_por', $ordenar_por) == 'data' ? 'selected' : '' }}>Data
                            </option>
                            <option value="nome" {{ old('ordenar_por', $ordenar_por) == 'nome' ? 'selected' : '' }}>Nome
                            </option>
                            <option value="tamanho" {{ old('ordenar_por', $ordenar_por) == 'tamanho' ? 'selected' : '' }}>
                                Tamanho</option>
                        </select>
                    </div>

                    <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="ordem" class="form-label mb-1">Ordem:</label>
                        <select class="form-select" name="ordem" id="ordem">
                            <option value="asc" {{ old('ordem', $ordem) == 'asc' ? 'selected' : '' }}>Crescente</option>
                            <option value="desc" {{ old('ordem', $ordem) == 'desc' ? 'selected' : '' }}>Decrescente
                            </option>
                        </select>
                    </div>


                    <div class="col-sm-6 col-md-9 col-lg-3 mt-3 d-flex align-items-end p-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-sm-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('arquivo.index') }}"
                                class="spinner-secondary btn btn-outline-secondary btn-sm">
                                <i class="fa-solid fa-broom"></i><span class="d-none d-sm-inline"> Limpar</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card border-primary bg-warning shadow-sm h-100 rounded-3">

                <div class="card-body px-4 py-3">
                    <div class="d-flex flex-wrap justify-content-between text-center gap-2">

                        <div class="flex-fill" title="Nº de roteiros no servidor">
                            <div class="text-primary">
                                <i class="fa-solid fa-copy"></i>
                                <span class="fw-semibold">{{ $n_arquivos }}</span>
                            </div>
                        </div>

                        <div class="flex-fill" title="Tamanho médio do roteiro">
                            <div class="text-primary">
                                <i class="fa-solid fa-chart-bar"></i>
                                <span class="fw-semibold">{{ $media }}</span>
                            </div>
                        </div>

                        <div class="flex-fill" title="Espaço ocupado no servidor">
                            <div class="text-primary">
                                <i class="fa-solid fa-database"></i>
                                <span class="fw-semibold">{{ $tamanhoTotal }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

                <div
                    class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                    <span>Lista de arquivos gerados</span>

                    <div>
                        <a href="{{ url('administrador/arquivos/gerar_pdf?' . request()->getQueryString()) }}"
                            class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span class="d-none d-sm-inline"> Gerar PDF</span>
                        </a>

                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteLogsModal">
                            <i class="fa-regular fa-trash-can"></i> <span class="d-none d-sm-inline">Excluir arquivos</span>
                        </button>

                    </div>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($paginated->count() == 0)
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum arquivo encontrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Arquivo</th>
                                    <th class="d-none d-md-table-cell">Cadastro</th>
                                    <th class="d-none d-sm-table-cell">Tamanho</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paginated as $arquivo)
                                    <tr>
                                        <td class="text-truncate" style="max-width: 200px;"
                                            title="{{ $arquivo['url'] }}">
                                            <a class="text-decoration-none"
                                                href="{{ route('arquivo.roteiro', ['nome' => $arquivo['nome']]) }}"
                                                target="_blank">
                                                {{ $arquivo['nome'] }}
                                            </a>
                                        </td>

                                        <td class="d-none d-md-table-cell">
                                            <a class="text-decoration-none"
                                                href="{{ route('arquivo.roteiro', ['nome' => $arquivo['url']]) }}"
                                                target="_blank">
                                                {{ $arquivo['data'] }}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="d-none d-sm-table-cell text-decoration-none"
                                                href="{{ route('arquivo.roteiro', ['nome' => $arquivo['url']]) }}"
                                                target="_blank">
                                                {{ $arquivo['tamanho'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-{{ Str::slug($arquivo['nome']) }}-arquivo">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                            {{-- --------- MODAL PARA EXCLUIR UM ARQUIVO --------- --}}
                                            <div class="modal fade"
                                                id="deleteModal-{{ Str::slug($arquivo['nome']) }}-arquivo" tabindex="-1"
                                                aria-labelledby="deleteModalLabel-{{ Str::slug($arquivo['nome']) }}-arquivo"
                                                data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                                                <div
                                                    class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-light bg-danger">
                                                            <h6 class="modal-title"
                                                                id="deleteModalLabel-{{ Str::slug($arquivo['nome']) }}-arquivo">
                                                                Deseja realmente
                                                                excluir este arquivo?
                                                            </h6>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 mb-3">
                                                                    <div class="form-label fw-bold mb-0">Nome:</div>
                                                                    <div class="text-justify">
                                                                        {{ $arquivo['nome'] }}</div>
                                                                </div>

                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <span class="text-center text-danger fw-bold">Essa ação
                                                                        é
                                                                        irreversível!</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST"
                                                                action="{{ route('arquivo.destroyArquivo', ['arquivo' => $arquivo['nome']]) }}">
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $paginated->links() }}
                    @endif
                </div>
            </div>
        </div>

        {{-- MODAL EXCLUIR LOGS --}}
        <div class="modal fade" id="deleteLogsModal" tabindex="-1" aria-labelledby="deleteLogsModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-light bg-danger">
                        <h6 class="modal-title" id="deleteLogsModalLabel">
                            Deseja realmente excluir estes arquivos?
                        </h6>
                    </div>
                    <form method="POST" action="{{ route('arquivo.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="periodoSelect" class="form-label fw-bold">Período:</label>
                                <select class="form-select" id="periodoSelect" name="periodo">
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="7">Com mais de 7 dias</option>
                                    <option value="15">Com mais de 15 dias</option>
                                    <option value="30">Com mais de 30 dias</option>
                                    <option value="90">Com mais de 3 meses</option>
                                    <option value="180">Com mais de 6 meses</option>
                                    <option value="365">Com mais de 12 meses</option>
                                    <option value="all" class="text-danger fw-bold">Excluir todos os arquivos</option>
                                </select>
                            </div>
                            <div class="text-center text-danger fw-bold">
                                Essa ação é irreversível!
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submitDeleteLogs"
                                class="spinner-danger btn btn-sm btn-outline-danger">
                                <i class="fa-regular fa-trash-can"></i> Excluir
                            </button>
                            <button type="button" id="closeModal"
                                class="spinner-secondary btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
