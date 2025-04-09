@extends('layouts.layout_1')

@section('content')
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic">Entre em contato! Sua mensagem é muito importante para nós...</p>
            <div class="base-cv">Resolução SES/RJ nº 2191 de 02/12/2020</div>
        </div>
    </section>



    <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="card border-primary border-light shadow col-sm-12 col-md-10 col-lg-8 col-xl-6 col-xxl-4 mt-0">
            <div class="card-header text-center align-items-center border-primary text-light bg-primary">
                <span>Preeencha os campos abaixo</span>
            </div>
            <div class="card-body">
                <form action="{{ route('contato.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('POST')
                    <x-alert />

                    <div class="col-12">
                        <label for="nome" class="form-label mb-1 mandatory">Nome: </label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                            id="nome" placeholder="Seu nome completo" value="{{ old('nome') }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('nome'))
                                {{ $errors->first('nome') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-8">
                        <label for="email" class="form-label mb-1 mandatory">E-mail: </label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder="Seu melhor e-mail" value="{{ old('email') }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('email'))
                                {{ $errors->first('email') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="telefone" class="form-label mb-1">Telefone: </label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone"
                            id="telefone" placeholder="Seu telefone (opcional)" value="{{ old('telefone') }}"
                            autocomplete="off">
                        <div class="invalid-feedback">
                            @if ($errors->has('telefone'))
                                {{ $errors->first('telefone') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="descricao" class="form-label mb-1 mandatory">Mensagem: </label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" type="text" name="descricao" id="descricao"
                            placeholder="Sua mensagem..." autocomplete="off" rows="4">{{ old('descricao') }}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('descricao'))
                                {{ $errors->first('descricao') }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <small><span class="text-danger">* Campo obrigatório</span></small>
                        <div>
                            <button class="spinner-light-email btn btn-success btn-sm" type="submit">
                                <i class="fa-solid fa-envelope-circle-check"></i> Enviar mensagem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
