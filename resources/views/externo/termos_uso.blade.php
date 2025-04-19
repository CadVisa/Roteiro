@extends('layouts.layout_1')

@section('content')
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="h3 roteiro-cv">Roteiro de classificação de risco sanitário</h1>
            <p class="lead description-card-cd fst-italic">Termos de uso</p>
        </div>
    </section>

    <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

        <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
            <span class="me-auto">Conheça nossos termos de uso</span>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-12 mb-3">
                    <span> {!! $documento->termos_uso !!}</span>
                </div>

                <div class="col-sm-6 mb-3">
                    <span class="fw-bold">Versão:</span><span> {{ $documento->id }}</span>
                </div>

                <div class="col-sm-6 mb-3">
                    <span class="fw-bold">Data da versão:</span><span>
                        {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}</span>
                </div>
                
            </div>
        </div>
    </div>
@endsection
