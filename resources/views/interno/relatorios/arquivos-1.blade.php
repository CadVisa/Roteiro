@extends('layouts.layout_6')

<style>
    header {
        margin-top: -45px;
        border-top: 0.5px solid #000;
    }

    #filtros_titulo {
        text-align: center;
        font-size: 9px;
        font-weight: bold;
        margin: 3px;
    }

    .tabela_filtros {
        width: 100%;
        margin-top: 3px;
        padding-top: 0;
    }

    header .primeira_linha {
        width: 100%;
        border: 0.5px solid #000;
        /* border-bottom: none; */
        border-spacing: 0;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        font-size: 10px;
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
        font-size: 10px;
    }

    .tabela_resultados table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    .tabela_resultados td {
        border: 0.5px solid #000;
        padding: 3px;
    }

    .tit_cont {
        font-size: 9px;
        padding: 3px;
        margin: 1px;
    }

    .negrito {
        font-weight: bold;
    }

    .centralizado {
        text-align: center;
    }

    @page {
        margin: 40px 30px;
    }

    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
    }

    .tabela_resultados td:nth-child(1) {
        width: 5%;
    }

    .tabela_resultados td:nth-child(2) {
        width: 15%;
    }

    .tabela_resultados td:nth-child(3) {
        width: 70%;
    }

    .tabela_resultados td:nth-child(4) {
        width: 10%;
    }
</style>

@section('conteudo')
    <header>
        <div id="filtros_titulo">FILTRO(S)</div>

        <div class="tabela_filtros">

            <table class="primeira_linha">
                <tr>
                    <td class="tit_cont" style="width: 75%;">
                        Nome..: {{ $nome_pesquisa ? mb_strtoupper($nome_pesquisa, 'UTF-8') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Data..: {{ $data_pesquisa ? \Carbon\Carbon::parse($data_pesquisa)->format('d/m/Y H:i') : '--' }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="tabela_filtros" style="margin-bottom: 10px; margin-top: 10px;">

            <table class="primeira_linha">
                <tr>
                    <td class="tit_cont" style="width: 37.5%;">
                        Nº de arquivos: {{ $n_arquivos }}
                    </td>
                    <td class="tit_cont" style="width: 37.5%;">
                        Tamanho total: {{ $tamanhoTotal }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Tamanho médio/arquivo: {{ $media }}
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
                        <td class="tit_cont negrito centralizado" style="width: 13%;">DATA</td>
                        <td class="tit_cont negrito" style="width: 79%;">DESCRIÇÃO</td>
                        <td class="tit_cont negrito" style="width: 8%;">TAMANHO</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arquivos as $arquivo)
                        <tr>
                            <td class="tit_cont centralizado" style="width: 13%;">
                                {{ $arquivo['data'] }}
                            </td>
                            <td class="tit_cont" style="width: 79%;">
                                {{ $arquivo['nome'] }}
                            </td>
                            <td class="tit_cont" style="width: 8%;">
                                {{ $arquivo['tamanho'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
@endsection