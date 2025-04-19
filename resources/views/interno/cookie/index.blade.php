@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-cookie-bite me-1"></i>Cookies</h4>
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
                <form action="{{ route('cookie.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 mt-3">
                        <label for="ip_pesquisa" class="form-label mb-1">IP: </label>
                        <select class="form-control" name="ip_pesquisa" id="ip_pesquisa">
                            <option value="" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == '') selected @endif>Todos</option>
                            @foreach ($ips as $ip)
                                <option value="{{ $ip }}" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == $ip) selected @endif>
                                    {{ $ip }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-2 mt-3">
                        <label for="situacao_pesquisa" class="form-label mb-1">Situação: </label>
                        <select class="form-control" name="situacao_pesquisa" id="situacao_pesquisa">
                            <option value="Todas" @if (old('situacao_pesquisa', $situacao ?? 'Todas') == 'Todas') selected @endif>Todas</option>
                            <option value="Aceito" @if (old('situacao_pesquisa', $situacao) == 'Aceito') selected @endif>Aceito</option>
                            <option value="Recusado" @if (old('situacao_pesquisa', $situacao) == 'Recusado') selected @endif>Recusado</option>
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

                    <div class="col-sm-6 col-md-6 col-lg-3 mt-3 d-flex align-items-end p-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-sm-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('cookie.index') }}"
                                class="spinner-secondary btn btn-outline-secondary btn-sm">
                                <i class="fa-solid fa-broom"></i><span class="d-none d-sm-inline"> Limpar</span>
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
                    <span>Lista de cookies</span>

                    {{-- <div>
                        <a href="{{ url('administrador/empresas/gerar_pdf?' . request()->getQueryString()) }}"
                            class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span class="d-none d-sm-inline"> Gerar PDF</span>
                        </a>

                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteLogsModal">
                            <i class="fa-regular fa-trash-can"></i> <span class="d-none d-sm-inline">Excluir empresas</span>
                        </button>

                    </div> --}}
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($cookies->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum cookie encontrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>IP</th>
                                    <th class="d-none d-sm-table-cell">Versão</th>
                                    <th class="text-center d-none d-sm-table-cell">Situação</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cookies as $cookie)
                                    <tr>
                                        <td class="text-truncate" style="max-width: 120px;">{{ \Carbon\Carbon::parse($cookie->created_at)->format('d/m/Y H:i') }}</td>
                                        <td class="text-truncate" style="max-width: 90px;">{{ $cookie->ip }}</td>
                                        <td class=" d-none d-sm-table-cell">{{ $cookie->documentoLegal->id ?? '--' }}</td>
                                        <td class="text-center d-none d-sm-table-cell">
                                            @if ($cookie->accepted)
                                                <i class="fas fa-circle-check text-success"></i>
                                            @else
                                                <i class="fa-solid fa-xmark text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('cookie.show', $cookie->id) }}" class="spinner-light btn btn-outline-primary btn-sm"><i
                                                    class="fa-regular fa-folder-open"></i><span class="d-none d-md-inline">
                                                    Abrir</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cookies->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
