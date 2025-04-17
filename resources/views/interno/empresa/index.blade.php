@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-building me-1"></i>Empresas</h4>
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
                <form action="{{ route('empresa.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4 mt-3">
                        <label for="razao_pesquisa" class="form-label mb-1">Razão social: </label>
                        <input class="form-control" type="text" name="razao_pesquisa" id="razao_pesquisa"
                            placeholder="Razão social ou fantasia" value="{{ old('razao_pesquisa', $razao_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4 mt-3">
                        <label for="cnpj_pesquisa" class="form-label mb-1">CNPJ: </label>
                        <input class="form-control" type="text" name="cnpj_pesquisa" id="cnpj_pesquisa"
                            placeholder="CNPJ da empresa" value="{{ old('cnpj_pesquisa', $cnpj_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2 mt-3">
                        <label for="ip_pesquisa" class="form-label mb-1">IP: </label>
                        <select class="form-control" name="ip_pesquisa" id="ip_pesquisa">
                            <option value="" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == '') selected @endif>Todos</option>
                            @foreach ($ips as $ip)
                                <option value="{{ $ip }}" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == $ip) selected @endif>
                                    {{ $ip }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2 mt-3">
                        <label for="cidade_pesquisa" class="form-label mb-1">Cidade: </label>
                        <select class="form-control" name="cidade_pesquisa" id="cidade_pesquisa">
                            <option value="" @if (old('cidade_pesquisa', $cidade_pesquisa ?? '') == '') selected @endif>Todas</option>
                            @foreach ($cidades as $cidade)
                                <option value="{{ $cidade }}" @if (old('cidade_pesquisa', $cidade_pesquisa ?? '') == $cidade) selected @endif>
                                    {{ $cidade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="estado_pesquisa" class="form-label mb-1">Estado: </label>
                        <select class="form-control" name="estado_pesquisa" id="estado_pesquisa">
                            <option value="" @if (old('estado_pesquisa', $estado_pesquisa ?? '') == '') selected @endif>Todos</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado }}" @if (old('estado_pesquisa', $estado_pesquisa ?? '') == $estado) selected @endif>
                                    {{ $estado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-4 col-xl-2 mt-3">
                        <label for="roteiro_pesquisa" class="form-label mb-1">Situação: </label>
                        <select class="form-control" name="roteiro_pesquisa" id="roteiro_pesquisa">
                            <option value="" @if (old('roteiro_pesquisa', $roteiro_pesquisa ?? '') == '') selected @endif>Todas</option>
                            <option value="1" @if ($roteiro_pesquisa == '1') selected @endif>Com roteiro</option>
                            <option value="2" @if ($roteiro_pesquisa == '2') selected @endif>Sem roteiro</option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="data_inicio" class="form-label mb-1">Início: </label>
                        <input class="form-control" type="datetime-local" name="data_inicio" id="data_inicio"
                            value="{{ old('data_inicio', $data_inicio) }}" autocomplete="off">
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="data_fim" class="form-label mb-1">Fim: </label>
                        <input class="form-control" type="datetime-local" name="data_fim" id="data_fim"
                            value="{{ old('data_fim', $data_fim) }}" autocomplete="off">
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 mt-3 d-flex align-items-end p-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-lg-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('empresa.index') }}"
                                class="spinner-secondary btn btn-outline-secondary btn-sm">
                                <i class="fa-solid fa-broom"></i><span class="d-none d-lg-inline"> Limpar</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">

            <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

                <div
                    class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                    <span>Lista de empresas</span>

                    <div>
                        <a href="{{ url('administrador/empresas/gerar_pdf?' . request()->getQueryString()) }}"
                            class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span class="d-none d-sm-inline"> Gerar PDF</span>
                        </a>

                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteLogsModal">
                            <i class="fa-regular fa-trash-can"></i> <span class="d-none d-sm-inline">Excluir empresas</span>
                        </button>

                    </div>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($empresas->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum empresa encontrada!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Cadastro</th>
                                    <th class="d-none d-sm-table-cell">Razão social</th>
                                    <th>CNPJ</th>
                                    <th class="d-none d-md-table-cell">Cidade</th>
                                    <th class="d-none d-lg-table-cell">Estado</th>
                                    <th class="d-none d-lg-table-cell">IP</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($empresas as $empresa)
                                    <tr>
                                        <td class="text-truncate" style="max-width: 120px;">
                                            {{ \Carbon\Carbon::parse($empresa->criado_em)->format('d/m/Y H:i') }}</td>
                                        <td class="text-truncate d-none d-sm-table-cell" style="max-width: 180px;">{{ $empresa->razao_social }}</td>
                                        <td class="text-truncate" style="max-width: 120px;">{{ $empresa->cnpj }}</td>
                                        <td class="text-truncate d-none d-md-table-cell" style="max-width: 100px;">{{ $empresa->cidade }}</td>
                                        <td class="d-none d-lg-table-cell">{{ $empresa->estado }}</td>
                                        <td class="text-truncate d-none d-lg-table-cell" style="max-width: 90px;">{{ $empresa->criado_por }}</td>
                                        
                                        <td class="text-end">
                                            <a href="{{ route('empresa.show', $empresa->id) }}" class="spinner-light btn btn-outline-primary btn-sm"><i
                                                    class="fa-regular fa-folder-open"></i><span
                                                    class="d-none d-md-inline">
                                                    Abrir</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $empresas->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>


        {{-- MODAL EXCLUIR EMPRESAS --}}
        <div class="modal fade" id="deleteLogsModal" tabindex="-1" aria-labelledby="deleteLogsModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-light bg-danger">
                        <h6 class="modal-title" id="deleteLogsModalLabel">
                            Deseja realmente excluir as empresas?
                        </h6>
                    </div>
                    <form method="POST" action="{{ route('empresa.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="periodoSelect" class="form-label fw-bold">Período:</label>
                                <select class="form-select" id="periodoSelect" name="periodo">
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="15">Com mais de 15 dias</option>
                                    <option value="30">Com mais de 30 dias</option>
                                    <option value="90">Com mais de 3 meses</option>
                                    <option value="180">Com mais de 6 meses</option>
                                    <option value="365">Com mais de 12 meses</option>
                                    <option value="all" class="text-danger fw-bold">Excluir todas as empresas</option>
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
