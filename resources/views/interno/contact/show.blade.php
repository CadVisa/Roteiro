@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-table-list me-1"></i>Painel de contatos</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">Informações do contato</span>
                <div>
                    <a href="{{ route('contact.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline">Voltar</span>
                    </a>

                    <a href="{{ route('contact.edit', $contato->id) }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-regular fa-pen-to-square"></i>
                        <span class="d-none d-sm-inline">Editar</span>
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-6 col-sm-6 mb-1">
                        <span class="fw-medium">ID: </span><span>
                            #{{ $contato->id }}</span>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 mb-1">
                        @php
                            $icones = [
                                'Finalizado' => [
                                    'icone' => 'fa-check',
                                    'cor' => 'text-success',
                                    'text' => 'text-success',
                                ],
                                'Pendente' => [
                                    'icone' => 'fa-triangle-exclamation',
                                    'cor' => 'text-danger',
                                    'text' => 'text-danger',
                                ],
                                'Visualizado' => [
                                    'icone' => 'fa-eye',
                                    'cor' => 'text-primary',
                                    'text' => 'text-primary',
                                ],
                            ];

                            $status = $contato->status;
                        @endphp

                        <div class="d-flex align-items-center gap-2">
                            <div class="fw-medium">Status:</div>
                            @if (isset($icones[$status]))
                                <i class="fa-solid {{ $icones[$status]['icone'] }} {{ $icones[$status]['cor'] }}"></i>
                                <span class="{{ $icones[$status]['text'] }}"><span
                                        class="d-none d-md-inline">{{ $status }}<span></span>
                                    @else
                                        <div class="text-secondary">Desconhecido</div>
                            @endif
                        </div>
                    </div>


                    <div class="col-12 mb-1">
                        <span class="fw-medium">Data: </span><span>
                            {{ \Carbon\Carbon::parse($contato->data_mensagem)->format('d/m/Y H:i:s') }}</span>
                    </div>



                    <div class="col-sm-6 mb-1">
                        <span class="fw-medium">Nome: </span><span>
                            {{ $contato->nome }}</span>
                    </div>

                    <div class="col-sm-6 mb-1">
                        <span class="fw-medium">E-mail: </span><span>
                            {{ $contato->email }}</span>
                    </div>

                    <div class="col-sm-6 mb-1">
                        <span class="fw-medium">Telefone: </span><span>
                            {{ $contato->telefone }}</span>
                    </div>

                    <div class="col-sm-6 mb-1">
                        <span class="fw-medium">IP: </span><span>
                            {{ $contato->ip }}</span>
                    </div>

                    <div class="col-sm-12 mb-1">
                        <span class="fw-medium">Mensagem: </span>
                        <div class="text-justify">
                            {!! nl2br($contato->descricao) !!}</div>
                    </div>

                    <div class="col-sm-12 mb-1 mt-3 border-top">
                        <div class="fw-medium mt-3">Observações: </div>
                        <div class="text-justify">
                            {!! nl2br($contato->observacoes ?? 'Sem observações') !!}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">Auditoria</span>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-12 mb-1">
                        <span class="fw-medium">Empresas cadastradas: </span>
                        @if ($n_empresas > 0)
                            <a class="text-decoration-none"
                                href="{{ route('empresa.index', ['ip_pesquisa' => $contato->ip]) }}">{{ $n_empresas }}</a>
                        @else
                            Sem informações
                        @endif

                    </div>

                    <div class="col-12 mb-1">
                        <span class="fw-medium">Roteiro gerados: </span>
                        @if ($n_roteiros > 0)
                            <a class="text-decoration-none"
                                href="{{ route('empresa.index', ['ip_pesquisa' => $contato->ip, 'roteiro_pesquisa' => 1]) }}">{{ $n_roteiros }}</a>
                        @else
                            Sem informações
                        @endif
                    </div>

                    <div class="col-12 mb-1">
                        <span class="fw-medium">Roteiro não gerados: </span>
                        @if ($n_sem_roteiro > 0)
                            <a class="text-decoration-none"
                                href="{{ route('empresa.index', ['ip_pesquisa' => $contato->ip, 'roteiro_pesquisa' => 2]) }}">{{ $n_sem_roteiro }}</a>
                        @else
                            Sem informações
                        @endif
                    </div>

                    @php
                        $cidadesArray = $cidades->toArray();
                        $count = count($cidadesArray);

                        $cidadesLinks = collect($cidadesArray)
                            ->map(function ($cidade) use ($contato) {
                                return '<a class="text-decoration-none" href="' .
                                    route('empresa.index', [
                                        'ip_pesquisa' => $contato->ip,
                                        'cidade_pesquisa' => $cidade,
                                    ]) .
                                    '">' .
                                    e($cidade) .
                                    '</a>';
                            })
                            ->toArray();
                    @endphp

                    <div class="col-12 mb-1">
                        <span class="fw-medium">Cidades consultadas: </span>

                        @if ($count === 1)
                            {!! $cidadesLinks[0] !!}.
                        @elseif ($count === 2)
                            {!! $cidadesLinks[0] . ' e ' . $cidadesLinks[1] !!}.
                        @elseif ($count > 2)
                            {!! implode(', ', array_slice($cidadesLinks, 0, -1)) . ' e ' . $cidadesLinks[$count - 1] !!}.
                        @else
                            Nenhuma cidade consultada.
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
