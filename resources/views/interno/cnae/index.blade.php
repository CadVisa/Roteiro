@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-brands fa-creative-commons-share me-1"></i>Atividades Econômicas</h4>
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
                <form action="{{ route('cnae.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-4 col-md-4 col-lg-2 col-xl-2 mt-3">
                        <label for="codigo_pesquisa" class="form-label mb-1">Código: </label>
                        <input class="form-control" type="text" name="codigo_pesquisa" id="codigo_pesquisa"
                            placeholder="Código do CNAE" value="{{ old('codigo_pesquisa', $codigo_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-8 col-md-8 col-lg-6 col-xl-4 mt-3">
                        <label for="descricao_pesquisa" class="form-label mb-1">Descrição: </label>
                        <input class="form-control" type="text" name="descricao_pesquisa" id="descricao_pesquisa"
                            placeholder="Descrição do CNAE" value="{{ old('descricao_pesquisa', $descricao_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-3">
                        <label for="grau_pesquisa" class="form-label mb-1">Grau de risco: </label>
                        <select class="form-control" name="grau_pesquisa" id="grau_pesquisa">
                            <option value="" @if (old('grau_pesquisa', $grau_pesquisa ?? '') == '') selected @endif>Todos</option>
                            <option value="Baixo risco" @if ($grau_pesquisa == 'Baixo risco') selected @endif>Baixo risco
                            </option>
                            <option value="Médio risco" @if ($grau_pesquisa == 'Médio risco') selected @endif>Médio risco
                            </option>
                            <option value="Alto risco" @if ($grau_pesquisa == 'Alto risco') selected @endif>Alto risco</option>
                            <option value="Depende de informação" @if ($grau_pesquisa == 'Depende de informação') selected @endif>Depende
                                de informação</option>
                            <option value="CNAE isento" @if ($grau_pesquisa == 'CNAE isento') selected @endif>Isento</option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-3">
                        <label for="competencia_pesquisa" class="form-label mb-1">Competência: </label>
                        <select class="form-control" name="competencia_pesquisa" id="competencia_pesquisa">
                            <option value="" @if (old('competencia_pesquisa', $competencia_pesquisa ?? '') == '') selected @endif>Todas</option>
                            <option value="Municipal" @if ($competencia_pesquisa == 'Municipal') selected @endif>Municipal</option>
                            <option value="Estadual" @if ($competencia_pesquisa == 'Estadual') selected @endif>Estadual</option>
                            <option value="Depende de informação" @if ($competencia_pesquisa == 'Depende de informação') selected @endif>Depende
                                de informação</option>
                            <option value="CNAE isento" @if ($competencia_pesquisa == 'CNAE isento') selected @endif>Isento</option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2 mt-3">
                        <label for="revisao_pesquisa" class="form-label mb-1">Situação: </label>
                        <select class="form-control" name="revisao_pesquisa" id="revisao_pesquisa">
                            <option value="" @if (old('revisao_pesquisa', $revisao_pesquisa ?? '') == '') selected @endif>Todas</option>
                            <option value="1" @if ($revisao_pesquisa == '1') selected @endif>Revisadas</option>
                            <option value="2" @if ($revisao_pesquisa == '2') selected @endif>Sem revisão
                            </option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 mt-3 d-flex align-items-end p-lg-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-sm-inline">
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('cnae.index') }}" class="spinner-secondary btn btn-outline-secondary btn-sm">
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
                    <span>Lista de atividades econômicas</span>

                    <div>
                        <a href="{{ url('administrador/cnaes/gerar_pdf?' . request()->getQueryString()) }}" class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span class="d-none d-sm-inline"> Gerar PDF</span>
                        </a>
                        <a href="{{ route('cnae.create') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-plus"></i>
                            <span class="d-none d-sm-inline"> Adicionar</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($cnaes->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhuma atividade econômica encontrada!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th class="d-none d-md-table-cell">Descrição</th>
                                    <th class="d-none d-sm-table-cell text-center">Grau de risco</th>
                                    <th class="d-none d-sm-table-cell text-center">Competência</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cnaes as $cnae)
                                    <tr>
                                        <td style="width: 90px;" title="{{ $cnae->descricao_cnae }}">
                                            {{ $cnae->codigo_cnae }}</td>
                                        <td class="text-truncate d-none d-md-table-cell" style="max-width: 300px;"
                                            title="{{ $cnae->descricao_cnae }}">
                                            {{ $cnae->descricao_cnae }}</td>
                                        <td class="text-truncate d-none d-sm-table-cell text-center"
                                            style="max-width: 100px;">
                                            <span
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
                                                    IS
                                                @elseif ($cnae->grau_cnae == 'Depende de informação')
                                                    DI
                                                @elseif ($cnae->grau_cnae == 'Alto risco')
                                                    AR
                                                @elseif ($cnae->grau_cnae == 'Médio risco')
                                                    MR
                                                @elseif ($cnae->grau_cnae == 'Baixo risco')
                                                    BR
                                                @else
                                                    {{ $cnae->grau_cnae }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-truncate d-none d-sm-table-cell text-center"
                                            style="max-width: 100px;">
                                            <span
                                                class="badge rounded-pill 
                                                @if ($cnae->competencia == 'CNAE isento') @elseif($cnae->competencia == 'Municipal')
                                                    bg-success
                                                @elseif($cnae->competencia == 'Estadual')
                                                    bg-danger
                                                @elseif($cnae->competencia == 'Depende de informação')
                                                    bg-primary
                                                @else
                                                    bg-light text-dark @endif">

                                                @if ($cnae->competencia == 'CNAE isento')
                                                @elseif ($cnae->competencia == 'Municipal')
                                                    MUN
                                                @elseif ($cnae->competencia == 'Estadual')
                                                    EST
                                                @elseif ($cnae->competencia == 'Depende de informação')
                                                    DI
                                                @else
                                                    {{ $cnae->competencia }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('cnae.show', ['cnae' => $cnae]) }}"
                                                class="spinner-light btn btn-outline-primary btn-sm"><i
                                                    class="fa-regular fa-folder-open"></i><span
                                                    class="d-none d-sm-inline">
                                                    Abrir</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cnaes->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
