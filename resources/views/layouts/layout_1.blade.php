<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $documentoAtual = \App\Models\DocumentoLegal::latest()->first();
    @endphp
    <meta name="versao-termo" content="{{ $documentoAtual->id ?? 0 }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <title>CadVisa</title>

</head>

<body>

    <!-- Spinner full screen oculto por padrão -->
    <div id="preloadOverlay"
        class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-black bg-opacity-75"
        style="z-index: 1050;">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <span class="ms-2 text-warning">Aguarde...</span>
    </div>

    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary mb-5">
        <div class="container-fluid">
            <span class="navbar-brand mb-1 h1">CadVisa</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse p-0" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    @if (session('config')->status_sistema === 'Ativo')
                        <li class="nav-item me-2">
                            <a class="nav-link @if (isset($menu) && $menu === 'home') active @endif" aria-current="page"
                                href="{{ route('home') }}"><i class="fa-solid fa-file-pdf me-1"></i>Gerar roteiro</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link @if (isset($menu) && $menu === 'consulta_cnaes') active @endif"
                                href="{{ route('consulta_cnae.index') }}"><i
                                    class="fa-solid fa-magnifying-glass me-1"></i>Consultar
                                CNAEs</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link @if (isset($menu) && $menu === 'contato') active @endif"
                                href="{{ route('contato.index') }}"><i
                                    class="fa-solid fa-table-list me-2"></i>Contato</a>
                        </li>
                    @endif

                    @if (auth()->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if (isset($menu) &&
                                    in_array($menu, [
                                        'coockies',
                                        'arquivos',
                                        'dashboard',
                                        'cnaes',
                                        'configuracao',
                                        'cards',
                                        'contacts',
                                        'logs',
                                        'empresas',
                                        'documentos',
                                        'cookies',
                                        'acessos',
                                    ])) active @endif"
                                href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">

                                <i class="fa-solid fa-gear me-1"></i>Administrador
                                @if (session('news_contacts') > 0)
                                    <span class="position-absolute badge rounded-pill bg-danger"
                                        style="right: -0.4rem; top: 0rem; font-size: 0.6rem;">
                                        {{ session('news_contacts') }}

                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu p-0 mb-0" aria-labelledby="navbarDropdownMenuLink">
                                <li class="border-top">
                                    <a class="dropdown-item dashboard-item @if (isset($menu) && $menu === 'dashboard') active @endif"
                                        href="{{ route('administrador.index') }}">
                                        <i class="fa-solid fa-gauge me-1"></i>Dashboard
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'contacts') active @endif"
                                        href="{{ route('contact.index') }}">
                                        <i class="fa-solid fa-table-list me-1"></i>Contatos

                                        @if (session('news_contacts') > 0)
                                            <span class="badge rounded-pill bg-danger"
                                                style="right: 0.2rem; top: -0.5rem; font-size: 0.6rem; position:relative;">{{ session('news_contacts') }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'empresas') active @endif"
                                        href="{{ route('empresa.index') }}">
                                        <i class="fa-solid fa-building me-1"></i>Empresas
                                    </a>
                                </li>


                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'cnaes') active @endif"
                                        href="{{ route('cnae.index') }}">
                                        <i class="fa-brands fa-creative-commons-share me-1"></i>CNAEs
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'acessos') active @endif"
                                        href="{{ route('acesso.index') }}">
                                        <i class="fa-solid fa-eye me-1"></i>Acessos
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'logs') active @endif"
                                        href="{{ route('log.index') }}">
                                        <i class="fa-solid fa-user-secret me-1"></i>Auditoria
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'arquivos') active @endif"
                                        href="{{ route('arquivo.index') }}">
                                        <i class="fa-solid fa-database me-1"></i>Arquivos
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'cookies') active @endif"
                                        href="{{ route('cookie.index') }}">
                                        <i class="fa-solid fa-cookie-bite me-1"></i>Cookies
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'cards') active @endif"
                                        href="{{ route('card.index') }}">
                                        <i class="fa-solid fa-server me-1"></i>Cards
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'documentos') active @endif"
                                        href="{{ route('documento.index') }}">
                                        <i class="fa-solid fa-file-lines me-1"></i>Documentos
                                    </a>
                                </li>

                                <li class="border-top">
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'configuracao') active @endif"
                                        href="{{ route('configuration.index') }}">
                                        <i class="fa-solid fa-gear me-1"></i>Configurações
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif
                </ul>

                @if (!auth()->check())
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fa-solid fa-lock"></i>
                                <span class="d-inline d-md-none ms-1">Entrar</span>
                            </a>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-user"></i>
                                <span class="d-inline d-md-none ms-1">Minha Conta</span>
                            </a>
                        </li>
                        <li><a class="nav-link" href="{{ route('logout') }}"><i
                                    class="fa-solid fa-power-off me-1"></i><span
                                    class="d-inline d-md-none ms-1">Sair</span></a></li>
                    </ul>
                @endif

            </div>
        </div>
    </nav>

    <main class="flex-grow-1">



        <div class="container-fluid" style="margin-top: 70px">
            @yield('content')
        </div>

        <div id="cookie-consent" class="alert alert-dark text-center fixed-bottom mb-0 small"
            style="display: none; z-index: 9999;">
            <div class="container py-2">
                <div class="row align-items-center text-start text-md-center">
                    <div class="col-12 col-sm-8 mb-2 mb-md-0">
                        <i class="fa-solid fa-cookie-bite me-2"></i>
                        O CadVisa utiliza cookies para melhorar sua experiência. Para maiores informações, consulte
                        nossa
                        <a href="{{ route('politica_privacidade') }}" class="text-decoration-none"
                            target="_blank">Política de privacidade</a> e
                        nossos
                        <a href="{{ route('termos_uso') }}" class="text-decoration-none" target="_blank">Termos de
                            uso</a>.
                    </div>
                    <div class="col-12 col-sm-4 text-center text-md-end">
                        <div
                            class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end gap-2">
                            <button class="btn btn-secondary btn-sm " id="declineCookies">Recusar</button>
                            <button class="btn btn-primary btn-sm" id="acceptCookies">Aceitar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-2 bg-light border-top">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-muted small pe-2 ms-3">
                <span class="d-none d-md-inline">Copyright © {{ date('Y') }} | CadVisa |
                    {{ session('config')->versao_sistema }}</span>
                <span class="d-inline d-md-none">Copyright © {{ date('Y') }}</span>
            </div>
            @if (session('config')->status_sistema === 'Ativo')
                <div class="small ps-2 me-3">
                    <a href="{{ route('termos_uso') }}" class="text-decoration-none">
                        <span class="d-inline d-md-none">Termos</span>
                        <span class="d-none d-md-inline">Termos de uso</span>
                    </a>
                    <span class="me-2">|</span>
                    <a href="{{ route('politica_privacidade') }}" class="text-decoration-none me-2">
                        <span class="d-inline d-md-none">Privacidade</span>
                        <span class="d-none d-md-inline">Política de privacidade</span>
                    </a>

                </div>
            @endif
        </div>
    </footer>

</body>

</html>
