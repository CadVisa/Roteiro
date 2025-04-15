@extends('layouts.layout_4')

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
                    <td class="tit_cont" style="width: 50%;">
                        Descrição..: {{ $descricao_pesquisa ? mb_strtoupper($descricao_pesquisa, 'UTF-8') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Data inicial..: {{ $data_fim ? \Carbon\Carbon::parse($data_fim)->format('d/m/Y H:i') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Data fim..: {{ $data_fim ? \Carbon\Carbon::parse($data_fim)->format('d/m/Y H:i') : '--' }}
                    </td>
                </tr>
            </table>

            <table class="ultima_linha">
                <tr>
                    <td class="tit_cont" style="width: 50%;">
                        IP...............: {{ $ip_pesquisa ? mb_strtoupper($ip_pesquisa, 'UTF-8') : 'TODOS' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Nível...........:
                        @if ($nivel_pesquisa == 4)
                            RESOLVIDO
                        @elseif ($nivel_pesquisa == 1)
                            NORMAL
                        @elseif ($nivel_pesquisa == 2)
                            IMPORTANTE
                        @elseif ($nivel_pesquisa == 3)
                            CRÍTICO
                        @else
                            TODOS
                        @endif
                    </td>

                    <td class="tit_cont" style="width: 25%;">
                        Grupo.....:
                        @if ($grupo_pesquisa == 'pg_consent')
                            COOKIES
                        @elseif ($grupo_pesquisa == 'pg_contato')
                            CONTATOS
                        @elseif ($grupo_pesquisa == 'pg_inicial')
                            PÁGINA PRINCIPAL
                        @elseif ($grupo_pesquisa == 'pg_resultado')
                            RESULTADO
                        @elseif ($grupo_pesquisa == 'pg_politica')
                            POLÍTICA
                        @elseif ($grupo_pesquisa == 'pg_termos')
                            TERMOS
                        @elseif ($grupo_pesquisa == 'pg_login')
                            LOGIN
                        @elseif ($grupo_pesquisa == 'pg_logout')
                            LOGOUT
                        @elseif ($grupo_pesquisa == 'pg_adm')
                            ADMINISTRADOR
                        @elseif ($grupo_pesquisa == 'pg_cards')
                            CARDS
                        @elseif ($grupo_pesquisa == 'pg_cnaes')
                            CNAES
                        @elseif ($grupo_pesquisa == 'pg_configuracoes')
                            CONFIGURAÇÕES
                        @elseif ($grupo_pesquisa == 'pg_contacts')
                            PAINEL DE CONTATOS
                        @elseif ($grupo_pesquisa == 'pg_consulta_cnaes')
                            CONSULTA CNAES
                        @elseif ($grupo_pesquisa == 'pg_logs')
                            LOGS DO SISTEMA
                        @else
                            TODOS
                        @endif
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
                        <td class="tit_cont negrito centralizado" style="width: 2%;">N</td>
                        <td class="tit_cont negrito centralizado" style="width: 13%;">DATA</td>
                        <td class="tit_cont negrito" style="width: 77%;">DESCRIÇÃO</td>
                        <td class="tit_cont negrito" style="width: 8%;">USUÁRIO</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="tit_cont centralizado" style="width: 2%;">
                                {{ $log->log_nivel }}
                            </td>
                            <td class="tit_cont centralizado" style="width: 13%;">
                                {{ \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i') }}
                            </td>
                            <td class="tit_cont" style="width: 77%;">
                                {{ $log->log_descricao }}
                                @if ($log->log_observacoes)
                                    ({{ $log->log_observacoes }})
                                @endif
                            </td>
                            <td class="tit_cont"  style="width: 8%;">
                                {{ $log->user && $log->user->name ? explode(' ', $log->user->name)[0] : 'Visitante' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
@endsection



{{-- @extends('layouts.layout_4')
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
        padding: 3px;
        margin: 2px;
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
                    <td class="tit_cont" style="width: 50%;">
                        Descrição: {{ $descricao_pesquisa ? mb_strtoupper($descricao_pesquisa, 'UTF-8') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Data inicial: {{ $data_fim ? \Carbon\Carbon::parse($data_fim)->format('d/m/Y H:i') : '--' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Data fim: {{ $data_fim ? \Carbon\Carbon::parse($data_fim)->format('d/m/Y H:i') : '--' }}
                    </td>
                </tr>
            </table>

            <table class="ultima_linha">
                <tr>
                    <td class="tit_cont" style="width: 50%;">
                        IP: {{ $ip_pesquisa ? mb_strtoupper($ip_pesquisa, 'UTF-8') : 'TODOS' }}
                    </td>
                    <td class="tit_cont" style="width: 25%;">
                        Nível:
                        @if ($nivel_pesquisa == 4)
                            RESOLVIDO
                        @elseif ($nivel_pesquisa == 1)
                            NORMAL
                        @elseif ($nivel_pesquisa == 2)
                            IMPORTANTE
                        @elseif ($nivel_pesquisa == 3)
                            CRÍTICO
                        @else
                            TODOS
                        @endif
                    </td>

                    <td class="tit_cont" style="width: 25%;">
                        Grupo:
                        @if ($grupo_pesquisa == 'pg_consent')
                            COOKIES
                        @elseif ($grupo_pesquisa == 'pg_contato')
                            CONTATOS
                        @elseif ($grupo_pesquisa == 'pg_inicial')
                            PÁGINA PRINCIPAL
                        @elseif ($grupo_pesquisa == 'pg_resultado')
                            RESULTADO
                        @elseif ($grupo_pesquisa == 'pg_politica')
                            POLÍTICA
                        @elseif ($grupo_pesquisa == 'pg_termos')
                            TERMOS
                        @elseif ($grupo_pesquisa == 'pg_login')
                            LOGIN
                        @elseif ($grupo_pesquisa == 'pg_logout')
                            LOGOUT
                        @elseif ($grupo_pesquisa == 'pg_adm')
                            ADMINISTRADOR
                        @elseif ($grupo_pesquisa == 'pg_cards')
                            CARDS
                        @elseif ($grupo_pesquisa == 'pg_cnaes')
                            CNAES
                        @elseif ($grupo_pesquisa == 'pg_configuracoes')
                            CONFIGURAÇÕES
                        @elseif ($grupo_pesquisa == 'pg_contacts')
                            PAINEL DE CONTATOS
                        @elseif ($grupo_pesquisa == 'pg_consulta_cnaes')
                            CONSULTA CNAES
                        @elseif ($grupo_pesquisa == 'pg_logs')
                            LOGS DO SISTEMA
                        @else
                            TODOS
                        @endif
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
                        <td class="tit_cont negrito centralizado" style="width: 2%;">N</td>
                        <td class="tit_cont negrito centralizado" style="width: 13%;">DATA</td>
                        <td class="tit_cont negrito" style="width: 77%;">DESCRIÇÃO</td>
                        <td class="tit_cont negrito" style="width: 8%;">USUÁRIO</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="tit_cont centralizado" style="width: 2%;">
                                {{ $log->log_nivel }}
                            </td>
                            <td class="tit_cont centralizado" style="width: 13%;">
                                {{ \Carbon\Carbon::parse($log->log_data)->format('d/m/Y H:i') }}
                            </td>
                            <td class="tit_cont" style="width: 77%;">
                                {{ $log->log_descricao }}
                                @if ($log->log_observacoes)
                                    ({{ $log->log_observacoes }})
                                @endif
                            </td>
                            <td class="tit_cont" style="width: 8%;">
                                {{ $log->user && $log->user->name ? explode(' ', $log->user->name)[0] : 'Visitante' }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </body>
@endsection --}}
