@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-user-secret me-1"></i>Auditoria</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">

                <span class="me-auto">Detalhes do log</span>

                <div class="d-flex align-items-center gap-2">
                    <span>
                        <a href="{{ route('log.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="d-none d-sm-inline">Voltar</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-light" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $log->id }}">
                            <i class="fa-regular fa-trash-can"></i>
                            <span class="d-none d-sm-inline">Excluir</span>
                        </a>
                    </span>
                </div>
            </div>

            <div class="card-body">

                <x-alert />

                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <span class="fw-bold">Data:</span><span> {{ \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i:s') }}</span>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <span class="fw-bold">ID:</span><span> {{ $log->id }}</span>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <span class="fw-bold">Nível:</span>
                        <a href="{{ route('logs.alterar', ['log' => $log->id]) }}" class="text-decoration-none">
                            @if ($log->log_nivel == 4)
                                <i class="fas fa-circle-check text-success me-1" title="Resolvido"></i><span class="text-success">Resolvido</span>
                            @elseif ($log->log_nivel == 1)
                                <i class="fas fa-circle-info text-primary me-1" title="Normal"></i><span class="text-primary">Normal</span>
                            @elseif ($log->log_nivel == 2)
                                <i class="fas fa-exclamation-circle text-warning me-1"
                                    title="Importante"></i></i><span class="text-warning">Importante</span>
                            @elseif ($log->log_nivel == 3)
                                <i class="fas fa-triangle-exclamation text-danger me-1"
                                    title="Crítico"></i></i><span class="text-danger">Crítico</span>
                            @endif
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <span class="fw-bold">Usuário:</span><span> {{ $log->user->name ?? 'Visitante' }}</span>
                    </div>
                    
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <span class="fw-bold">IP:</span><span> {{ $log->log_ip }}</span>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <span class="fw-bold">Grupo:</span><span>
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
                            @elseif ($log->log_chave == 'pg_empresas')
                                Página de empresas
                            @elseif ($log->log_chave == 'pg_arquivos')
                                Página de arquivos
                            @elseif ($log->log_chave == 'pg_cookies')
                                Página de coockies
                            @elseif ($log->log_chave == 'pg_acessos')
                                Página de acessos
                            @endif
                        </span>
                    </div>

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Descrição:</span><span> {{ $log->log_descricao }}</span>
                    </div>

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Observações:</span><span> {{ $log->log_observacoes }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL EXCLUIR LOG --}}
    <div class="modal fade" id="deleteModal-{{ $log->id }}" tabindex="-1"
        aria-labelledby="deleteModalLabel-{{ $log->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-light bg-danger">
                    <h6 class="modal-title" id="deleteModalLabel-{{ $log->id }}">Deseja realmente excluir este log?
                    </h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">Data:</div>
                            <div class="text-justify">{{ \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i:s') }}</div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <span class="fw-bold">Nível:</span>
                            <a href="{{ route('logs.alterar', ['log' => $log->id]) }}" class="text-decoration-none">
                                @if ($log->log_nivel == 4)
                                    <i class="fas fa-circle-check text-success me-1" title="Resolvido"></i><span class="text-success">Resolvido</span>
                                @elseif ($log->log_nivel == 1)
                                    <i class="fas fa-circle-info text-primary me-1" title="Normal"></i><span class="text-primary">Normal</span>
                                @elseif ($log->log_nivel == 2)
                                    <i class="fas fa-exclamation-circle text-warning me-1"
                                        title="Importante"></i></i><span class="text-warning">Importante</span>
                                @elseif ($log->log_nivel == 3)
                                    <i class="fas fa-triangle-exclamation text-danger me-1"
                                        title="Crítico"></i></i><span class="text-danger">Crítico</span>
                                @endif
                            </a>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">Descrição:</div>
                            <div class="text-justify">{{ $log->log_descricao }}</div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-label fw-bold mb-0">Observações:</div>
                            <div class="text-justify">{{ $log->log_observacoes }}</div>
                        </div>

                        

                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-center text-danger fw-bold">Essa ação é irreversível!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('logs.destroyLog', ['log' => $log->id]) }}">
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
