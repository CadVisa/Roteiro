@extends('layouts.layout_1')

@section('content')
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic">Informe apenas o CNPJ da empresa e emita o
                roteiro de
                classificação de
                risco sanitário</p>
            <div class="base-cv">Resolução SES/RJ nº 2191 de 02/12/2020</div>
        </div>
    </section>

    @if (session('config')->status_sistema === 'Suspenso')
        <div id="alert-danger" class="alert alert-danger fade show mt-3 text-center" role="alert">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-2">
                    <i class="fa-solid fa-triangle-exclamation fa-2x text-danger"></i>
                </div>
                <h5 class="fw-bold">Sistema em manutenção</h5>
            </div>
            <div class="mt-2 mb-0 text-center small" style="max-width: 700px; margin: 0 auto;">
                O sistema está temporariamente fora do ar para manutenção. Pedimos desculpas pelo transtorno e agradecemos a
                compreensão.
            </div>
        </div>
    @else
        @if ($acessos >= 10)
            <div id="alert-info" class="alert alert-info fade show mt-3 text-center" role="alert" style="display: none;">
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-2">
                        <i class="fa-solid fa-face-smile-beam fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Que bom ter você por aqui com frequência!</h5>
                </div>
                <div class="mt-2 mb-0 text-justify small" style="max-width: 700px; margin: 0 auto;">
                    <div class="text-justify">
                        Notamos que você utiliza o sistema com frequência — isso é ótimo! Que tal levar essa experiência
                        para o
                        próximo nível?
                        Podemos desenvolver soluções sob medida para você, com funcionalidades exclusivas e um layout
                        adaptado às
                        necessidades da sua rotina.
                    </div>
                    <div class="text-justify mt-2 mb-3">
                        O sistema já oferece ferramentas como o roteiro de classificação de risco sanitário, que agiliza e
                        organiza
                        o trabalho das vigilâncias.
                        Imagine o que podemos construir juntos para deixar tudo ainda mais eficiente e intuitivo!
                    </div>
                    <div class="mt-2 d-flex flex-column flex-sm-row justify-content-center gap-2">
                        <a href="{{ route('contato.index') }}" class="btn btn-success btn-sm">
                            Fale com a gente e vamos conversar!
                        </a>
                        <a id="fecharInfo" class="btn btn-secondary btn-sm">
                            Fechar
                        </a>
                    </div>
                </div>
            </div>
        @endif


        <div class="d-flex justify-content-center align-items-center">
            <div class="card border-primary border-ligth shadow col-sm-7 col-md-6 col-lg-5 col-xl-4 col-xxl-3">
                <div class="card-header text-center align-items-center border-primary text-light bg-primary">
                    <span>Informe o CNPJ da empresa</span>
                </div>
                <div class="card-body pb-1">
                    <form action="{{ route('estabelecimento.store') }}" method="POST" class="row g-3 needs-validation"
                        novalidate>
                        @csrf
                        @method('POST')

                        <x-alert />

                        <div class="col-12">
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-address-card text-primary"></i></div>
                                <input type="text" class="form-control @error('cnpj') is-invalid @enderror"
                                    name="cnpj" id="cnpj" placeholder="00.000.000/0000-00"
                                    value="{{ old('cnpj') }}" autocomplete="off">
                                @error('cnpj')
                                    <div class="invalid-feedback invalid-cv d-flex justify-content-center align-items-center">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                        <div>{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <button type="submit" onclick="mostrarPreload()" class="w-100 spinner-light-cv btn btn-sm btn-primary">
                                <i class="fas fa-search me-1"></i>Consultar empresa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (session('config')->exibe_card === 'Sim')
            <section class="features-section">
                <div class="row text-center">
                    @foreach (session('cards') as $card)
                        <div class="col-sm-6 col-lg-4 mb-4">
                            <div class="feature-icon">
                                <i class="{{ $card->card_icone }}"></i>
                            </div>
                            <h3>{{ $card->card_titulo }}</h3>
                            <p class="text-muted">{{ $card->card_descricao }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if (session('config')->exibe_info_rodape === 'Sim')
            <section class="notes-section mt-3">
                <div class="row">
                    <div class="col-12">
                        <p class="text-rodape">* Este sistema utiliza gratuitamente uma API de terceiros para consultar
                            dados
                            cadastrais na Receita Federal do Brasil. Por se tratar de um plano gratuito, estão sujeitas as
                            seguintes
                            condições: <strong>Limitação de consultas:</strong> Máximo de 3 requisições por minuto por IP.
                            Excedendo
                            esse
                            limite, o sistema
                            solicitará que aguarde 1 minuto antes de nova consulta. <strong>Atualização dos dados:</strong>
                            As
                            informações
                            podem apresentar defasagem de até 45 dias em relação à base
                            oficial da Receita Federal. A data da última atualização será exibida junto aos resultados.
                            <strong>Alterações cadastrais são incomuns para a maioria das empresas, portanto a defasagem
                                raramente impacta a utilidade dos dados</strong>. Para detalhes adicionais, consulte os <a
                                class="text-decoration-none" href="{{ route('termos_uso') }}">Termos de
                                uso</a> e <a class="text-decoration-none"
                                href="{{ route('politica_privacidade') }}">Política de Privacidade</a>.
                        </p>
                    </div>
                </div>
            </section>
        @endif
    @endif
@endsection
