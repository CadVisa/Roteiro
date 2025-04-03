@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">
        
        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-brands fa-creative-commons-share me-1"></i>Atividades Econômicas</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Nova pergunta</span>

                <div>
                    <a href="{{ route('cnae.show', ['cnae' => $cnae->id]) }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline"> Voltar</span>
                    </a>
                </div>
            </div>


            <div class="card-body">

                <x-alert />

                <form action="{{ route('cnae.store-question', ['cnae' => $cnae->id]) }}" method="POST" class="row needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Código:</span><span> {{ $cnae->codigo_cnae }}</span>
                    </div>

                    <div class="col-12 mb-3">
                        <span class="fw-bold">Descrição:</span><span> {{ $cnae->descricao_cnae }}</span>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="pergunta" class="form-label mb-1 mandatory">Pergunta: </label>
                        <textarea class="form-control @error('pergunta') is-invalid @enderror" type="text" name="pergunta"
                            id="pergunta" placeholder="Descrição da pergunta" autocomplete="off">{{ old('pergunta') }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('pergunta'))
                                {{ $errors->first('pergunta') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                        <label for="competencia" class="form-label mb-1 mandatory">Competência: </label>
                        <select class="form-control @error('competencia') is-invalid @enderror" name="competencia" id="competencia">
                            <option value="" @if (old('competencia') == '') selected @endif disabled>Selecione</option>
                            <option value="Municipal" @if (old('competencia') == 'Municipal') selected @endif>Municipal</option>
                            <option value="Estadual" @if (old('competencia') == 'Estadual') selected @endif>Estadual</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('competencia'))
                                {{ $errors->first('competencia') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                        <label for="grau_sim" class="form-label mb-1 mandatory">Grau sim: </label>
                        <select class="form-control @error('grau_sim') is-invalid @enderror" name="grau_sim" id="grau_sim">
                            <option value="" @if (old('grau_sim') == '') selected @endif disabled>Selecione</option>
                            <option value="Baixo risco" @if (old('grau_sim') == 'Baixo risco') selected @endif>Baixo risco</option>
                            <option value="Médio risco" @if (old('grau_sim') == 'Médio risco') selected @endif>Médio risco</option>
                            <option value="Alto risco" @if (old('grau_sim') == 'Alto risco') selected @endif>Alto risco</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('grau_sim'))
                                {{ $errors->first('grau_sim') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                        <label for="grau_nao" class="form-label mb-1 mandatory">Grau não: </label>
                        <select class="form-control @error('grau_nao') is-invalid @enderror" name="grau_nao" id="grau_nao">
                            <option value="" @if (old('grau_nao') == '') selected @endif disabled>Selecione</option>
                            <option value="Baixo risco" @if (old('grau_nao') == 'Baixo risco') selected @endif>Baixo risco</option>
                            <option value="Médio risco" @if (old('grau_nao') == 'Médio risco') selected @endif>Médio risco</option>
                            <option value="Alto risco" @if (old('grau_nao') == 'Alto risco') selected @endif>Alto risco</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('grau_nao'))
                                {{ $errors->first('grau_nao') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="spinner-success btn btn-outline-success btn-sm" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i> Salvar
                            </button>
                            <a href="{{ route('cnae.show', ['cnae' => $cnae->id]) }}" class="spinner-danger btn btn-outline-danger btn-sm me-1">
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
