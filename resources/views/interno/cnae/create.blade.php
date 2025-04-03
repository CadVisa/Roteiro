@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">
        
        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-brands fa-creative-commons-share me-1"></i>Atividades Econômicas</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Nova atividade econômica</span>

                <div>
                    <a href="{{ route('cnae.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline"> Voltar</span>
                    </a>
                </div>
            </div>


            <div class="card-body">

                <x-alert />

                <form action="{{ route('cnae.store') }}" method="POST" class="row g-3 needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <label for="codigo_cnae" class="form-label mb-1 mandatory">Código: </label>
                        <input class="form-control @error('codigo_cnae') is-invalid @enderror" type="text"
                            name="codigo_cnae" id="codigo_cnae" placeholder="Código do CNAE"
                            value="{{ old('codigo_cnae') }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('codigo_cnae'))
                                {{ $errors->first('codigo_cnae') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="descricao_cnae" class="form-label mb-1 mandatory">Descrição: </label>
                        <textarea class="form-control @error('descricao_cnae') is-invalid @enderror" type="text" name="descricao_cnae"
                            id="descricao_cnae" placeholder="Descrição do CNAE" autocomplete="off">{{ old('descricao_cnae') }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('descricao_cnae'))
                                {{ $errors->first('descricao_cnae') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-3">
                        <label for="competencia" class="form-label mb-1 mandatory">Competência: </label>
                        <select class="form-control @error('competencia') is-invalid @enderror" name="competencia" id="competencia">
                            <option value="" @if (old('competencia') == '') selected @endif disabled>Selecione</option>
                            <option value="Municipal" @if (old('competencia') == 'Municipal') selected @endif>Municipal</option>
                            <option value="Estadual" @if (old('competencia') == 'Estadual') selected @endif>Estadual</option>                            
                            <option value="Depende de informação" @if (old('competencia') == 'Depende de informação') selected @endif>Depende de informação</option>
                            <option value="CNAE isento" @if (old('competencia') == 'CNAE isento') selected @endif>Isento</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('competencia'))
                                {{ $errors->first('competencia') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-3">
                        <label for="grau_cnae" class="form-label mb-1 mandatory">Grau de risco: </label>
                        <select class="form-control @error('grau_cnae') is-invalid @enderror" name="grau_cnae" id="grau_cnae">
                            <option value="" @if (old('grau_cnae') == '') selected @endif disabled>Selecione</option>
                            <option value="Baixo risco" @if (old('grau_cnae') == 'Baixo risco') selected @endif>Baixo risco</option>
                            <option value="Médio risco" @if (old('grau_cnae') == 'Médio risco') selected @endif>Médio risco</option>
                            <option value="Alto risco" @if (old('grau_cnae') == 'Alto risco') selected @endif>Alto risco</option>
                            <option value="Depende de informação" @if (old('grau_cnae') == 'Depende de informação') selected @endif>Depende de informação</option>
                            <option value="CNAE isento" @if (old('grau_cnae') == 'CNAE isento') selected @endif>Isento</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('grau_cnae'))
                                {{ $errors->first('grau_cnae') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="notas_s_compreende" class="form-label mb-1">Essa atividade compreende: </label>
                        <textarea class="form-control @error('notas_s_compreende') is-invalid @enderror" type="text"
                            name="notas_s_compreende" id="notas_s_compreende" placeholder="Notas explicativas - atividade compreende" autocomplete="off">{{ old('notas_s_compreende') }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('notas_s_compreende'))
                                {{ $errors->first('notas_s_compreende') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="notas_n_compreende" class="form-label mb-1">Essa atividade não compreende: </label>
                        <textarea class="form-control @error('notas_n_compreende') is-invalid @enderror" type="text"
                            name="notas_n_compreende" id="notas_n_compreende" placeholder="Notas explicativas - atividade não compreende" autocomplete="off">{{ old('notas_n_compreende') }}</textarea>
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
                            <a href="{{ route('cnae.index') }}" class="spinner-danger btn btn-outline-danger btn-sm me-1">
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
