@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 d-flex justify-content-between align-items-center text-primary">
            <h4 class="ms-2">
                <i class="fa-solid fa-gauge me-1"></i>Dashboard
            </h4>

            @if ($statusSistema == 'Ativo')
                <div class="alert alert-success py-1 px-2 mb-0 d-flex align-items-center" title="Sistema ativo">
                    <i class="fas fa-circle me-2 small"></i>
                    <span class="small">Normal</span>
                </div>
            @else
                <div class="alert alert-danger py-1 px-2 mb-0 d-flex align-items-center" title="Sistema suspenso">
                    <i class="fas fa-circle-exclamation me-2 small"></i>
                    <span class="small">Suspenso</span>
                </div>
            @endif
        </div>


        <div class="row g-3">

            {{-- OK Logs do sistema --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow-sm h-100 rounded-3">
                    <div
                        class="card-header bg-primary text-light d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="fw-semibold">OK - Logs do sistema</span>
                        <a href="{{ route('log.index') }}" class="text-decoration-none" title="Total de logs do sistema"><span
                                class="badge bg-light text-primary fw-bold px-2 py-1">{{ number_format($logsSistema, 0, ',', '.') }}</span></a>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap justify-content-between text-center gap-2">
                            <div class="flex-fill">
                                <a href="{{ route('log.index', ['nivel_pesquisa' => 3]) }}" class="text-decoration-none" title="Críticos">
                                    <div class="text-danger">
                                        <i class="fas fa-triangle-exclamation"></i>
                                        <span class="fw-semibold">{{ number_format($logs_3, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{ route('log.index', ['nivel_pesquisa' => 2]) }}" class="text-decoration-none" title="Importantes">
                                    <div class="text-warning">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span class="fw-semibold">{{ number_format($logs_2, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{ route('log.index', ['nivel_pesquisa' => 1]) }}" class="text-decoration-none" title="Normais">
                                    <div class="text-primary">
                                        <i class="fas fa-circle-info"></i>
                                        <span class="fw-semibold">{{ number_format($logs_1, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{ route('log.index', ['nivel_pesquisa' => 4]) }}" class="text-decoration-none" title="Resolvidos">
                                    <div class="text-success">
                                        <i class="fas fa-circle-check"></i>
                                        <span class="fw-semibold">{{ number_format($logs_4, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- OK Contatos --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow-sm h-100 rounded-3">
                    <div
                        class="card-header bg-primary text-light d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="fw-semibold">OK - Contatos</span>
                        <a href="{{ route('contact.index') }}" class="text-decoration-none" title="Total de contatos recebidos"><span
                                class="badge bg-light text-primary fw-bold px-2 py-1">{{ number_format($contatos, 0, ',', '.') }}</span></a>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap justify-content-between text-center gap-2">
                            <div class="flex-fill">
                                <a href="{{ route('contact.index', ['status_pesquisa' => 'Pendente']) }}" class="text-decoration-none" title="Novos">
                                    <div class="text-danger">
                                        <i class="fas fa-triangle-exclamation"></i>
                                        <span class="fw-semibold">{{ number_format($contatosNovos, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{ route('contact.index', ['status_pesquisa' => 'Visualizado']) }}" class="text-decoration-none" title="Visualizados">
                                    <div class="text-primary">
                                        <i class="fas fa-circle-info"></i>
                                        <span
                                            class="fw-semibold">{{ number_format($contatosVisualizados, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{ route('contact.index', ['status_pesquisa' => 'Finalizado']) }}" class="text-decoration-none" title="Finalizados">
                                    <div class="text-success">
                                        <i class="fas fa-circle-check"></i>
                                        <span
                                            class="fw-semibold">{{ number_format($contatosFinalizados, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- OK CNAEs --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow-sm h-100 rounded-3">
                    <div
                        class="card-header bg-primary text-light d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="fw-semibold">OK - Atividades econômicas</span>
                        <a href="{{ route('cnae.index') }}" class="text-decoration-none" title="Total de atividades econômicas"><span
                                class="badge bg-light text-primary fw-bold px-2 py-1">{{ number_format($cnaes, 0, ',', '.') }}</span></a>
                    </div>
                    
                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap justify-content-between text-center gap-2">

                            <div class="flex-fill">
                                <a href="{{ route('cnae.index', ['revisao_pesquisa' => 2]) }}" class="text-decoration-none" title="Sem revisão">
                                    <div class="text-danger">
                                        <i class="fas fa-triangle-exclamation"></i>
                                        <span class="fw-semibold">{{ number_format($cnaesSemRevisao, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{ route('cnae.index', ['revisao_pesquisa' => 1]) }}" class="text-decoration-none" title="Revisadas">
                                    <div class="text-success">
                                        <i class="fas fa-circle-check"></i>
                                        <span class="fw-semibold">{{ number_format($cnaesRevisados, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Empresas --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow-sm h-100 rounded-3">
                    <div
                        class="card-header bg-primary text-light d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="fw-semibold">Empresas</span>
                        <a href="#" class="text-decoration-none" title="Total de empresas cadastradas"><span
                                class="badge bg-light text-primary fw-bold px-2 py-1">{{ number_format($empresas, 0, ',', '.') }}</span></a>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap justify-content-between text-center gap-2">

                            <div class="flex-fill">

                                <a href="#" class="text-decoration-none" title="Empresas sem roteiro gerado">
                                    <div class="text-danger">
                                        <i class="fa-solid fa-file-circle-exclamation"></i>
                                        <span
                                            class="fw-semibold">{{ number_format($empresasSemRoteiro, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="#" class="text-decoration-none" title="Empresas com roteiro gerado">
                                    <div class="text-success">
                                        <i class="fa-solid fa-file-circle-check"></i>
                                        <span class="fw-semibold">{{ number_format($empresasComRoteiro, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gestão de arquivos --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow-sm h-100 rounded-3">
                    <div
                        class="card-header bg-primary text-light d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="fw-semibold">Gestão de arquivos</span>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap justify-content-between text-center gap-2">

                            <div class="flex-fill" title="Nº de roteiros no servidor">
                                <div class="text-primary">
                                    <i class="fa-solid fa-copy"></i>
                                    <span class="fw-semibold">{{ number_format($quantidadeArquivos, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex-fill" title="Espaço ocupado no servidor">
                                <div class="text-primary">
                                    <i class="fa-solid fa-database"></i>
                                    <span class="fw-semibold">{{ $tamanhoTotalMB }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cookies --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow-sm h-100 rounded-3">
                    <div
                        class="card-header bg-primary text-light d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="fw-semibold">Cookies</span>
                        <a href="#" class="text-decoration-none" title="Total de cookies"><span
                                class="badge bg-light text-primary fw-bold px-2 py-1">{{ number_format($consents, 0, ',', '.') }}</span></a>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap justify-content-between text-center gap-2">

                            <div class="flex-fill">

                                <a href="#" class="text-decoration-none" title="Recusados">
                                    <div class="text-danger">
                                        <i class="fa-solid fa-xmark"></i>
                                        <span class="fw-semibold">{{ $accepted_0 }}</span>
                                    </div>
                                </a>
                            </div>

                            <div class="flex-fill">
                                <a href="#" class="text-decoration-none" title="Aceitos">
                                    <div class="text-success">
                                        <i class="fas fa-circle-check"></i>
                                        <span class="fw-semibold">{{ $accepted_1 }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3 mb-3">
            {{-- Card 1 - Acessos únicos nos últimos 10 dias --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow h-100">
                    <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                        <span>Acessos únicos - últimos 10 dias</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($acessosPorDia as $acesso)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if ($acesso['total'] > 0)
                                        <div>
                                            <a href="#"
                                                class="text-decoration-none">{{ \Carbon\Carbon::parse($acesso['data'])->format('d/m') }}
                                                <small style="font-size: 0.7rem">
                                                    ({{ ucfirst(\Carbon\Carbon::parse($acesso['data'])->translatedFormat('l')) }})
                                                </small>
                                            </a>
                                        </div>
                                    @else
                                        <div>
                                            {{ \Carbon\Carbon::parse($acesso['data'])->format('d/m') }}
                                            <small style="font-size: 0.7rem">
                                                ({{ ucfirst(\Carbon\Carbon::parse($acesso['data'])->translatedFormat('l')) }})</small>
                                        </div>
                                    @endif


                                    @if ($acesso['total'] > 0)
                                        <a href="#" class="text-decoration-none"><span
                                                class="badge bg-primary rounded-3 ms-2">{{ number_format($acesso['total'], 0, ',', '.') }}</span></a>
                                    @else
                                        <span
                                            class="badge bg-primary rounded-3 ms-2">{{ number_format($acesso['total'], 0, ',', '.') }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Card 2 - Cidades mais pesquisadas --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow h-100">
                    <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                        <span>Cidades mais consultadas</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($cidadesMaisFrequentes as $cidade)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">{{ $cidade->cidade }}</a>

                                    <a href="#" class="text-decoration-none"><span
                                            class="badge bg-primary rounded-3">{{ number_format($cidade->total, 0, ',', '.') }}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Card 3 - IPs com mais consultas --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-primary shadow h-100">
                    <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                        <span>IPs com mais consultas</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($ipsMaisFrequentes as $cliente)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-truncate text-decoration-none"
                                        title="{{ $cliente->criado_por }}">{{ $cliente->criado_por }}</a>
                                    <a href="#" class="text-decoration-none"><span
                                            class="badge bg-primary rounded-3 ms-2">{{ number_format($cliente->total, 0, ',', '.') }}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
