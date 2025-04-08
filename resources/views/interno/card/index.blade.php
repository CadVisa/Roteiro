@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-server me-1"></i>Cards</h4>
        </div>

        <div class="card-body">

            <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

                <div
                    class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                    <span>Lista de cards</span>

                    <div>
                        <a href="{{ route('card.create') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-plus"></i>
                            <span class="d-none d-sm-inline"> Adicionar</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($cards->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum card cadastrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Ícone</th>
                                    <th>Título</th>                                    
                                    <th class=" d-none d-sm-table-cell text-center">Ordem</th>
                                    <th class="d-none d-sm-table-cell text-center">Status</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cards as $card)
                                    <tr>
                                        
                                        <td class="text-center">
                                            <i class="{{ $card->card_icone }} fa-lg text-primary"></i>
                                        </td>
                                        <td>
                                            {{ $card->card_titulo }}
                                        </td>
                                        <td class=" d-none d-sm-table-cell text-center">{{ $card->card_ordem }}</td>
                                        <td class="d-none d-sm-table-cell text-center">
                                            <span>
                                                @if ($card->card_status == 'Ativo')
                                                    <i class="fa-solid fa-check text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-xmark text-danger"></i>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('card.show', ['card' => $card->id]) }}" class="spinner-primary btn btn-outline-primary btn-sm"><i
                                                    class="fa-regular fa-folder-open"></i><span class="d-none d-sm-inline">
                                                    Abrir</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cards->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
