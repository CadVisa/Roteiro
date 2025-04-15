@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-user-secret me-1"></i>Logs do sistema</h4>
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
                <form action="{{ route('log.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mt-3">
                        <label for="descricao_pesquisa" class="form-label mb-1">Descrição: </label>
                        <input class="form-control" type="text" name="descricao_pesquisa" id="descricao_pesquisa"
                            placeholder="Descrição do log" value="{{ old('descricao_pesquisa', $descricao_pesquisa) }}"
                            autocomplete="off">
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

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="nivel_pesquisa" class="form-label mb-1">Nível: </label>
                        <select class="form-control" name="nivel_pesquisa" id="nivel_pesquisa">
                            <option value="" @if (old('nivel_pesquisa', $nivel_pesquisa ?? '') == '') selected @endif>Todos</option>
                            <option value='1' @if ($nivel_pesquisa == 1) selected @endif>Normal</option>
                            <option value='2' @if ($nivel_pesquisa == 2) selected @endif>Importante</option>
                            <option value='3' @if ($nivel_pesquisa == 3) selected @endif>Crítico</option>
                            <option value='4' @if ($nivel_pesquisa == 4) selected @endif>Resolvido</option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="ip_pesquisa" class="form-label mb-1">IP: </label>
                        <select class="form-control" name="ip_pesquisa" id="ip_pesquisa">
                            <option value="" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == '') selected @endif>Todos</option>
                            @foreach ($ips as $ip)
                                <option value="{{ $ip }}" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == $ip) selected @endif>
                                    {{ $ip }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="grupo_pesquisa" class="form-label mb-1">Grupo: </label>
                        <select class="form-control" name="grupo_pesquisa" id="grupo_pesquisa">
                            <option value="" @if (old('grupo_pesquisa', $grupo_pesquisa ?? '') == '') selected @endif>Todos</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo }}" @if (old('grupo_pesquisa', $grupo_pesquisa ?? '') == $grupo) selected @endif>
                                    @if ($grupo == 'pg_consent')
                                        Coockies
                                    @elseif ($grupo == 'pg_contato')
                                        Contatos
                                    @elseif ($grupo == 'pg_inicial')
                                        Página principal
                                    @elseif ($grupo == 'pg_resultado')
                                        Resultado
                                    @elseif ($grupo == 'pg_politica')
                                        Política
                                    @elseif ($grupo == 'pg_termos')
                                        Termos
                                    @elseif ($grupo == 'pg_login')
                                        Login
                                    @elseif ($grupo == 'pg_logout')
                                        Logout
                                    @elseif ($grupo == 'pg_adm')
                                        Administrador
                                    @elseif ($grupo == 'pg_cards')
                                        Cards
                                    @elseif ($grupo == 'pg_cnaes')
                                        CNAEs
                                    @elseif ($grupo == 'pg_configuracoes')
                                        Configurações
                                    @elseif ($grupo == 'pg_contacts')
                                        Painel de contatos
                                    @elseif ($grupo == 'pg_consulta_cnaes')
                                        Consulta CNAEs
                                    @elseif ($grupo == 'pg_logs')
                                        Logs do sistema
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 mt-3 d-flex align-items-end p-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-lg-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('log.index') }}" class="spinner-secondary btn btn-outline-secondary btn-sm">
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
                    <span>Lista de logs do sistema</span>

                    <div>
                        <a href="{{ url('administrador/logs/gerar_pdf?' . request()->getQueryString()) }}"
                            class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span class="d-none d-sm-inline"> Gerar PDF</span>
                        </a>

                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteLogsModal">
                            <i class="fa-regular fa-trash-can"></i> <span class="d-none d-sm-inline">Excluir Logs</span>
                        </button>

                    </div>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($logs->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum log encontrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th class="text-center">Nível</th>
                                    <th class="d-none d-md-table-cell">IP</th>
                                    <th class="d-none d-sm-table-cell">Descrição</th>
                                    <th class="d-none d-lg-table-cell">Grupo</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($logs as $log)
                                    <tr>
                                        <td style="max-width: 140px;">
                                            {{ \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i:s') }}</td>

                                            <td class="text-center">
                                                <form action="{{ route('logs.alterar', ['log' => $log->id]) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="log_nivel" value="{{ $log->log_nivel }}">
                                                    <button type="submit" style="border: none; background: none;">
                                                        @if ($log->log_nivel == 4)
                                                            <i class="fas fa-circle-check text-success" title="Resolvido"></i>
                                                        @elseif ($log->log_nivel == 1)
                                                            <i class="fas fa-circle-info text-primary" title="Normal"></i>
                                                        @elseif ($log->log_nivel == 2)
                                                            <i class="fas fa-exclamation-circle text-warning" title="Importante"></i>
                                                        @elseif ($log->log_nivel == 3)
                                                            <i class="fas fa-triangle-exclamation text-danger" title="Crítico"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                            

                                        <td class="text-truncate d-none d-md-table-cell" style="max-width: 90px;">
                                            {{ $log->log_ip }}</td>
                                        <td class="text-truncate d-none d-sm-table-cell" style="max-width: 150px;">
                                            {{ $log->log_descricao }}</td>
                                        <td class="text-truncate d-none d-lg-table-cell" style="max-width: 60px;">
                                            <span>
                                                @if ($log->log_chave == 'pg_consent')
                                                    Coockies
                                                @elseif ($log->log_chave == 'pg_contato')
                                                    Contatos
                                                @elseif ($log->log_chave == 'pg_inicial')
                                                    Página principal
                                                @elseif ($log->log_chave == 'pg_resultado')
                                                    Resultado
                                                @elseif ($log->log_chave == 'pg_politica')
                                                    Política
                                                @elseif ($log->log_chave == 'pg_termos')
                                                    Termos
                                                @elseif ($log->log_chave == 'pg_login')
                                                    Login
                                                @elseif ($log->log_chave == 'pg_logout')
                                                    Logout
                                                @elseif ($log->log_chave == 'pg_adm')
                                                    Administrador
                                                @elseif ($log->log_chave == 'pg_cards')
                                                    Cards
                                                @elseif ($log->log_chave == 'pg_cnaes')
                                                    CNAEs
                                                @elseif ($log->log_chave == 'pg_configuracoes')
                                                    Configurações
                                                @elseif ($log->log_chave == 'pg_contacts')
                                                    Painel de contatos
                                                @elseif ($log->log_chave == 'pg_consulta_cnaes')
                                                    Consulta CNAEs
                                                @elseif ($log->log_chave == 'pg_logs')
                                                    Logs do sistema
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="spinner-light btn btn-outline-primary btn-sm"><i
                                                    class="fa-regular fa-folder-open"></i><span
                                                    class="d-none d-md-inline">
                                                    Abrir</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $logs->onEachSide(0)->links() }}
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
                            Deseja realmente excluir os logs?
                        </h6>
                    </div>
                    <form method="POST" action="{{ route('logs.destroy') }}">
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
                                    <option value="all" class="text-danger fw-bold">Excluir todos os logs</option>
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
