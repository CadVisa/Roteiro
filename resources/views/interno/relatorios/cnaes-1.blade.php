@extends('layouts.layout_3')
<style>
    header {
        margin-top: -45px;
        border-top: 0.5px solid #000;
    }

    #filtros_titulo {
        text-align: center;
        font-size: 10px;
        font-weight: bold;
        margin-top: 5px;
    }

    .tabela_filtros {
        width: 100%;
        margin-top: 3px;
        padding-top: 0;
    }

    header .primeira_linha {
        width: 100%;
        border: 0.5px solid #000;
        border-bottom: none;
        border-spacing: 0;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        font-size: 11px;
    }

    header .ultima_linha {
        width: 100%;
        border: 0.5px solid #000;
        border-top: none;
        border-spacing: 0;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        margin-bottom: 10px;
        font-size: 11px;
    }

    .tabela_resultados table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .tabela_resultados td {
        border: 0.5px solid #000;
        padding: 4px;
    }

    .tit_cont {
        font-size: 10px;
        padding: 4px;
    }

    .negrito {
        font-weight: bold;
    }

    .centralizado {
        text-align: center;
    }
</style>

@section('conteudo')
    <header>
        <div id="filtros_titulo">FILTRO(S)</div>

        <div class="tabela_filtros">

            <table class="primeira_linha">
                <tr>
                    <td class="tit_cont" style="width: 33%;">
                        Código............: {{ $codigo_pesquisa ? mb_strtoupper($codigo_pesquisa, 'UTF-8') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 66%;">
                        Descrição......: {{ $descricao_pesquisa ? mb_strtoupper($descricao_pesquisa, 'UTF-8') : '--' }}
                    </td>
                </tr>
            </table>

            <table class="ultima_linha">
                <tr>
                    <td class="tit_cont" style="width: 33%;">
                        Grau de risco..: {{ $grau_pesquisa ? mb_strtoupper($grau_pesquisa, 'UTF-8') : 'TODOS' }}
                    </td>
                    <td class="tit_cont" style="width: 33%;">
                        Competência.: {{ $competencia_pesquisa ? mb_strtoupper($competencia_pesquisa, 'UTF-8') : 'TODAS' }}
                    </td>
                    <td class="tit_cont" style="width: 33%;">
                        Situação..:
                        {{ $revisao_pesquisa == 1 ? 'REVISADAS' : ($revisao_pesquisa == 2 ? 'SEM REVISÃO' : 'TODAS') }}
                    </td>
                </tr>
            </table>

        </div>
    </header>

    <body>

        <div class="tabela_resultados">
            <table class="primeira_linha">
                <thead>
                    <tr>
                        <td class="tit_cont negrito centralizado" style="width: 10%;">CÓDIGO</td>
                        <td class="tit_cont negrito" style="width: 90%;">DESCRIÇÃO</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cnaes as $cnae)
                        <tr>
                            <td class="tit_cont centralizado" style="width: 10%;">{{ $cnae->codigo_cnae }}</td>
                            <td class="tit_cont" style="width: 90%;">{{ $cnae->descricao_cnae }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </body>
@endsection
