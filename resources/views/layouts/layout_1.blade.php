<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Laravel</title>

</head>

<body>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary mb-5">
        <div class="container-fluid">
            <span class="navbar-brand mb-1 h1">CadVisa</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse p-0" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item me-2">
                        <a class="nav-link @if (isset($menu) && $menu === 'home') active @endif" aria-current="page" href="{{ route('home') }}"><i
                                class="fa-solid fa-file-pdf me-1"></i>Gerar roteiro</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#"><i class="fa-solid fa-magnifying-glass me-1"></i>Consultar
                            CNAEs</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#"><i class="fa-solid fa-building me-2"></i>Sobre</a>
                    </li>

                    @if (auth()->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if (isset($menu) && in_array($menu, ['dashboard', 'cnaes'])) active @endif"
                                href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-gear me-1"></i>Administrador
                            </a>
                            <ul class="dropdown-menu p-0 mb-0" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a class="dropdown-item dashboard-item @if (isset($menu) && $menu === 'dashboard') active @endif"
                                        href="{{ route('administrador.index') }}">
                                        <i class="fa-solid fa-gauge me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item cnae-item @if (isset($menu) && $menu === 'cnaes') active @endif" href="{{ route('cnae.index') }}">
                                        <i class="fa-brands fa-creative-commons-share me-1"></i>CNAEs
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
    </main>

    <footer class="footer mt-auto py-2 bg-light border-top">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-muted small pe-2 ms-3">
                <span class="d-none d-md-inline">Copyright © {{ date('Y') }} | CadVisa | Versão 1.0</span>
                <span class="d-inline d-md-none">Copyright © {{ date('Y') }}</span>
            </div>
            <div class="small ps-2 me-3">
                <a href="#" class="text-decoration-none me-2">
                    <span class="d-none d-md-inline">Política de privacidade</span>
                    <span class="d-inline d-md-none">Privacidade</span>
                </a>
                <span class="me-2">|</span>
                <a href="#" class="text-decoration-none">
                    <span class="d-none d-md-inline">Termos de uso</span>
                    <span class="d-inline d-md-none">Termos</span>
                </a>
            </div>
        </div>
    </footer>

</body>

</html>
