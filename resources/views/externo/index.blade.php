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

    <div class="d-flex justify-content-center align-items-center">
        <div class="card border-primary border-ligth shadow col-sm-7 col-md-6 col-lg-5 col-xl-4 col-xxl-3">
            <div class="card-header text-center align-items-center border-primary text-light bg-primary">
                <span>Informe o CNPJ da empresa</span>
            </div>
            <div class="card-body pb-1">
                <form action="#" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('POST')

                    <x-alert />

                    <div class="col-12">
                        <div class="input-group">
                            <div class="input-group-text"><i class="fa-solid fa-address-card text-primary"></i></div>
                            <input type="text" class="form-control @error('cnpj') is-invalid @enderror" name="cnpj"
                                id="cnpj" placeholder="00.000.000/0000-00" value="{{ old('cnpj') }}"
                                autocomplete="off">
                        </div>
                        <div class="invalid-feedback">
                            @error('cnpj')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <button type="submit" class="w-100 spinner-primary btn btn-sm btn-primary">
                            <i class="fas fa-search me-1"></i>Consultar empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="features-section">
        <div class="row text-center">
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Rápido</h3>
                <p class="text-muted">Obtenha automaticamente um arquivo completo com todas as informações necessárias para
                    a classificação do risco sanitário, em conformidade com a Resolução SES/RJ nº 2191 de 02/12/2020.</p>
            </div>

            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="feature-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <h3>Grátis</h3>
                <p class="text-muted">Todas as consultas e emissões de roteiros de classificação de risco sanitário são
                    oferecidas sem custos*.</p>
            </div>

            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="feature-icon">
                    <i class="fa-solid fa-battery-full"></i>
                </div>
                <h3>Completo</h3>
                <p class="text-muted">Contém todas as informações necessárias para classificação de risco da empresa,
                    incluindo: dados cadastrais completos; atividades econômicas com notas explicativas detalhadas, conforme
                    a CONCLA-IBGE.</p>
            </div>

            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Confiável</h3>
                <p class="text-muted">Os dados da empresa são preenchidos automaticamente! As informações são coletadas em
                    bancos de dados da Receita Federal*.</p>
            </div>

            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="feature-icon">
                    <i class="fa-solid fa-arrows-to-circle"></i>
                </div>
                <h3>Padrão</h3>
                <p class="text-muted">O roteiro de classificação de risco sanitário pode ser adotado para uniformizar os
                    critérios de avaliação entre todos os fiscais, garantir consistência nas inspeções sanitárias e agilizar
                    o processo de fiscalização.</p>
            </div>

            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Seguro</h3>
                <p class="text-muted">Você pode usar nosso sistema sem precisar fornecer seus dados pessoais ou informações
                    do seu órgão.</p>
            </div>
        </div>
    </section>

    <section class="notes-section">
        <div class="row">
            <div class="col-12">
                <p class="text-rodape">* Este sistema utiliza gratuitamente uma API de terceiros para consultar dados
                    cadastrais na Receita Federal do Brasil. Por se tratar de um plano gratuito, estão sujeitas as seguintes
                    condições: <strong>Limitação de consultas:</strong> Máximo de 3 requisições por minuto por IP. Excedendo
                    esse
                    limite, o sistema
                    solicitará que aguarde 1 minuto antes de nova consulta. <strong>Atualização dos dados:</strong> As
                    informações
                    podem apresentar defasagem de até 45 dias em relação à base
                    oficial da Receita Federal. A data da última atualização será exibida junto aos resultados.
                    <strong>Alterações cadastrais são incomuns para a maioria das empresas, portanto a defasagem
                        raramente impacta a utilidade dos dados</strong>. Para detalhes adicionais, consulte os <a class="text-decoration-none" href="#">Termos de
                    uso</a> e <a class="text-decoration-none" href="#">Política de Privacidade</a>.
                </p>
            </div>
        </div>
    </section>
@endsection
