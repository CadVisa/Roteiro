@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-eye me-1"></i>Acessos únicos</h4>
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
                <form action="{{ route('acesso.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 mt-3">
                        <label for="data_pesquisa" class="form-label mb-1">Fim: </label>
                        <input class="form-control" type="date" name="data_pesquisa" id="data_pesquisa"
                            value="{{ old('data_pesquisa', $data_pesquisa) }}" autocomplete="off">
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

                    <div class="col-sm-6 col-md-3 col-lg-3 mt-3 d-flex align-items-end p-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-lg-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('acesso.index') }}" class="spinner-secondary btn btn-outline-secondary btn-sm">
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
                    <span>Lista de acessos únicos</span>

                    {{-- <div>
                        <a href="{{ url('administrador/logs/gerar_pdf?' . request()->getQueryString()) }}"
                            class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span class="d-none d-sm-inline"> Gerar PDF</span>
                        </a>

                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteLogsModal">
                            <i class="fa-regular fa-trash-can"></i> <span class="d-none d-sm-inline">Excluir Logs</span>
                        </button>

                    </div> --}}
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($acessos->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum acesso encontrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($acessos as $acesso)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($acesso->data)->format('d/m/Y') }}</td>

                                        <td class="text-truncate" style="max-width: 170px;">
                                            {{ $acesso->ip }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $acessos->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>


        {{-- MODAL EXCLUIR LOGS --}}
        {{-- <div class="modal fade" id="deleteLogsModal" tabindex="-1" aria-labelledby="deleteLogsModalLabel"
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
        </div> --}}
    </div>
@endsection
