@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-brands fa-creative-commons-share me-1"></i>Atividades Econômicas</h4>
        </div>

        <div class="card border-primary mb-3 mt-3 border-ligth shadow col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Editar notas explicativas</span>

                <div>
                    <a href="{{ route('cnae.show', ['cnae' => $cnae->id]) }}"
                        class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline"> Voltar</span>
                    </a>
                </div>
            </div>


            <div class="card-body">

                <x-alert />

                <form action="{{ route('cnae.update-notas', ['cnae' => $cnae->id]) }}" method="POST"
                    class="row needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Código:</span><span> {{ $cnae->codigo_cnae }}</span>
                    </div>

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Descrição:</span><span> {{ $cnae->descricao_cnae }}</span>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="notas_s_compreende" class="form-label mb-1">Essa atividade compreende: </label>
                        <textarea class="form-control @error('notas_s_compreende') is-invalid @enderror" type="text"
                            name="notas_s_compreende" id="notas_s_compreende" placeholder="Notas explicativas - atividade compreende"
                            autocomplete="off">{{ old('notas_s_compreende', $cnae->notas_s_compreende) }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('notas_s_compreende'))
                                {{ $errors->first('notas_s_compreende') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="notas_n_compreende" class="form-label mb-1">Essa atividade não compreende: </label>
                        <textarea class="form-control @error('notas_n_compreende') is-invalid @enderror" type="text"
                            name="notas_n_compreende" id="notas_n_compreende" placeholder="Notas explicativas - atividade não compreende"
                            autocomplete="off">{{ old('notas_n_compreende', $cnae->notas_n_compreende) }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('notas_n_compreende'))
                                {{ $errors->first('notas_n_compreende') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="spinner-success btn btn-outline-success btn-sm" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i> Salvar
                            </button>
                            <a href="{{ route('cnae.show', ['cnae' => $cnae->id]) }}"
                                class="spinner-danger btn btn-outline-danger btn-sm me-1">
                                <i class="fa-solid fa-xmark"></i> Cancelar
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
