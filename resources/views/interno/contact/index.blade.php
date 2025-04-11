@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-table-list me-1"></i>Painel de contatos</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header space-between-elements border-primary text-light bg-primary">
                <span>Pesquisar</span>
            </div>

            <div class="card-body">
                <form action="{{ route('contact.index') }}" class="row g-3 mb-2 needs-validation" novalidate method="POST">
                    @csrf
                    @method('GET')

                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <label for="data_pesquisa" class="form-label mb-1">Data: </label>
                        <input class="form-control" type="date" name="data_pesquisa" id="data_pesquisa"
                            placeholder="Data da mensagem" value="{{ old('data_pesquisa', $data_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-8 col-md-9 col-lg-4 col-xl-4 mt-3">
                        <label for="nome_pesquisa" class="form-label mb-1">Usuário: </label>
                        <input class="form-control" type="text" name="nome_pesquisa" id="nome_pesquisa"
                            placeholder="Nome do usuário" value="{{ old('nome_pesquisa', $nome_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-3">
                        <label for="ip_pesquisa" class="form-label mb-1">IP: </label>
                        <select class="form-control" name="ip_pesquisa" id="ip_pesquisa">
                            <option value="" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == '') selected @endif>Todos</option>
                            @foreach ($ips as $ip)
                                <option value="{{ $ip }}" @if (old('ip_pesquisa', $ip_pesquisa ?? '') == $ip) selected @endif>
                                    {{ $ip }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-3">
                        <label for="status_pesquisa" class="form-label mb-1">Status: </label>
                        <select class="form-control" name="status_pesquisa" id="status_pesquisa">
                            <option value="" @if (old('status_pesquisa', $status_pesquisa ?? '') == '') selected @endif>Todos</option>
                            <option value="Finalizado" @if ($status_pesquisa == 'Finalizado') selected @endif>Finalizado</option>
                            <option value="Pendente" @if ($status_pesquisa == 'Pendente') selected @endif>Pendente</option>
                            <option value="Visualizado" @if ($status_pesquisa == 'Visualizado') selected @endif>Visualizado
                            </option>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mt-3 d-flex align-items-end p-lg-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-sm-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('contact.index') }}"
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
                    <span>Lista de contatos</span>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($contatos->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum contato encontrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="d-none d-sm-table-cell">Data</th>
                                    <th>Usuário</th>
                                    <th class="d-none d-md-table-cell">IP</th>
                                    <th class="d-none d-sm-table-cell text-center">Status</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($contatos as $contato)
                                    <tr>                                        
                                        <td>#{{ $contato->id }}</td>
                                        <td class="d-none d-sm-table-cell">{{ \Carbon\Carbon::parse($contato->data_mensagem)->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $contato->nome }}</td>
                                        <td class="text-truncate d-none d-md-table-cell" style="max-width: 150px;" title="{{ $contato->ip }}">
                                            {{ $contato->ip }}</td>
                                        <td class="d-none d-sm-table-cell text-center" title="{{ $contato->status }}">
                                            <span>
                                                @if ($contato->status == 'Finalizado')
                                                    <i class="fa-solid fa-check text-success"></i>
                                                @elseif ($contato->status == 'Pendente')
                                                <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                @elseif ($contato->status == 'Visualizado')
                                                <i class="fa-solid fa-eye text-primary"></i>
                                                @endif
                                            </span>
                                        </td>
                                        
                                        <td class="text-end">
                                            <a href="{{ route('contact.show', $contato->id) }}"
                                                class="spinner-primary btn btn-outline-primary btn-sm"><i
                                                    class="fa-regular fa-folder-open"></i><span class="d-none d-sm-inline">
                                                    Abrir</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $contatos->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
