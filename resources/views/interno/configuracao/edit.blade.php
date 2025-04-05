@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-gear me-1"></i>Configurações</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Editar configurações</span>

                <div>
                    <a href="{{ route('configuration.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline"> Voltar</span>
                    </a>
                </div>
            </div>

            <div class="card-body">

                <x-alert />

                <form action="{{ route('configuration.update') }}" method="POST"
                    class="row g-3 needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-sm-6 col-md-4 col-xl-3 mt-3">
                        <label for="versao_sistema" class="form-label mb-1 mandatory">Versão atual: </label>
                        <input class="form-control @error('versao_sistema') is-invalid @enderror" type="text"
                            name="versao_sistema" id="versao_sistema" placeholder="Versão do sistema"
                            value="{{ old('versao_sistema', $configuration->versao_sistema) }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('versao_sistema'))
                                {{ $errors->first('versao_sistema') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-3 mt-3">
                        <label for="usa_api" class="form-label mb-1 mandatory">API ativa: </label>
                        <select class="form-control @error('usa_api') is-invalid @enderror" name="usa_api" id="usa_api">
                            <option value="" @if (old('usa_api', $configuration->usa_api) == '') selected @endif disabled>Selecione
                            </option>
                            <option value="Sim" @if (old('usa_api', $configuration->usa_api) == 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if (old('usa_api', $configuration->usa_api) == 'Não') selected @endif>Não</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('usa_api'))
                                {{ $errors->first('usa_api') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-3 mt-3">
                        <label for="email_sistema" class="form-label mb-1 mandatory">E-mail: </label>
                        <input class="form-control @error('email_sistema') is-invalid @enderror" type="text"
                            name="email_sistema" id="email_sistema" placeholder="E-mail do sistema"
                            value="{{ old('email_sistema', $configuration->email_sistema) }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('email_sistema'))
                                {{ $errors->first('email_sistema') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-3 mt-3">
                        <label for="exibe_card" class="form-label mb-1 mandatory">Exibe cards: </label>
                        <select class="form-control @error('exibe_card') is-invalid @enderror" name="exibe_card" id="exibe_card">
                            <option value="" @if (old('exibe_card', $configuration->exibe_card) == '') selected @endif disabled>Selecione
                            </option>
                            <option value="Sim" @if (old('exibe_card', $configuration->exibe_card) == 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if (old('exibe_card', $configuration->exibe_card) == 'Não') selected @endif>Não</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('exibe_card'))
                                {{ $errors->first('exibe_card') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-3 mt-3">
                        <label for="exibe_info_rodape" class="form-label mb-1 mandatory">Exibe notas (rodapé): </label>
                        <select class="form-control @error('exibe_info_rodape') is-invalid @enderror" name="exibe_info_rodape" id="exibe_info_rodape">
                            <option value="" @if (old('exibe_info_rodape', $configuration->exibe_info_rodape) == '') selected @endif disabled>Selecione
                            </option>
                            <option value="Sim" @if (old('exibe_info_rodape', $configuration->exibe_info_rodape) == 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if (old('exibe_info_rodape', $configuration->exibe_info_rodape) == 'Não') selected @endif>Não</option>
                        </select>
                        <div class="invalid-feedback">
                            @if ($errors->has('exibe_info_rodape'))
                                {{ $errors->first('exibe_info_rodape') }}
                            @endif
                        </div>
                    </div>

                    

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="spinner-success btn btn-outline-success btn-sm" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i> Salvar
                            </button>
                            <a href="{{ route('configuration.index') }}"
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
