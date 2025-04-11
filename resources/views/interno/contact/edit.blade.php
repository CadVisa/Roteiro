@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">
        
        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-table-list me-1"></i>Painel de contatos</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Editar contato</span>

                <div>
                    <a href="{{ route('contact.show', ['contato' => $contato->id]) }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline"> Voltar</span>
                    </a>
                </div>
            </div>


            <div class="card-body">

                <x-alert />

                <form action="{{ route('contact.update', ['contato' => $contato->id]) }}" method="POST" class="row g-3 needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-sm-8 col-md-6 mb-1">
                        <span class="fw-medium">Data: </span><span>
                            {{ \Carbon\Carbon::parse($contato->data_mensagem)->format('d/m/Y H:i:s') }}</span>
                    </div>

                    <div class="col-sm-4 col-md-6 mb-1">
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
                                <span class="{{ $icones[$status]['text'] }}"><span class="d-none d-md-inline">{{ $status }}<span></span>
                            @else
                                <div class="text-secondary">Desconhecido</div>
                            @endif
                        </div>
                    </div>                    

                    <div class="col-sm-8 col-md-6 mb-1">
                        <span class="fw-medium">Nome: </span><span>
                            {{ $contato->nome }}</span>
                    </div>

                    <div class="col-sm-8 col-md-6 mb-1">
                        <span class="fw-medium">E-mail: </span><span>
                            {{ $contato->email }}</span>
                    </div>

                    <div class="col-sm-8 mb-1">
                        <span class="fw-medium">Telefone: </span><span>
                            {{ $contato->telefone }}</span>
                    </div>

                    <div class="col-sm-12 col-md-6 mb-1">
                        <span class="fw-medium">E-mail: </span><span>
                            {{ $contato->email }}</span>
                    </div>

                    <div class="col-sm-4 col-md-6 mb-1">
                        <span class="fw-medium">ID: </span><span>
                            #{{ $contato->id }}</span>
                    </div>

                    <div class="col-sm-12 mb-1">
                        <span class="fw-medium">Mensagem: </span><div class="text-justify">
                            {!! nl2br($contato->descricao) !!}</div>
                    </div>

                    <div class="col-md-12 mb-1 mt-3 border-top">
                        <label for="observacoes" class="form-label mb-1 mt-3 mandatory">Observações: </label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" type="text" name="observacoes"
                            id="observacoes" placeholder="Observações da mensagem" autocomplete="off" rows="5">{{ old('observacoes', $contato->observacoes) }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('observacoes'))
                                {{ $errors->first('observacoes') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 col-lg-2 mb-1">
                        <label for="status" class="form-label mb-1 mandatory">Status: </label>
                        <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                            <option value="" @if (old('status') == '') selected @endif disabled>Selecione</option>
                            <option value="Finalizado" @if (old('status', $contato->status) == 'Finalizado') selected @endif>Finalizado</option>
                            <option value="Pendente" @if (old('status', $contato->status) == 'Pendente') selected @endif>Pendente</option>
                            <option value="Visualizado" @if (old('status', $contato->status) == 'Visualizado') selected @endif>Visualizado</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('status'))
                                {{ $errors->first('status') }}
                            @endif
                        </div>
                    </div>                    

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="spinner-success btn btn-outline-success btn-sm" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i><span class="d-none d-sm-inline"> Salvar
                            </button>
                            <a href="{{ route('contact.show', ['contato' => $contato->id]) }}" class="spinner-danger btn btn-outline-danger btn-sm me-1">
                                <i class="fa-solid fa-xmark"></i><span class="d-none d-sm-inline"> Cancelar
                            </a>
                        </div>
                        <div>
                            <small><span class="text-danger">* Campo obrigatório</span></small>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
