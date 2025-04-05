@extends('layouts.layout_2')
<style>
    #area-1 {
        margin-top: -40px;
        margin-bottom: 10px;
    }

    #area-2,
    #area-3 {
        margin-bottom: 10px;
    }

    .dados-empresa {
        text-align: center;
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 3px;
        padding-bottom: 0;
    }

    .subtitulo {
        text-align: center;
        font-size: 11px;
        margin-top: 10px;
        font-weight: bold;
        margin-bottom: 3px;
        padding-bottom: 0;
    }


    .tabela-empresa {
        width: 100%;
        margin-top: 0;
        padding-top: 0;
    }

    .row_inicial,
    .row_interna,
    .row_final {
        width: 100%;
        border: 0.5px solid #000;
        border-spacing: 0;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        font-size: 11px;
    }

    .row_inicial,
    .row_interna {
        border-bottom: none;
    }

    .conteudo {
        font-style: bold;
        padding-bottom: 0px;
    }

    td {
        padding-left: 3px;
    }

    .tit_cont {
        font-size: 9px;
    }

    .borda_esquerda {
        border-left: 0.5px solid #000;
    }




    #tabela_roteiro {
        width: 100%;
        font-size: 12px;
        border-collapse: collapse;
    }

    #quadro_bloco {
        width: 100%;
        margin-bottom: 12px;
    }

    .titulo_cnae {
        padding: 5px;
        background-color: #cfcdcd;
        text-align: justify;
        font-size: 11px;
        font-weight: bold;
        border: 0.5px solid #000;
        text-align: center;
    }

    .row_cnae {
        padding: 5px;
        text-align: justify;
        font-size: 11px;
        font-weight: bold;
        border: 0.5px solid #000;
    }

    .compreende {
        padding: 2px 5px;
        text-align: justify;
        font-size: 8px;
        border: 0.5px solid #000;
    }

    #sim_nao {
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
        margin-top: 5px;
        text-align: center;
    }

    .cx_sim_nao {
        border: 0.5px solid #000;
        border-radius: 5px;
        padding: 3px 5px 3px 5px;
        font-size: 10px;
    }

    .titulo_compreende {
        font-weight: bold;
    }

    .pergunta {
        padding: 5px 5px 2px 5px;
        text-align: justify;
        font-size: 11px;
        border: 0.5px solid #000;
        border-bottom: none;
    }

    .titulo_pergunta {
        text-align: justify;
        font-size: 11px;
        font-weight: bold;
    }

    .texto_pergunta {
        text-align: justify;
        font-size: 11px;
    }

    .resposta {
        padding: 2px 5px 3px 5px;
        text-align: justify;
        font-size: 11px;
        border: 0.5px solid #000;
        border-top: none;
        font-weight: bold;
        height: 30px;
    }

    .cx_sim {
        border: 0.5px solid #000;
        border-radius: 5px;
        padding: 3px 15px 3px 15px;
        font-size: 10px;
    }

    .cx_nao {
        border: 0.5px solid #000;
        border-radius: 5px;
        padding: 3px 15px 3px 15px;
        font-size: 10px;
        margin-left: 20px;
    }

    #tabela_anotacao {
        width: 100%;
        font-size: 12px;
        border-collapse: collapse;
        border: 0.5px solid #000;
    }

    #tabela_anotacao td {
        border: 0.5px solid #000;
        padding: 15px 15px 15px 15px;
    }

    #tabela_assinatura {
        width: 100%;
        font-size: 12px;
        border-collapse: collapse;
        border: 0.5px solid #000;
    }

    .linha_assinatura {
        font-size: 8px;
        text-align: center;
        margin: 0;
        padding: 80px 5px 0px 5px;
    }

    #tabela_conclusao {
        width: 100%;

        font-size: 12px;
        border-collapse: collapse;
        border: 0.5px solid #000;

    }

    .linha_conclusao {
        font-size: 11px;
        height: 40px;
        text-align: center;
    }

    .texto_assinatura {
        font-size: 8px;
        text-align: center;
        margin: 0;
        padding: 0px 5px 10px 5px;
    }

    #cidade {
        font-size: 13px;
        text-align: left;
        padding: 20px 5px 0px 10px;
    }

    .cx_1 {
        border: 0.5px solid #000;
        border-radius: 5px;
        padding: 3px 15px 3px 15px;
        font-size: 10px;
        margin-left: 5px;
    }

    .cx_2 {
        border: 0.5px solid #000;
        border-radius: 5px;
        padding: 3px 15px 3px 15px;
        font-size: 10px;
        margin-left: 5px;
    }

    .cx_ultima {
        font-weight: bold;
    }

    #espaco {
        margin-left: 40px;
    }
</style>

@section('conteudo')
    @if ($estabelecimento)
        <div id="area-1">
            <div class="dados-empresa">
                <span>INFORMAÇÕES DA EMPRESA</span>
            </div>

            <div class="tabela-empresa">
                <table class="row_inicial">

                    <tr>
                        <td class="tit_cont" style="width: 80%;">Razão Social:</td>
                        <td class="tit_cont borda_esquerda" style="width: 20%;">CNPJ:</td>
                    </tr>
                    <tr>
                        <td class="conteudo" style="width: 80%;">
                            {{ $estabelecimento->razao_social ? mb_strtoupper($estabelecimento->razao_social, 'UTF-8') : 'NÃO INFORMADA' }}
                        </td>
                        <td class="conteudo borda_esquerda" style="width: 20%;">
                            {{ $estabelecimento->cnpj ? mb_strtoupper($estabelecimento->cnpj) : 'NÃO INFORMADO' }}</td>
                    </tr>

                </table>

                <table class="row_interna">
                    <tr>
                        <td class="tit_cont" style="width: 80%;">Nome Fantasia:</td>
                        <td class="tit_cont borda_esquerda" style="width: 20%;">Data da atualização:</td>
                    </tr>

                    <tr>
                        <td class="conteudo" style="width: 80%;">
                            {{ $estabelecimento->nome_fantasia ? mb_strtoupper($estabelecimento->nome_fantasia) : 'NÃO INFORMADO' }}
                        </td>
                        <td class="conteudo borda_esquerda" style="width: 20%;">
                            {{ $estabelecimento->atualizado_em ? mb_strtoupper(\Carbon\Carbon::parse($estabelecimento->atualizado_em)->format('d/m/Y')) : 'NÃO INFORMADA' }}
                        </td>
                    </tr>
                </table>

                <table class="row_interna">
                    <tr>
                        <td class="tit_cont" style="width: 60%;">Endereço:</td>
                        <td class="tit_cont borda_esquerda" style="width: 20%;">Bairro:</td>
                        <td class="tit_cont borda_esquerda" style="width: 20%;">Cidade/UF:</td>
                    </tr>

                    <tr>
                        <td class="conteudo" style="width: 60%;">
                            {{ $estabelecimento->logradouro ? mb_strtoupper($estabelecimento->logradouro . ', Nº ' . $estabelecimento->numero, 'UTF-8') : 'NÃO INFORMADO' }}
                            {{ $estabelecimento->complemento ? ' - ' . mb_strtoupper($estabelecimento->complemento) : '' }}
                        </td>
                        <td class="conteudo borda_esquerda" style="width: 20%;">
                            {{ $estabelecimento->bairro ? mb_strtoupper($estabelecimento->bairro) : 'NÃO INFORMADO' }}</td>

                        @php
                            $cidade = $estabelecimento->cidade
                                ? mb_strtoupper($estabelecimento->cidade, 'UTF-8')
                                : 'NÃO INFORMADA';
                            $estado = $estabelecimento->estado
                                ? mb_strtoupper($estabelecimento->estado, 'UTF-8')
                                : 'NÃO INFORMADO';
                            $cidadeUf = trim($cidade . ($cidade && $estado ? '/' : '') . $estado);
                        @endphp

                        <td class="conteudo borda_esquerda" style="width: 20%;">
                            {{ $cidadeUf ? $cidadeUf : 'NÃO INFORMADA' }}
                        </td>
                    </tr>
                </table>

                <table class="row_final">
                    <tr>
                        <td class="tit_cont" style="width: 30%;">Telefone(s):</td>
                        <td class="tit_cont borda_esquerda" style="width: 50%;">E-mail:</td>
                        <td class="tit_cont borda_esquerda" style="width: 20%;">CEP:</td>
                    </tr>

                    <tr>
                        <td class="conteudo" style="width: 30%;">
                            @php
                                $telefone1 = trim($estabelecimento->telefone_1) ?? '';
                                $telefone2 = trim($estabelecimento->telefone_2) ?? '';
                                $telefones = [];

                                if ($telefone1) {
                                    $telefones[] = mb_strtoupper($telefone1, 'UTF-8');
                                }
                                if ($telefone2) {
                                    $telefones[] = mb_strtoupper($telefone2, 'UTF-8');
                                }
                            @endphp

                            {{ count($telefones) > 0 ? implode(' / ', $telefones) : 'NÃO INFORMADO' }}
                        </td>
                        <td class="conteudo borda_esquerda" style="width: 50%;">
                            {{ $estabelecimento->email ? $estabelecimento->email : 'NÃO INFORMADO' }}</td>
                        <td class="conteudo borda_esquerda" style="width: 20%;">
                            {{ $estabelecimento->cep ? $estabelecimento->cep : 'NÃO INFORMADO' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <div id="area-2">
        <div class="subtitulo">
            <span>ATIVIDADE(S) COM GRAU DE RISCO DEFINIDO</span>
        </div>

        @foreach ($grausDefinidos as $item)
            <div id="quadro_bloco" style="page-break-inside: avoid;">
                <table id="tabela_roteiro">
                    <tr>
                        <td class="row_cnae" style="width: 76%;" rowspan="2">
                            {{ $item->codigo_cnae . ' - ' . $item->descricao_cnae }}</td>
                        {{-- <td class="titulo_cnae" style="width: 10%;">Competência</td> --}}
                        <td class="titulo_cnae" style="width: 12%;">Grau de risco</td>
                        <td class="titulo_cnae" style="width: 12%;">Exerce?</td>
                    </tr>
                    <tr>

                        {{-- <td class="row_cnae" style="width: 10%; text-align: center;">{{ $item->competencia }}</td> --}}
                        <td class="row_cnae" style="width: 17%; text-align: center;">{{ $item->grau_cnae }}</td>
                        <td class="row_cnae" style="width: 17%;">
                            <div id="sim_nao">
                                <span class="cx_sim_nao">Sim</span>
                                <span class="cx_sim_nao">Não</span>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td class="compreende" colspan="3">
                            <span class="titulo_compreende">Compreende: </span>{{ $item->notas_s_compreende }}
                            <span class="titulo_compreende"> / Não compreende: </span>{{ $item->notas_n_compreende }}
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach

    </div>

    <div id="area-3">
        <div class="subtitulo">
            <span>ATIVIDADE(S) QUE DEPENDE(M) DE INFORMAÇÃO</span>
        </div>

        @foreach ($grausDepende as $item)
            <div id="quadro_bloco" style="page-break-inside: avoid;">
                <table id="tabela_roteiro">
                    <tr>
                        <td class="row_cnae" style="width: 88%;" rowspan="2">
                            {{ $item->codigo_cnae . ' - ' . $item->descricao_cnae }}</td>
                        <td class="titulo_cnae" style="width: 12%;">Exerce?</td>
                    </tr>
                    <tr>

                        <td class="row_cnae" style="width: 12%;">
                            <div id="sim_nao">
                                <span class="cx_sim_nao">Sim</span>
                                <span class="cx_sim_nao">Não</span>
                            </div>
                        </td>

                    </tr>
                    @foreach ($item->perguntas as $pergunta)
                        <tr>
                            <td class="pergunta" colspan="2">
                                <span class="titulo_pergunta">Pergunta: </span><span
                                    class="texto_pergunta">{{ $pergunta->pergunta }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="resposta" colspan="2">
                                <span>Resposta: </span>
                                <span class="cx_sim">Sim</span>
                                <span>{{ $pergunta->grau_sim }}</span>
                                <span class="cx_nao">Não</span>
                                <span>{{ $pergunta->grau_nao }}</span>

                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="compreende" colspan="2">
                            <span class="titulo_compreende">Compreende: </span>{{ $item->notas_s_compreende }}
                            <span class="titulo_compreende"> / Não compreende: </span>{{ $item->notas_n_compreende }}
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>

    <div style="page-break-inside: avoid;">
        <div class="subtitulo">
            <span>OBSERVAÇÕES</span>
        </div>

        <table id="tabela_anotacao">
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>  
        </table>

        <div class="subtitulo">
            <span>CONCLUSÃO</span>
        </div>

        <table id="tabela_conclusao">
            <tr>
                <td class="linha_conclusao">
                    {{-- <span class="cx_ultima">Competência:</span><span class="cx_1">Estadual</span> <span class="cx_2">Municipal</span> --}}
                    <span class="cx_ultima" id="espaco">Grau de risco empresa:</span><span class="cx_1">Alto risco</span> <span class="cx_2">Médio risco</span> <span class="cx_2">Baixo risco</span>
                </td>
            </tr>
        </table>


        <div class="subtitulo">
            <span>ASSINATURAS</span>
        </div>

        <table id="tabela_assinatura">
            <tr>
                <td id="cidade" colspan="4">{{ $estabelecimento->cidade ? mb_strtoupper($estabelecimento->cidade) : 'NÃO INFORMADA' }}, ____/____/____</td>
            </tr>
            <tr>
                <td class="linha_assinatura">______________________________</td>
                <td class="linha_assinatura">______________________________</td>
                <td class="linha_assinatura">______________________________</td>
                <td class="linha_assinatura">______________________________</td>
            </tr>
            <tr>
                <td class="texto_assinatura"> Assinatura e carimbo do fiscal</td>
                <td class="texto_assinatura"> Assinatura e carimbo do fiscal</td>
                <td class="texto_assinatura"> Assinatura e carimbo do fiscal</td>
                <td class="texto_assinatura"> Assinatura e carimbo do fiscal</td>
            </tr>
        </table>
    </div>
@endsection
