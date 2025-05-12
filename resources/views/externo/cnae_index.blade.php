@extends('layouts.layout_1')

@section('content')

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic">Realize consultas das atividades econômicas</p>
            <div class="base-cv">Resolução SES/RJ nº 2191 de 02/12/2020</div>
        </div>
    </section>

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-magnifying-glass me-1"></i>Atividades Econômicas</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header space-between-elements border-primary text-light bg-primary">
                <span>Pesquisar</span>
            </div>

            <div class="card-body">
                <form action="{{ route('consulta_cnae.index') }}" class="row g-3 mb-2 needs-validation" novalidate>

                    <div class="col-sm-4 col-md-4 col-lg-2 mt-3">
                        <label for="codigo_pesquisa" class="form-label mb-1">Código: </label>
                        <input class="form-control" type="text" name="codigo_pesquisa" id="codigo_pesquisa"
                            placeholder="Código do CNAE" value="{{ old('codigo_pesquisa', $codigo_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-8 col-md-8 col-lg-4 mt-3">
                        <label for="descricao_pesquisa" class="form-label mb-1">Descrição: </label>
                        <input class="form-control" type="text" name="descricao_pesquisa" id="descricao_pesquisa"
                            placeholder="Descrição do CNAE" value="{{ old('descricao_pesquisa', $descricao_pesquisa) }}"
                            autocomplete="off">
                    </div>

                    <div class="col-sm-4 col-lg-3 mt-3">
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

                    <div class="col-sm-6 col-md-4 col-lg-3 mt-3 d-flex align-items-end p-sm-1">
                        <div class="d-flex justify-content-start">
                            <button class="spinner-primary btn btn-outline-primary btn-sm me-1" type="submit" onclick="mostrarPreload()">
                                <i class="fa-solid fa-magnifying-glass"></i><span>
                                    Pesquisar</span>
                            </button>
                            <a href="{{ route('consulta_cnae.index') }}" class="spinner-secondary btn btn-outline-secondary btn-sm" onclick="mostrarPreload()">
                                <i class="fa-solid fa-broom"></i><span> Limpar</span>
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
                                    <th class="d-none d-sm-table-cell">Descrição</th>
                                    <th class="text-center">Grau de risco</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cnaes as $cnae)
                                    <tr>
                                        <td style="width: 90px;" title="{{ $cnae->descricao_cnae }}">
                                            {{ $cnae->codigo_cnae }}</td>

                                        <td class="text-truncate d-none d-sm-table-cell" style="max-width: 200px;"
                                            title="{{ $cnae->descricao_cnae }}">
                                            {{ $cnae->descricao_cnae }}</td>

                                        <td class="text-truncate text-center"
                                            style="width: 120px;">
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
            
                                        <td class="text-end">
                                            <a href="{{ route('consulta_cnae.show', ['cnae' => $cnae]) }}"
                                                class="btn btn-outline-primary btn-sm" onclick="mostrarPreload()"><i
                                                    class="fa-regular fa-folder-open"></i><span class="d-none d-sm-inline">
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
