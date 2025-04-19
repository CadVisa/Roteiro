@extends('layouts.layout_1')

@section('content')
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic">Política de privacidade</p>
        </div>
    </section>

    <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

        <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
            <span class="me-auto">Conheça nossa política de privacidade</span>
        </div>

        <div class="card-body">

            <div class="card-body">
                <h5 class="card-title">Política de Privacidade</h5>
                <p class="card-text">
                    A presente Política de Privacidade tem por finalidade esclarecer como os dados eventualmente coletados
                    são tratados:
                </p>

                <h6 class="mt-4">1. Quais dados são coletados</h6>
                <ul>
                    <li><span class="fw-medium">CNPJ informado:</span> utilizado apenas para busca das informações públicas
                        do
                        estabelecimento.</li>
                    <li><span class="fw-medium">IP do usuário:</span> coletado com a finalidade de identificar padrões de
                        uso e evitar
                        abusos no sistema.</li>
                    <li><span class="fw-medium">Informações da empresa consultada:</span> armazenada de forma estatística
                        para análises
                        de interesse regional e sugestões personalizadas. Além de servir para futuras implementações no
                        sistema, como a composição de uma base de dados consistente.</li>
                    <li><span class="fw-medium">E-mail e telefone do usuário:</span> quando o usuário entrar em contato,
                        estes dados são armazenados para possibilitar retorno de eventual solicitação.</li>
                </ul>

                <h6 class="mt-4">2. Finalidade da coleta de dados</h6>
                <ul>
                    <li>Aperfeiçoar a experiência do usuário, como sugerir soluções personalizadas quando há múltiplas
                        pesquisas em uma mesma cidade.</li>
                    <li>Monitorar e prevenir uso indevido ou excessivo da plataforma.</li>
                    <li>Elaborar estatísticas de uso para fins de melhoria contínua do sistema.</li>
                </ul>

                <h6 class="mt-4">3. Compartilhamento de dados</h6>
                <p>
                    Não compartilhamos, vendemos ou divulgamos os dados coletados com terceiros, exceto quando exigido por
                    lei ou por ordem judicial.
                </p>

                <h6 class="mt-4">4. Armazenamento e segurança</h6>
                <p>
                    Os dados são armazenados em servidores com acesso restrito e protegidos por medidas de segurança
                    compatíveis com as boas práticas de proteção da informação.
                </p>

                <h6 class="mt-4">5. Seus direitos</h6>
                <p>Você tem o direito de:</p>
                <ul>
                    <li>Solicitar a exclusão de seus dados pessoais coletados (ex: IP).</li>
                    <li>Obter informações sobre como seus dados são tratados.</li>
                    <li>Revogar o consentimento, quando aplicável.</li>
                </ul>
                <p>
                    Para exercer esses direitos, entre em contato preenchendo este <a class="text-decoration-none"
                        href="{{ route('contato.index') }}">formulário</a>.
                </p>

                <h6 class="mt-4">6. Cookies</h6>
                <p>
                    Este sistema não utiliza cookies de rastreamento nem identifica usuários de forma direta.
                </p>

                <h6 class="mt-4">7. Atualizações da política</h6>
                <p>
                    Reservamo-nos o direito de alterar esta Política de Privacidade a qualquer momento. A versão atualizada
                    estará sempre disponível nesta página.
                </p>

                <p class="text-muted small">Última atualização: 05/04/2025.</p>
            </div>

        </div>
    </div>
@endsection
