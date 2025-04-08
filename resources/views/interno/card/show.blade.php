@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-server me-1"></i>Cards</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">

                <span class="me-auto">Detalhes do card</span>

                <div class="d-flex align-items-center gap-2">
                    <span>
                        <a href="{{ route('card.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="d-none d-sm-inline">Voltar</span>
                        </a>
                    </span>

                    <span>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i>
                                <span class="d-none d-sm-inline">Menu</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('card.edit', $card->id) }}">
                                        <i class="fa-regular fa-pen-to-square"></i> Editar
                                    </a></li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal-{{ $card->id }}">
                                        <i class="fa-regular fa-trash-can"></i> Excluir
                                    </a></li>
                            </ul>
                        </div>
                    </span>
                </div>
            </div>

            <div class="card-body">

                <x-alert />

                <div class="row">
                    <div class="justify-content-center text-center mb-3">
                        <span><i class="{{ $card->card_icone }} fa-5x text-primary"></i></span>
                    </div>
                    <div class="col-12 mb-3">
                        <span class="fw-bold">Título:</span><span> {{ $card->card_titulo }}</span>
                    </div>
                    <div class="col-12 mb-3 text-justify">
                        <span class="fw-bold">Descrição:</span><span> {{ $card->card_descricao }}</span>
                    </div>
                    <div class="col-6 mb-3">
                        <span class="fw-bold">Ordem:</span><span> {{ $card->card_ordem }}</span>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <span class="fw-bold">Status:</span><span> {{ $card->card_status }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EXCLUIR CARD --}}
        <div class="modal fade" id="deleteModal-{{ $card->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel-{{ $card->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-light bg-danger">
                        <h6 class="modal-title" id="deleteModalLabel-{{ $card->id }}">Deseja realmente excluir este
                            card?
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-12 mb-3">
                                <div class="form-label fw-bold mb-0">Título:</div>
                                <div class="text-justify">{{ $card->card_titulo }}</div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-label fw-bold mb-0">Descrição:</div>
                                <div class="text-justify">{{ $card->card_descricao }}</div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <span class="text-center text-danger fw-bold">Essa ação é irreversível!</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('card.destroy', ['card' => $card->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="spinner-danger btn btn-sm btn-outline-danger"><i
                                    class="fa-regular fa-trash-can"></i>
                                Excluir</button>
                        </form>
                        <button type="button" id="closeModal" class="spinner-secondary btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal"> <i class="fa-solid fa-xmark"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
