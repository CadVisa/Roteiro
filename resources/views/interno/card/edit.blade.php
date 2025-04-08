@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">
        
        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-server me-1"></i>Cards</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Editar card</span>

                <div>
                    <a href="{{ route('card.show', ['card' => $card->id]) }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline"> Voltar</span>
                    </a>
                </div>
            </div>


            <div class="card-body">

                <x-alert />

                <form action="{{ route('card.update', ['card' => $card->id]) }}" method="POST" class="row g-3 needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-sm-12">
                        <label for="card_titulo" class="form-label mb-1 mandatory">Título: </label>
                        <input class="form-control @error('card_titulo') is-invalid @enderror" type="text"
                            name="card_titulo" id="card_titulo" placeholder="Título do card"
                            value="{{ old('card_titulo', $card->card_titulo) }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('card_titulo'))
                                {{ $errors->first('card_titulo') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="card_descricao" class="form-label mb-1 mandatory">Descrição: </label>
                        <textarea class="form-control @error('card_descricao') is-invalid @enderror" type="text" name="card_descricao"
                            id="card_descricao" placeholder="Descrição do card" autocomplete="off">{{ old('card_descricao', $card->card_descricao) }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('card_descricao'))
                                {{ $errors->first('card_descricao') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="card_icone" class="form-label mb-1 mandatory">Ícone: </label>
                        <input class="form-control @error('card_icone') is-invalid @enderror" type="text"
                            name="card_icone" id="card_icone" placeholder="Ícone do card"
                            value="{{ old('card_icone', $card->card_icone) }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('card_icone'))
                                {{ $errors->first('card_icone') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="card_ordem" class="form-label mb-1 mandatory">Ordem: </label>
                        <input class="form-control @error('card_ordem') is-invalid @enderror" type="number"
                            name="card_ordem" id="card_ordem" placeholder="Ordem do card"
                            value="{{ old('card_ordem', $card->card_ordem) }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('card_ordem'))
                                {{ $errors->first('card_ordem') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="card_status" class="form-label mb-1 mandatory">Status: </label>
                        <select class="form-control @error('card_status') is-invalid @enderror" name="card_status" id="card_status">
                            <option value="" @if (old('card_status') == '') selected @endif disabled>Selecione</option>
                            <option value="Ativo" @if (old('card_status', $card->card_status) == 'Ativo') selected @endif>Ativo</option>
                            <option value="Inativo" @if (old('card_status', $card->card_status) == 'Inativo') selected @endif>Inativo</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('card_status'))
                                {{ $errors->first('card_status') }}
                            @endif
                        </div>
                    </div>                    

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="spinner-success btn btn-outline-success btn-sm" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i><span class="d-none d-sm-inline"> Salvar
                            </button>
                            <a href="{{ route('card.show', ['card' => $card->id]) }}" class="spinner-danger btn btn-outline-danger btn-sm me-1">
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
