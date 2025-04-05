@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-gear me-1"></i>Configurações</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">Configurações do sistema</span>
            </div>

            <div class="card-body">

                <div class="border-bottom mb-3">

                    <div class="col-sm-12 mb-3 text-center">
                        <div class="form-label fw-bold mb-0">Status</div>
                        <span
                            class="badge rounded-pill
                                    @if ($configuration->status_sistema === 'Ativo') bg-success
                                    @elseif($configuration->status_sistema === 'Suspenso') bg-danger @endif">
                            @if ($configuration->status_sistema === 'Ativo')
                                SISTEMA EM OPERAÇÃO
                            @elseif($configuration->status_sistema === 'Suspenso')
                                SISTEMA EM MANTENÇÃO
                            @endif
                        </span>
                    </div>

                    <div class="col-sm-12 mb-3 text-center">
                        <div class="form-label fw-bold mb-0">Versão:</div>
                        <div>{{ $configuration->versao_sistema }}
                        </div>
                    </div>

                </div>

                <x-alert />

                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-1">
                        <span class="fw-medium">API ativa: </span><span>
                            {{ $configuration->usa_api }}</span>
                    </div>

                    <div class="col-sm-12 col-md-6 mb-1">
                        <span class="fw-medium">E-mail: </span><span>
                            {{ $configuration->email_sistema }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-1">
                        <span class="fw-medium">Exibe cards: </span><span>
                            {{ $configuration->exibe_card }}</span>
                    </div>

                    <div class="col-sm-12 col-md-6 mb-1">
                        <span class="fw-medium">Exibe notas (rodapé): </span><span>
                            {{ $configuration->exibe_info_rodape }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center">
                <a href="{{ route('configuration.edit') }}"
                    class="spinner_branco btn btn-outline-primary btn-sm">
                    <i class="fa-regular fa-pen-to-square"></i><span class="d-none d-sm-inline"> Editar</span>
                </a>

                @if ($configuration->status_sistema == 'Ativo')
                    <form action="{{ route('configuration.suspender', ['configuration' => $configuration->id]) }}"
                        method="POST">
                        @csrf
                        @method('POST')
                        <button class="spinner_branco btn btn-outline-danger btn-sm ms-1" type="submit">
                            <i class="fa-solid fa-ban"></i> Suspender sistema
                        </button>
                    </form>
                @else
                    <form action="{{ route('configuration.ativar', ['configuration' => $configuration->id]) }}"
                        method="POST">
                        @csrf
                        @method('POST')
                        <button class="spinner_branco btn btn-outline-success btn-sm ms-1" type="submit">
                            <i class="fa-regular fa-circle-check"></i> Ativar sistema
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
