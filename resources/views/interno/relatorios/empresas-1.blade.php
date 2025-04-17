@extends('layouts.layout_5')

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
        border-bottom: none;
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
                    <td class="tit_cont" style="width: 80%;" colspan="3">
                        Razão social..: {{ $razao_pesquisa ? mb_strtoupper($razao_pesquisa, 'UTF-8') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 20%;">
                        CNPJ......: {{ $cnpj_pesquisa ? mb_strtoupper($cnpj_pesquisa, 'UTF-8') : '--' }}
                    </td>
                </tr>
                <tr>
                    <td class="tit_cont" style="width: 50%;">
                        Cidade...........: {{ $cidade_pesquisa ? mb_strtoupper($cidade_pesquisa, 'UTF-8') : 'TODAS' }}
                    </td>
                    <td class="tit_cont" style="width: 10%;">
                        UF...: {{ $estado_pesquisa ? mb_strtoupper($estado_pesquisa, 'UTF-8') : 'TODOS' }}
                    </td>
                    <td class="tit_cont" style="width: 20%;">
                        Data inicial..: {{ $data_fim ? \Carbon\Carbon::parse($data_fim)->format('d/m/Y H:i') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 20%;">
                        Data fim..: {{ $data_fim ? \Carbon\Carbon::parse($data_fim)->format('d/m/Y H:i') : '--' }}
                    </td>
                </tr>
            </table>

            <table class="ultima_linha">
                <tr>
                    <td class="tit_cont" style="width: 80%;">
                        IP...................: {{ $ip_pesquisa ? mb_strtoupper($ip_pesquisa, 'UTF-8') : 'TODOS' }}
                    </td>
                    <td class="tit_cont" style="width: 20%;">
                            Situação..:
                            @if ($roteiro_pesquisa == 1)
                                COM ROTEIRO
                            @elseif ($roteiro_pesquisa == 2)
                                SEM ROTEIRO
                            @else
                                TODAS
                            @endif
                        </td>
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
                        <td class="tit_cont negrito centralizado" style="width: 12%;">DATA</td>
                        <td class="tit_cont negrito" style="width: 65%;">RAZÃO SOCIAL</td>
                        <td class="tit_cont negrito" style="width: 13%;">CNPJ</td>
                        <td class="tit_cont negrito" style="width: 10%;">IP</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td class="tit_cont centralizado" style="width: 12%;">
                                {{ \Carbon\Carbon::parse($empresa->criado_em)->format('d/m/Y H:i') }}
                            </td>
                            <td class="tit_cont" style="width: 65%;">
                                {{ $empresa->razao_social }}
                                @if ($empresa->nome_fantasia)
                                    ({{ $empresa->nome_fantasia }})
                                @endif
                            </td>
                            <td class="tit_cont"  style="width: 13%;">
                                {{ $empresa->cnpj }}
                            </td>
                            <td class="tit_cont" style="width: 10%; word-break: break-word; white-space: normal;">
                                {{ $empresa->criado_por }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
@endsection
